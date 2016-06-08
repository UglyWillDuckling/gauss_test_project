@extends('templates.default')


@section('title')
    friends
@stop

@section('content')
    
    <div class="col-lg-6">
        <h3>your friends:</h3>
        <hr>
         @if (!$friends->count())
            <p>you currently have no friends.</p>
        @else
            @foreach ($friends as $user)
                @include('templates/partials/userblock')
                <a href="{{ route('friends.delete', $user->username) }}" class="btn btn-primary">delete friend</a>
            @endforeach
        @endif
    </div>
    
    <div class="col-lg-6">
        <h3>pending friend requests:</h3>
        <hr>
        @if (!$requests->count())
            <p>you currently have no friend requests pending.</p>
        @else
            @foreach ($requests as $user)
                @include('templates/partials/userblock')
                <a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="btn btn-success">accept</a>
                <a href="{{ route('friends.decline', ['username' => $user->username]) }}" class="btn btn-primary">decline</a>
            @endforeach
        @endif
    </div>
@stop