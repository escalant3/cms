<!DOCTYPE html>
<html>
<head>
	<title>Instalación · ProteCMS</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/install/css/install.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/install/css/install-plugins.css') }}">

	<link rel="shortcut icon" href="/favicon.png">

	@stack('styles')
</head>
<body>

	<div class="container">

		<nav class="nav">
			<div class="nav-center">
				<img src="/assets/images/logo_original.png" alt="ProteCMS logo">
				<h4 class="title is-3">{{ trans('install.install') }}</h4>
			</div>
		</nav>

		@yield('progress')

		@yield('content')
	</div>

	<footer>
		<p class="has-text-centered">
			Copyright &copy; {{ date('Y') }} <a href="http://protecms.com" target="_blank">ProteCMS</a>. {{ trans('general.all_rights_reserved') }}.
		</p>
	</footer>

	<script type="text/javascript" src="{{ elixir('assets/install/js/app.js') }}"></script>

	@stack('scripts')
</body>
</html>
