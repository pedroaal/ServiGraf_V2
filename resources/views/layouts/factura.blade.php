<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Factura</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
  <link href="{{ asset('css/factura.css') }}" rel="stylesheet">
</head>

<body class="A4 m-0 p-0">
  @yield('content')
</body>

<script>
  setTimeout(() => {
    window.print()
  }, 200);
</script>

</html>
