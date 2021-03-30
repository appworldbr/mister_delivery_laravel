@php 
$states =[
    'AC',
    'AL',
    'AP',
    'AM',
    'BA',
    'CE',
    'DF',
    'ES',
    'GO',
    'MA',
    'MS',
    'MT',
    'MG',
    'PA',
    'PB',
    'PR',
    'PE',
    'PI',
    'RJ',
    'RN',
    'RS',
    'RO',
    'RR',
    'SC',
    'SP',
    'SE',
    'TO',
];
 @endphp

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Zip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zip', 'Cep:') !!}
    {!! Form::text('zip', null, ['class' => 'form-control','maxlength' => 20]) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'Estado:') !!}
    {!! Form::select('state', $states, ['class' => 'form-control','maxlength' => 2]) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'Cidade:') !!}
    {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 100]) !!}
</div>

<!-- District Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district', 'Bairro:') !!}
    {!! Form::text('district', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Endereço:') !!}
    {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-3">
    {!! Form::label('number', 'Numero:') !!}
    {!! Form::text('number', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Complement Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('complement', 'Complemento:') !!}
    {!! Form::textarea('complement', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

{{-- <!-- Use Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('use_id', 'Id do usuario:') !!}
    {!! Form::select('use_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('userAddresses.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
