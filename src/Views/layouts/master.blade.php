@include('origami::layouts.partials.header')

<div id="wrapper">
	<div id="origami" class="gray" v-bind:class="{ shift: sidebar.open }">
		<div id="topbar">
			<a class="logo" href="{{ origami_url('/') }}"></a>
			<div class="openmenu" v-on:click="toggleSidebar()">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
		<div id="closeSidebar" v-bind:class="{ active: sidebar.open }" v-on:click="toggleSidebar()"></div>
		<div id="sidebar" v-bind:class="{ open: sidebar.open }">
			<a class="logo" href="{{ origami_url('/') }}"></a>
			<div class="padding">
				@if(count($modules))
					<h6>@lang('origami::global.modules')</h6>
					<ul class="menu">
						@foreach($modules as $module)

							<li class="{{ origami_active('/entries/'.$module->uid.'*') }}">
								<a href="{{ origami_url('/entries/'.$module->uid) }}">{{ $module->name }}
									@if($module->entries->count())
										<small>{{ $module->entries->count() }}</small>
									@endif
								</a>
							</li>

						@endforeach
					</ul>
				@endif

				@if($me->admin)
				<h6>@lang('origami::global.admin_area')</h6>
				<ul class="menu">
					<li class="{{ origami_active('/modules*') }}">
						<a href="{{ origami_url('/modules') }}">@lang('origami::global.modules')
							@if($counters['modules'])<small>{{ $counters['modules'] }}</small>@endif
						</a>
					</li>
					<li class="{{ origami_active('/users*') }}"><a href="{{ origami_url('/users') }}">@lang('origami::global.users')<small>{{ $counters['users'] }}</small></a></li>
				</ul>
				@endif
				<ul class="icons">
					<li>
						<a href="{{ origami_url('/logout') }}"><svg class="icon"><use xlink:href="#icon-logout"/></use></svg></a>
					</li>
				</ul>
			</div>
		</div>
		<div id="main">
			@yield('content')
		</div>
	</div>
</div>

@include('origami::layouts.partials.footer')
