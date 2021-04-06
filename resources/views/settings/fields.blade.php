@php

$setting = setting([
    'name', 
    'description',
    'time_work',
    'adress',
]);

@endphp

<div id="logo">
    <file-uploader
            :media="{{ get_setting_upload('logo') }}"
            :unlimited="false"
            max="1"
            collection="logo"
            :tokens="{{ json_encode(old('media', [])) }}"
            label="Logo"
            notes="Arquivos Suportados: jpeg, png, jpg, gif"
            accept="image/jpeg,image/png,image/jpg,image/gif"
    ></file-uploader>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-file-uploader"></script>
<script>
  new Vue({
    el: '#logo'
  })
</script>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $setting['name'], ['class' => 'form-control','maxlength' => 27]) !!}
</div>
<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', $setting['description'], ['class' => 'form-control','maxlength' => 100]) !!}
</div>
<!-- Adress Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adress', 'Endereço:') !!}
    {!! Form::text('adress', $setting['adress'], ['class' => 'form-control','maxlength' => 100]) !!}
</div>




<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
