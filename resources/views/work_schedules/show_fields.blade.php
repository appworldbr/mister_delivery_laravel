<!-- Weekday Field -->
<div class="form-group">
    {!! Form::label('weekday', 'Weekday:') !!}
    <p>{{ $workSchedule->weekday }}</p>
</div>

<!-- Start Time Field -->
<div class="form-group">
    {!! Form::label('start_time', 'Start Time:') !!}
    <p>{{ $workSchedule->start_time }}</p>
</div>

<!-- End Time Field -->
<div class="form-group">
    {!! Form::label('end_time', 'End Time:') !!}
    <p>{{ $workSchedule->end_time }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $workSchedule->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $workSchedule->updated_at }}</p>
</div>

