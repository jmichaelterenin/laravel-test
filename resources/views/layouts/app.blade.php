<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products Page</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
<body>
	<div id="app">
        <main class="py-4">
		@yield('content')
        </main>
	</div>
<!-- Include page-specific scripts -->
@stack('scripts')
</body>
</html>