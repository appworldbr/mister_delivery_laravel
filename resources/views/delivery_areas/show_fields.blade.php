<!-- Initial Zip Field -->
<div class="form-group">
    {!! Form::label('initial_zip', 'Cep Inicial:') !!}
    <p>{{ zip_format($deliveryArea->initial_zip) }}</p>
</div>

<!-- Final Zip Field -->
<div class="form-group">
    {!! Form::label('final_zip', 'Cep Final:') !!}
    <p>{{ zip_format($deliveryArea->final_zip) }}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Frete:') !!}
    <p>{{ float_to_price($deliveryArea->price) }}</p>
</div>

<!-- Prevent Field -->
<div class="form-group">
    {!! Form::label('prevent', 'Evitavel:') !!}
    <p>{{ $deliveryArea->prevent?'Sim':'Não' }}</p>
</div>



