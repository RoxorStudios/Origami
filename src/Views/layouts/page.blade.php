@include('origami::layouts.partials.header', ['auth'=>true])

<div class="content">
	@yield('content')
</div>


@include('origami::layouts.partials.footer')