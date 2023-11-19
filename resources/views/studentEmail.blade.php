<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased">
    <h2> welcome to center training  </h2>
    <p>Payment completed successfully in {{$course['name']}} starting on date {{$course['startAt']}}  </p>
    </body>
</html>
