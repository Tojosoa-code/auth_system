<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/public/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/icons/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<style>
    @yield('style');
</style>
<body>
    <main class="content">
        <div class="container">
            <div class="left">
                @yield('content')
            </div>
            <div class="right">
                @yield('paragraphe')
            </div>
        </div>
    </main>
    @yield('script')
</body>
</html>