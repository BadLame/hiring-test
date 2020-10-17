<!doctype html>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>@yield("title", "Default title")</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset("img/favicon.png") }}">

  <!-- all css here -->
  <link rel="stylesheet" href="{{ asset("css/app.css") }}">
  @stack("styles")
</head>
<body>

<header class="header-area">
  <x-header></x-header>
</header>

@section("content")
@show

<footer class="footer-area">
  <x-footer></x-footer>
</footer>

<!-- all js here -->
<script src="{{ asset("js/app.js") }}"></script>
@stack("scripts")
{{--{{ dd(session("qwerty")) }}--}}
</body>
</html>
