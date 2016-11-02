var $ = require('jquery')
require("jquery-ui-browserify")
var Vue = require('vue/dist/vue')
var SimpleMDE = require('simplemde')
var Vex = require('vex-js')
Vex.registerPlugin(require('vex-dialog'))
Vex.defaultOptions.className = 'vex-theme-os'
var uploadFile = require('jquery-file-upload')

$.ajaxSetup({
	headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
});

app = new Vue({
	el: '#origami',
	data: {
		sidebar: {
			open: false,
		},
		// Form elements
		user: {},
		module: {},
		field: {
			options: {
				textarea: {},
				checkbox: {},
				select: {
					options: [],
				},
				image: {},
			},
		},
		entry: {},
	},
	methods: {
		toggleSidebar: function() {
			app.sidebar.open = !app.sidebar.open;
		},

		confirm: function(message, url) {
			Vex.dialog.confirm({
				message: message,
				callback: function (value) {
					if(value) window.location.replace(url);
				}
			})
		},

		sortModules: function() {
			$(".sort-modules tbody").sortable({
				handle: ".reorder",
				axis: "y",
				placeholder: "placeholder",
				activate( event, ui ) {
					ui.item.children().not(':eq(0),:eq(1)').css('opacity',0);
				},
				stop( event, ui ) {
					ui.item.children().css('opacity',1);
					modules = $(this).sortable('toArray', { attribute: 'data-uid' });
					$.post( app.origami_url('/modules/sort'), { modules: modules });
				},
			});
		},

		sortFields: function(module_uid) {
			$(".fields").sortable({
				handle: ".reorder",
				axis: "y",
				placeholder: "field_placeholder",
				stop( event, ui ) {
					fields = $(this).sortable('toArray', { attribute: 'data-uid' });
					$.post( app.origami_url('/modules/'+module_uid+'/fields/sort'), { fields: fields });
				},
			});
		},

		sortEntries: function(module_uid) {
			$(".sort-entries tbody").sortable({
				handle: ".reorder",
				axis: "y",
				placeholder: "placeholder",
				activate( event, ui ) {
					ui.item.children().not(':eq(0),:eq(1)').css('opacity',0);
				},
				stop( event, ui ) {
					ui.item.children().css('opacity',1);
					entries = $(this).sortable('toArray', { attribute: 'data-uid' });
					$.post( app.origami_url('/entries/'+module_uid+'/sort'), { entries: entries });
				},
			});
		},

		origami_path(path) {
			return origami.path+path;
		},

		origami_url(url) {
			return origami.url+url;
		},


		field_select_add_option: function() {
			app.field.options.select.options.push({
				name: '',
				value: '',
			})
		},
		field_select_remove_option: function(index) {
			app.field.options.select.options.splice(index, 1);
		},
		field_select_sort: function() {
			$(".select-options").sortable({
				handle: ".reorder",
				axis: "y",
			});
		},


	},
	watch: {
		'field.type': function(value) {
			if(value=='select') {
				setTimeout(function() {
					app.field_select_sort();
				},200);
			}
		},
	},
})

$('.fileuploader').each(function() {
	element = $(this);
	name = $(this).data('name');
	multiple = $(this).data('multiple') == 1 ? true : false;
	module = $(this).data('module');
	sentence = multiple ? 'or drop images here' : 'or drop image here';
	$(this).children('.selectfile').uploadFile({
		multiple: multiple,
		url: app.origami_url('/entries/'+module+'/upload')+"?element="+element.attr('id')+'&field='+name,
		fileName: 'origami-image',
		acceptFiles:"image/*",
		dragDropStr: "<span><b>"+sentence+"</b></span>",
		uploadStr:"Select",
		showPreview: false,
		onSubmit: function(files) {
			var element = new RegExp('[\?&]' + 'element' + '=([^&#]*)').exec($(this).prop('url'));
			element = $('#'+element[1]);
			if(!element.data('multiple')) {
				element.find('.uploadedfiles').html('<li></li>');
			} else {
				element.find('.uploadedfiles').append($('.action-template').html());
			}
		},
		onSuccess: function(files,data,xhr,pd) {
			var element = new RegExp('[\?&]' + 'element' + '=([^&#]*)').exec($(this).prop('url'));
			element = $('#'+element[1]);
			element.find('.uploadedfiles li:not(.active):not(.placeholder)').eq(0).addClass('active').attr("data-uid", data.uid).css('background-image', 'url('+origami.content+'/'+data.path+')');
			$('input[name='+element.data('name')+']').val($('input[name='+element.data('name')+']').val()+','+data.uid);
			if(!element.data('multiple')) $('input[name='+element.data('name')+']').val(data.uid);
		},
		onError: function(files,status,errMsg,pd) {
			var element = new RegExp('[\?&]' + 'element' + '=([^&#]*)').exec($(this).prop('url'));
			element = $('#'+element[1]);
			element.find('.uploadedfiles li:not(.active):not(.placeholder)').eq(0).remove();
		},
	});
});

$(".uploadedfiles").sortable({
	handle: ".reorder",
	placeholder: "placeholder",
	stop( event, ui ) {
		name = ui.item.closest('.fileuploader').data('name');
		entries = $(this).sortable('toArray', { attribute: 'data-uid' });
		$('input[name='+name+']').val(entries.join());
	},
});



$(document).on('click','.remove-image', function() {
	uid = $(this).closest('li').data('uid');
	name = $(this).closest('.fileuploader').data('name');
	$('input[name='+name+']').val($('input[name='+name+']').val().replace(uid, ''));
	$(this).closest('li').remove();
});

var simplemde = new SimpleMDE({ element: document.getElementById("markdown") });