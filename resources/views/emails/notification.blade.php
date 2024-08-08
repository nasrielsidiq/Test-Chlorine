<!DOCTYPE html>
<html>
<head>
    <title>{{ $details["title"] }}</title>
</head>
<body style="background-color: gray">
    <center>
        <h1>{{ $details["title"] }}</h1>
        <p>Name: {{ $details["name"] }}</p>
        <p>Published: {{ $details["is_publish"] }}</p>
        <i>{{  $details["message"]  }}</i>
    </center>
</body>
</html>
