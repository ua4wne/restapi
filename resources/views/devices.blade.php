@extends('layouts.main')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Рабочий стол</a></li>
        <li class="active">Оборудование</li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- page content -->
    @if (session('status'))
        <div class="row">
            <div class="alert alert-success panel-remove">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                {{ session('status') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="modal fade" id="editDevice" tabindex="-1" role="dialog" aria-labelledby="editDevice" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <h4 class="modal-title">Редактирование</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => '#','id'=>'edit_device','class'=>'form-horizontal','method'=>'POST']) !!}

                        <div class="form-group">
                            <div class="col-xs-8">
                                {!! Form::hidden('id','',['class' => 'form-control','required'=>'required','id'=>'device_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('uid','UID:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('uid',old('uid'),['class' => 'form-control','placeholder'=>'Введите UID','required','id'=>'uid','maxlength'=>'16'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name','Наименование:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('name',old('name'),['class' => 'form-control','placeholder'=>'Введите наименование','required','id'=>'name','maxlength'=>'70'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('descr','Описание:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('descr',old('descr'),['class' => 'form-control','placeholder'=>'Введите описание','id'=>'descr'])!!}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary" id="save">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addParam" tabindex="-1" role="dialog" aria-labelledby="addParam" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <h4 class="modal-title">Новый параметр</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => '#','id'=>'add_param','class'=>'form-horizontal','method'=>'POST']) !!}

                        <div class="form-group">
                            <div class="col-xs-8">
                                {!! Form::hidden('device_id','',['class' => 'form-control','required'=>'required','id'=>'dev_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name','Наименование:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('name',old('name'),['class' => 'form-control','placeholder'=>'Введите наименование','required','id'=>'pname','maxlength'=>'70'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('val','Значение:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('val',old('val'),['class' => 'form-control','placeholder'=>'Введите значение','id'=>'val'])!!}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary" id="addval">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-center">{{ $head }}</h2>
        @if($devices)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{route('deviceAdd')}}">
                            <button type="button" class="btn btn-primary btn-rounded">Новая запись</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>UID</th>
                                <th>Наименование</th>
                                <th>Описание</th>
                                <th>Дата создания</th>
                                <th>Дата обновления</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($devices as $k => $device)

                                <tr id="{{ $device->id }}">
                                    <th> {{ $device->uid}} </th>
                                    <td> <span class="badge badge-light" id="s{{ $device->id }}">{{ $device->params->count() }}</span> {{ $device->name }} </td>
                                    <td> {{ $device->descr }}</td>
                                    <td> {{ $device->created_at }}</td>
                                    <td> {{ $device->updated_at }}</td>
                                    <td style="width:140px;">
                                            <div class="form-group" role="group">
                                                <button class="btn btn-success btn-sm device_edit" type="button" data-toggle="modal" data-target="#editDevice" title = "Редактироватьть запись"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></button>
                                                <button class="btn btn-info btn-sm add_param" type="button" data-toggle="modal" data-target="#addParam" title = "Добавить параметр"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                <button class="btn btn-danger btn-sm device_delete" type="button" title = "Удалить запись"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                            </div>
                                        </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </div>
    <!-- /page content -->
@endsection

@section('user_script')

    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
            var options = {
                'backdrop' : 'true',
                'keyboard' : 'true'
            }
            $('#basicModal').modal(options);
        });

        $('#save').click(function(e){
            e.preventDefault();
            var error=0;
            $("#edit_device").find(":input").each(function() {// проверяем каждое поле ввода в форме
                if($(this).attr("required")=='required'){ //обязательное для заполнения поле формы?
                    if(!$(this).val()){// если поле пустое
                        $(this).css('border', '1px solid red');// устанавливаем рамку красного цвета
                        error=1;// определяем индекс ошибки
                    }
                    else{
                        $(this).css('border', '1px solid green');// устанавливаем рамку зеленого цвета
                    }

                }
            })
            if(error){
                alert("Необходимо заполнять все доступные поля!");
                return false;
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: '{{ route('editDevice') }}',
                    data: $('#edit_device').serialize(),
                    success: function(res){
                        //alert(res);
                        if(res=='OK')
                            location.reload(true);
                        if(res=='ERR')
                            alert('Ошибка обновления данных.');
                        if(res=='NO')
                            alert('Выполнение операции запрещено!');
                        else{
                            alert('Ошибка валидации данных');
                        }
                    }/*,
                    error: function(xhr, response){
                        alert('Error! '+ xhr.responseText);
                    }*/
                });
            }
        });

        $('#addval').click(function(e){
            e.preventDefault();
            var error=0;
            $("#add_param").find(":input").each(function() {// проверяем каждое поле ввода в форме
                if($(this).attr("required")=='required'){ //обязательное для заполнения поле формы?
                    if(!$(this).val()){// если поле пустое
                        $(this).css('border', '1px solid red');// устанавливаем рамку красного цвета
                        error=1;// определяем индекс ошибки
                    }
                    else{
                        $(this).css('border', '1px solid green');// устанавливаем рамку зеленого цвета
                    }

                }
            })
            if(error){
                alert("Необходимо заполнять все доступные поля!");
                return false;
            }
            else{
                var id = $('#dev_id').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('addParam') }}',
                    data: $('#add_param').serialize(),
                    success: function(res){
                        //alert(res);
                        if(res=='ERR')
                            alert('Ошибка обновления данных.');
                        else if(res=='DBL'){
                            alert('Параметр '+$('#pname').val()+' уже существует!');
                            $('#pname').val('');
                        }
                        else{
                            $('#s'+id).html("").html(res);
                            $('#pname').val('');
                        }
                    },
                    error: function(xhr, response){
                        alert('Error! '+ xhr.responseText);
                    }
                });
            }
        });

        $('.device_edit').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            var uid = $(this).parent().parent().prevAll().eq(4).text();
            var name = $(this).parent().parent().prevAll().eq(2).text();
            var descr = $(this).parent().parent().prevAll().eq(3).text();

            $('#uid').val(uid);
            $('#name').val(name);
            $('#descr').val(descr);
            $('#device_id').val(id);
        });

        $('.add_param').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            $('#dev_id').val(id);
        });

        $('.device_delete').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            var x = confirm("Выбранное устройство будет удалено. Продолжить (Да/Нет)?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteDevice') }}',
                    data: {'id':id},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res){
                        //alert(res);
                        if(res=='OK')
                            $('#'+id).hide();
                        if(res=='NO')
                            alert('Выполнение операции запрещено!');
                        if(res=='ERR')
                            alert('При выполнении операции возникла ошибка!');
                    },
                    error: function(xhr, response){
                        alert('Error! '+ xhr.responseText);
                    }
                });
            }
            else {
                return false;
            }
        });

    </script>
@endsection
