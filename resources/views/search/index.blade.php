@extends('templates.default')
@section('title')
    events
@stop

@section('content')
    
    <h3>search results for "{{ $term }}":</h3>
    <hr>

    @foreach ($users as $user)
        @include('templates/partials/userblock')
    @endforeach
@stop