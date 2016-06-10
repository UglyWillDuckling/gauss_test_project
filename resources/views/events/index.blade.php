@extends('templates.default')
@section('title')
    events
@stop

@section('content')
    <div class="col-lg-8">
        @if (!$events->count())
            <h3>no upcoming events.</h3>
        @endif

        @foreach ($events as $event)

        <div class="media@if ($event->locked) {{ ' locked' }} @endif">
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
                
                @if ($status == 'friends' && $event->locked == false)  
                    <?php 

                        $answers= ['moze' => 0, 'ne moze' => 0, 'svejedno mi je' => 0];
                        foreach($event->votes as $vote)
                        {
                            $answers[$vote->answer]++;
                            if($vote->user_id == Auth::user()->id) $userVote = $vote->answer;
                        }
                    ?>

                    <p>
                        <a href="{{ route('events.vote', [$event->id, 'moze']) }}" 
                        class="@if($userVote == 'moze'){{ 'selected' }} @endif">
                            moze
                        </a><span class="numberCircle">{{ $answers['moze']}}</span>

                        <a href="{{ route('events.vote', [$event->id, 'ne moze']) }}"  
                        class="@if($userVote == 'ne moze'){{ 'selected' }} @endif">
                            ne moze
                        </a><span class="numberCircle">{{ $answers['ne moze']}}</span>

                        <a href="{{ route('events.vote', [$event->id, 'svejedno mi je']) }}" 
                        class="@if($userVote == 'svejedno mi je'){{ 'selected' }} @endif">
                            nije me briga
                        </a><span class="numberCircle">{{ $answers['svejedno mi je']}}</span>
                    </p>
                @endif
            </div>
        </div>
        @endforeach
    </div> 

     <div class="col-lg-4">
        @if (Auth::check())
            @include('templates/partials/statuses/' . $status)
        @endif
    </div>   
@stop