    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
             <a href="{{ route('home') }}" class="navbar-brand">Od sumraka do zore</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav leftMargin">
                   
                     @if (Auth::check())

                        <li>
                            <a href="{{ route('events', ['username' => Auth::user()->username ]) }}">         my Events
                            </a>
                        </li>
                        <li><a href="{{ route('events.add') }}">add event</a></li>
                        <li><a href="{{ route('friends') }}">Friends</a></li>
                    @endif           
                </ul>
                <form class="navbar-form navbar-left" method="POST" role="search" action="{{ route('search') }}">
                    <div class="form-group">
                        <input type="text" name="term" class="form-control" placeholder="find people">
                        <button type="submit" class="btn btn-default">Search </button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><a href="{{ route('auth.signout') }}">signout</a></li>
                    <li><a href="">update profile</a></li>
                @else
                    <li><a href="{{ route('auth.signup') }}">signup</a></li>
                    <li><a href="{{ route('auth.signin') }}">sign In</a></li>
                @endif
                </ul>
            </div>
        </div>
    </nav>