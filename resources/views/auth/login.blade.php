<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invenku - Pusmendik</title>
  <link rel="icon" href="{{ asset('assets/img/logokemdikbud.png') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;700;800;900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

</head>

<body>

  <div class="box-login">
    <div class="box-img">
      <div class="child-img"></div>
      <div class="text-img">
        <h1>Aplikasi Invenku</h1>
        <p>Aplikasi permintaan dan peminjaman barang milik negara sub-bagian tata usaha rumah tangga.</p>
        <img class="maskot" src="{{ asset('assets/img/maskot.png') }}" alt="">
      </div>
    </div>
    <form action="/login" method="POST" class="form-login">
      @csrf
      <img class="logo" src="{{ asset('assets/img/logokemdikbud.png') }}" alt="" >
      <h1 class="mb-4">Login</h1>
      @if (session()->has('error'))
        <p style="color: #ed5646; font-size: 14px">{{ session('error') }}</p>
      @endif
      <div class="box-input">
        <i class="bi bi-person-fill"></i>
        <input type="text" name="email" class="@error('email') is-invalid @enderror" placeholder="Email"
          value="{{ old('email') }}">
      </div>
      @error('email')
        <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
      @enderror
      <div class="box-input mt-2">
        <i class="bi bi-lock-fill"></i>
        <input type="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Password">
      </div>
      @error('password')
        <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
      @enderror
      <button type="submit" class="mt-4 btn-login">Login</button>
      {{-- <p class="mt-3">don't have an account yet? <br> <a href="/register"
          class="text-decoration-none text-info">Register Now!</a></p> --}}
    </form>
  </div>

</body>

</html>
