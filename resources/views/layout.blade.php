<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title') | 1020</title>

    <!-- Bootstrap -->
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        @include('menu')
        @yield('body')
    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset("js/jquery.js") }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset("js/bootstrap.min.js") }}"></script>
</body>
</html>