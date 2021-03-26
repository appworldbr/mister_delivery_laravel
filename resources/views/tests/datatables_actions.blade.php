{!! Form::open(['route' => ['tests.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('tests.show', $id) }}" class='btn btn-ghost-success'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('tests.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Tem certeza?')"
    ]) !!}
</div>
{!! Form::close() !!}
