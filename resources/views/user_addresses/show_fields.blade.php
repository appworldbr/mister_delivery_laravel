<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $userAddress->name }}</p>
</div>

<!-- Zip Field -->
<div class="form-group">
    {!! Form::label('zip', 'Zip:') !!}
    <p>{{ $userAddress->zip }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $userAddress->state }}</p>
</div>

<!-- City Field -->
<div class="form-group">
    {!! Form::label('city', 'City:') !!}
    <p>{{ $userAddress->city }}</p>
</div>

<!-- District Field -->
<div class="form-group">
    {!! Form::label('district', 'District:') !!}
    <p>{{ $userAddress->district }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $userAddress->address }}</p>
</div>

<!-- Number Field -->
<div class="form-group">
    {!! Form::label('number', 'Number:') !!}
    <p>{{ $userAddress->number }}</p>
</div>

<!-- Complement Field -->
<div class="form-group">
    {!! Form::label('complement', 'Complement:') !!}
    <p>{{ $userAddress->complement }}</p>
</div>

<!-- Is Default Field -->
<div class="form-group">
    {!! Form::label('is_default', 'Is Default:') !!}
    <p>{{ $userAddress->is_default }}</p>
</div>

<!-- Use Id Field -->
<div class="form-group">
    {!! Form::label('use_id', 'Use Id:') !!}
    <p>{{ $userAddress->use_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userAddress->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userAddress->updated_at }}</p>
</div>

