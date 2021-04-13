<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 127]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','maxlength' => 10000]) !!}
</div>

<div class="form-group col-sm-6 ">
    {!! Form::label('has_details', 'Esse produto tem detalhes:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('has_details', 0) !!}
        {!! Form::checkbox('has_details', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('foodCategories.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
