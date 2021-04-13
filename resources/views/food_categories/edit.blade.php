@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('foodCategories.index') !!}">Categoria de Comida</a>
          </li>
          <li class="breadcrumb-item active">Editar</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Editar Catgoria de Comida</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($foodCategory, ['route' => ['foodCategories.update', $foodCategory->id], 'method' => 'patch']) !!}

                              @include('food_categories.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection