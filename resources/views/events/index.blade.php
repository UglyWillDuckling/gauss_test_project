@extends('templates.default')

@section('content')
    <div class="col-lg-6">
        @foreach ($events as $event)
            <div >
                <h3>{{ $event->title }}</h3>
                <p>
                    {{ $event->descripton }}
                </p>
            </div>
        @endforeach
    </div> 

     <div class="col-lg-6">
        friendship status<br>
        delete<br>
        accept<br>
        send request<br>
    </div>   
@stop