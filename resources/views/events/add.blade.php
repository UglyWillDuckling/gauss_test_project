@extends('templates.default')
@section('title')
    new Event
@stop

@section('css')
    <link rel="stylesheet" href="http://127.0.0.1/gauss_test_project/public/css/bootstrap-datetimepicker.min.css">
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
            <!--<input type="datetime-local" name="time" class="form-control">-->
            
                <div class="input-append date form_datetime">
                    <input size="16" type="text" value="" readonly name="time" class="form-control">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
            
            <span class="help-block">najmanje 2 sata od trenutnog vremena.</span> 
        </div>
        <input type="submit" value="create event" class="btn btn-primary">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@stop

@section('js')
    <script src="http://127.0.0.1/gauss_test_project/public/js/dateTimePicker/bootstrap-datetimepicker.min.js"></script>
    <!--script for showing bootstraps date time picker-->
    <script type="text/javascript">
        $(".form_datetime").datetimepicker({
            format: "dd MM yyyy - hh:ii"
        });
    </script> 
@stop