<!-- Image Field -->
<div id="app">
    <file-uploader
            :media="{{ isset($test) ? $test->getMediaResource('avatars') : '[]' }}"
            :unlimited="true"
            collection="avatars"
            :tokens="{{ json_encode(old('media', [])) }}"
            label="Imagem"
            notes="Arquivos Suportados: jpeg, png,jpg,gif"
            accept="image/jpeg,image/png,image/jpg,image/gif"
    ></file-uploader>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-file-uploader"></script>
    <script>
    new Vue({
        el: '#app'
    })
    </script>
@endpush

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 27]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('tests.index') }}" class="btn btn-secondary">Cancel</a>
</div>
