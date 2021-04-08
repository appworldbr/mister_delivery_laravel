<!-- Initial Zip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('initial_zip', 'Cep Inicial:') !!}
    {!! Form::text('initial_zip', null, ['class' => 'form-control', 'data-mask' =>"00000-000"]) !!}
</div>

<!-- Final Zip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('final_zip', 'Cep Final:') !!}
    {!! Form::text('final_zip', null, ['class' => 'form-control', 'data-mask' =>"00000-000"]) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Preço do frete:') !!}
    {!! Form::text('price', null, ['class' => 'form-control', 'data-mask'=> 'R$ 00,00']) !!}
</div>

<!-- Prevent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prevent', 'Area de risco:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('prevent', 0) !!}
        {!! Form::checkbox('prevent', '1', null) !!}
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('deliveryAreas.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
@endpush
