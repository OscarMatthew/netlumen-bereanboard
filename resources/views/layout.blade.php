<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <meta charset="utf-8">
        <meta name="description" content="Ask questions about the Bible, and answer questions from the community.">
        <title>BereanBoard</title>
    </head>
    <body>
        <div class="navbar">
            <div class="container">
                <div class="row">
                    <div class="twelve columns">
                        <ul class="nav brand">
                            <li><a href="/">BereanBoard</a></li>
                        </ul>

                        <ul class="nav hamburger">
                            <li><a class="u-pointer"><i class="fa fa-bars"></i></a></li>
                        </ul>

                        <ul class="nav nav-left">
                            <li class="{{ Request::is('questions') ? 'active' : '' }}"><a href="/questions">Questions</a></li>
                            <li class="{{ Request::is('questions/create') ? 'active' : '' }}"><a href="/questions/create">Ask Question</a></li>
                        </ul>

                        <ul class="nav nav-right">
                            @if (Auth::check())
                                <li class="{{ Request::is('users*') ? 'active' : '' }}"><a href="/users">Users</a></li>
                                <li>
                                    <a class="show-dropdown">{{ Auth::user()->username }}<i class="fa fa-fw fa-caret-down"></i></a>
                                    <ul class="dropdown">
                                        <li><a href="/users/{{ Auth::user()->id }}">Profile</a></li>
                                        <li><a href="/logout">Logout</a></li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="/login">Login</a></li>
                                <li><a href="/signup">Sign Up</a></li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="twelve columns" style="padding-top: 20px; padding-bottom: 80px;">
                    @yield('content')
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/js/app.js"></script>
        @yield('javascript')
    </body>
</html>
