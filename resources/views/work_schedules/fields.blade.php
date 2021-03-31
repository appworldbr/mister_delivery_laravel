<!-- Weekday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weekday', 'Weekday:') !!}
    {!! Form::select('weekday', ], null, ['class' => 'form-control']) !!}
</div>

<!-- Start-Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start-time', 'Start-Time:') !!}
    {!! Form::select('start-time', ], null, ['class' => 'form-control']) !!}
</div>

<!-- End Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_time', 'End Time:') !!}
    {!! Form::select('end_time', ], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('workSchedules.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
