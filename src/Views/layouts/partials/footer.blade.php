	<script>
		var app
		var origami = {
			path: "{{ origami_path() }}",
			url: "{{ origami_url() }}",
			content: "{{ origami_content_url() }}",
		}
	</script>
	<script src="{{ asset('vendor/origami/js/origami.js') }}"></script>
	@yield('javascript')
</body>
</html>