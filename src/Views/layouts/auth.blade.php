@include('origami::layouts.partials.header', ['auth'=>true])

<div id="wrapper">
	<div id="origami">
		<div id="locked">
			<div class="content">
				@yield('content')
			</div>
			<div class="credits">made by <a href="http://www.roxorstudios.com" target="_blank">Roxor Studios</a></div>
		</div>	
	</div>
</div>

@include('origami::layouts.partials.footer')