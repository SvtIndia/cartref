<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ Voyager::image(setting('site.site_icon')) }}">
    <!-- Flaticon css -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-thin-straight/css/uicons-thin-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <!--tailwind stylesheet -->
    <link href="{{ asset('vue/css/app.css') }}" rel="stylesheet">

    <style>
        #toast-div{
            position: fixed;
            bottom: 15px;
            left: 15px;
            z-index: 99;
        }
    </style>
    <title>Admin | {{ config('app.name') }}</title>
</head>

<body class="bg-primary-50">
    <!--Vue App-->
    <div id="app">
        <navbar></navbar>
        <side-bar></side-bar>
        <div id="main" class="mt-12 xl:mt-20 md:pl-[3.35rem] mb-6">
            <router-view></router-view>
        </div>
    </div>

    <!-- Toast msg -->
    <div id="toast-div"></div>

    <!--script -->
    <script src="{{ asset('vue/js/app.js') }}" defer></script>

</body>

</html>
