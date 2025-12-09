<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher - SRIS</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .material-icons { font-size: 18px; line-height: 1; vertical-align: middle; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 text-white min-h-screen overflow-x-hidden">

    @include('layouts.partials.teacher-nav')

<main class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-indigo-950 text-gray-100">
    @yield('content')
</main>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('alert'))
        <script>
            Swal.fire({
                icon: "{{ session('alert')['type'] }}",
                title: "{{ session('alert')['title'] }}",
                text: "{{ session('alert')['message'] }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>