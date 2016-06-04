<!DOCTYPE html>
<html>

<head>
    <title>Ongaku :: Music manager!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link href='{{$rootDir}}/fonts/fonts.css' rel='stylesheet' type='text/css'>
    <link href="{{$rootDir}}/css/screen.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="{{$rootDir}}/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="{{$rootDir}}/js/modernizr.js"></script>
    <script type="text/javascript" src="{{$rootDir}}/js/app.js"></script>
</head>

<body>
    <div id="container">
        <a href="#content" id="gotocontent">Jump to content</a>
        <header>
            <a href="{{$root}}" id="logo">ongaku</a>

            <ul id="menu">
                <li><a href="{{$root}}">Home</a></li>
                {if isset($user) }
                <li><a href="{{$root}}/concerts">Concerts</a></li>
                <li><a href="{{$root}}/user/logout">Log out</a></li>
                {else}
                <li><a href="{{$root}}/user/login">Login</a></li>
                <li><a href="{{$root}}/user/register">Register</a></li>
                {/if}
            </ul>
            {if isset($userpanel) }
            <div id="userpanel">
            {{$userpanel}}
            </div>
            {/if}
            <div class="clearfix">&nbsp;</div>
        </header>
        <div id="content">
        {{$content}}
        </div>
    </div>
</body>

</html>
