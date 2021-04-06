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
    {!! Form::label('weekday', 'Dia da Semana:') !!}
    {!! Form::select('weekday', $weeks, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('start_time', 'Hora Início:') !!}
    {!! Form::text('start_time', null, ['class' => 'form-control timepicker', 'maxlength' => 127 ]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('end_time', 'Hora Término:') !!}
    {!! Form::text('end_time', null, ['class' => 'form-control timepicker2','maxlength' => 127]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('workSchedules.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

@push('head')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 30,
        minTime: '0:00',
        maxTime: '23:59',
        defaultTime: '0',
        startTime: '0:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
    $('.timepicker2').timepicker({
        timeFormat: 'H:mm',
        interval: 30,
        minTime: '0:00',
        maxTime: '23:59',
        defaultTime: '5:00',
        startTime: '0:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
</script>
@endpush