<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{{ $foodCategory->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Descrição:') !!}
    <p>{{ $foodCategory->description }}</p>
</div>

<!-- Has Details Field -->
<div class="form-group">
    {!! Form::label('has_details', 'Tem detalhes:') !!}
    <p>{{ $foodCategory->has_detailst?'Sim':'Não' }}</p>
</div>



