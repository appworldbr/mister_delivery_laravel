@php

$setting = setting(['name', 'description'])

@endphp

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $setting['name'], ['class' => 'form-control','maxlength' => 27]) !!}
</div>
<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Nome:') !!}
    {!! Form::textarea('description', $setting['description'], ['class' => 'form-control','maxlength' => 27]) !!}
</div>
<!-- Time Work Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Horarios de Funcionamentos:') !!}
    {!! Form::textarea('name', $setting['time_work'], ['class' => 'form-control','maxlength' => 1000]) !!}
</div>




{{--
<!-- Adress Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Endereço:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 27]) !!}
</div>
<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Descrição:') !!}
    {!! Form::textarea('name', null, ['class' => 'form-control','maxlength' => 1000]) !!}
</div>

<!-- Time Work Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Horarios de Funcionamentos:') !!}
    {!! Form::textarea('name', null, ['class' => 'form-control','maxlength' => 1000]) !!}
</div> --}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancel</a>
</div>
