<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
    {{ HTML::style('assets/bootstrap/css/bootstrap.css') }}
    {{ HTML::style('assets/bootstrap/css/bootstrap-responsive.css') }}
    {{ HTML::style('assets/stylesheets/style.css') }} 
  </head>

  <body>
    
    @yield('pageContent')

    <!-- javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script('assets/javascript/jQuery.js') }} 
    {{ HTML::script('assets/javascript/poll.js') }} 
    {{ HTML::script('assets/bootstrap/js/bootstrap.min.js') }} 
    {{ HTML::script('assets/javascript/Chart.js')}}

    @yield('javascripts')
  </body>
</html>
