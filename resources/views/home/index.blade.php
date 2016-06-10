@extends('templates.default')

@section('title')
    home
@stop

@section('content')
    <h3 class="text-center">Upcoming events</h3>
    <div class="col-lg-1">
    </div>

    <div class="col-lg-6">
    @foreach ($events as $event)
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">{{ $event->title }}
                    <small>
                    <a href="{{ route('events', [$event->user->username]) }}">{{ $event->user->username }}</a>   
                    </small>
                </h4>
                <p>
                    {{ $event->description }} 
                </p>     
                <p>vrijeme i lokacija:{{ $event->location }}, {{ $event->when->diffForHumans() }}</p>      
            </div>
        </div>
    @endforeach
    </div>
   
@stop