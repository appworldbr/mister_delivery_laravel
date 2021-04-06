<!-- Initial Zip Field -->
<div class="form-group">
    {!! Form::label('initial_zip', 'Initial Zip:') !!}
    <p>{{ $deliveryArea->initial_zip }}</p>
</div>

<!-- Final Zip Field -->
<div class="form-group">
    {!! Form::label('final_zip', 'Final Zip:') !!}
    <p>{{ $deliveryArea->final_zip }}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $deliveryArea->price }}</p>
</div>

<!-- Prevent Field -->
<div class="form-group">
    {!! Form::label('prevent', 'Prevent:') !!}
    <p>{{ $deliveryArea->prevent }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $deliveryArea->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $deliveryArea->updated_at }}</p>
</div>

