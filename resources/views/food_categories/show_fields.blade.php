<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $foodCategory->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $foodCategory->description }}</p>
</div>

<!-- Has Details Field -->
<div class="form-group">
    {!! Form::label('has_details', 'Has Details:') !!}
    <p>{{ $foodCategory->has_details }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $foodCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $foodCategory->updated_at }}</p>
</div>

