<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    @yield('scripts')

</body>
</html>
