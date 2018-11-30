<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @if (strpos(Request::path(), '/add') !== false)
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    @endif
    <title>@yield('title') | ランチマップ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    @yield('append_css')

    <script src="/flatui/dist/js/vendor/jquery.min.js"></script>
    @yield('append_js')
  </head>
  @if (Request::url() == Request::root())
  <body onload="initialize()">
  @else
  <body>
  @endif
    <div class="wrapper">
    @section('nav')

    @show

    @yield('content')

  </div><!-- class wrapper -->
    @yield('append_lower_js')

  </body>
</html>
