<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" href="{{ asset('assets/img/logokemdikbud.png') }}">

  <title>Invenku - Pusmendik</title>

  @stack('css')

  <!-- CDN Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>

  @include('partials.sidebar')

  @include('partials.header')

  @yield('content')
  
  @stack('js')

  @include('sweetalert::alert')
  
</body>

</html>
