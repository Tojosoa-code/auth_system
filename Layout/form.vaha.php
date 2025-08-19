<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/public/assets/css/form.css">
    <link rel="stylesheet" href="/public/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/icons/css/all.min.css">
</head>
<body>
    @yield('left')
    @yield('right')
    @yield('script')
</body>
</html>