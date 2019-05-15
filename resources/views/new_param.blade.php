@extends('layouts.main')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Рабочий стол</a></li>
        <li><a href="{{ route('params') }}">Параметры</a></li>
        <li class="active">Новая запись</li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- page content -->

    <div class="row">
        <h2 class="text-center">Новый параметр</h2>

        {!! Form::open(['url' => route('paramAdd'),'class'=>'form-horizontal','method'=>'POST']) !!}

        <div class="form-group">
            {!! Form::label('device_id','Оборудование:',['class' => 'col-xs-2 control-label'])   !!}
            <div class="col-xs-8">
                {!! Form::select('device_id', $devsel, old('device_id'),['class' => 'form-control','id'=>'device_id']); !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('name','Наименование:',['class' => 'col-xs-2 control-label'])   !!}
            <div class="col-xs-8">
                {!! Form::text('name',old('name'),['class' => 'form-control','placeholder'=>'Введите наименование','required'=>'','maxlength'=>'70'])!!}
                {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('val','Значение:',['class' => 'col-xs-2 control-label'])   !!}
            <div class="col-xs-8">
                {!! Form::text('val',old('val'),['class' => 'form-control','placeholder'=>'Введите значение параметра'])!!}
                {!! $errors->first('val', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                {!! Form::button('Сохранить', ['class' => 'btn btn-primary','type'=>'submit']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    </div>

@endsection

@section('user_script')
    <script>
        $("#device_id").prepend( $('<option value="0">Выберите оборудование</option>'));
        $("#device_id :first").attr("selected", "selected");
        $("#device_id :first").attr("disabled", "disabled");
    </script>
@endsection
