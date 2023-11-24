<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

<body class="bg-green-50">
    <div id="app">
        <navbar></navbar>
        <side-bar></side-bar>
        <div id="main" class="mt-12 xl:mt-20 md:pl-[3.35rem] mb-6">
            <router-view></router-view>
        </div>
    </div>
    <div id="toast-div"></div>

    <!--script -->
    <script src="{{ asset('vue/js/app.js') }}"></script>
    <!--jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous">
    </script>
</body>

</html>
