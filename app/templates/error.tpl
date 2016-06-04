<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Ongaku :: Music manager!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link href='{{$rootDir}}/fonts/fonts.css' rel='stylesheet' type='text/css'>
    <link href="{{$rootDir}}/css/screen.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="{{$rootDir}}/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="{{$rootDir}}/js/app.js"></script>
</head>

<body>
    <div id="container">
        <a href="#content" id="gotocontent">Jump to content</a>
        <header>
            <a href="{{$root}}" id="logo">ongaku</a>

            <ul id="menu">
                <li><a href="{{$root}}">Home</a></li>
            </ul>
            {if isset($userpanel) }
            <div id="userpanel">
            {{$userpanel}}
            </div>
            {/if}
        </header>
        <div id="content">
        {{$content}}
        </div>
    </div>
</body>

</html>
