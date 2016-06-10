@extends('templates.default')
@section('title')
    new Event
@stop

@section('content')
    <h2 class="text-center">Create a new event</h2>

    <form action="{{ route('events.add') }}" method="POST" role="form">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" 
            cols="30" rows="7" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" class="form-control">
        </div>
        <div class="form-group">
            <label for="time">time:</label>
            <input type="datetime-local" name="time" class="form-control">
            <!--
                <div class="input-append date form_datetime">
                    <input size="16" type="text" value="" readonly>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
            -->
        </div>
        <input type="submit" value="create event" class="btn btn-primary">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

<!--script for showing bootstraps date time picker-->
<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "dd MM yyyy - hh:ii"
    });
</script> 
@stop