@php

$weeks = [
    'Domingo',
    'Segunda',
    'Terça',
    'Quarta',
    'Quinta',
    'Sexta',
    'Sábado',
];

@endphp

<div class="form-group col-sm-6">
    {!! Form::label('weekday', 'Weekday:') !!}
    {!! Form::select('weekday', $weeks, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('start_time', 'Hora Início:') !!}
    {!! Form::text('start_time', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('end_time', 'Hora Término:') !!}
    {!! Form::text('end_time', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('workSchedules.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
