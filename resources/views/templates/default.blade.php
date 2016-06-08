<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>od sumraka do zore | @yield('title')</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="http://127.0.0.1/gauss_test_project/public/css/app.css">
</head>
<body>
    <div class="container">       
        @include('templates.partials.alert')
        @include('templates.partials.navigation')
        @yield('content')
    </div>
</body>
</html>