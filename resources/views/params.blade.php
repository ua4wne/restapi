@extends('layouts.main')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Рабочий стол</a></li>
        <li><a href="{{ route('devices') }}">Оборудование</a></li>
        <li class="active">Параметры</li>
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
        <div class="modal fade" id="editParam" tabindex="-1" role="dialog" aria-labelledby="editParam" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <h4 class="modal-title">Редактирование</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => '#','id'=>'edit_param','class'=>'form-horizontal','method'=>'POST']) !!}

                        <div class="form-group">
                            <div class="col-xs-8">
                                {!! Form::hidden('id','',['class' => 'form-control','required'=>'required','id'=>'param_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name','Наименование:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('name',old('name'),['class' => 'form-control','placeholder'=>'Введите наименование','required','id'=>'name','maxlength'=>'70'])!!}
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
                        <button type="button" class="btn btn-primary" id="save">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-center">{{ $head }}</h2>
        @if($params)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{route('paramAdd')}}">
                            <button type="button" class="btn btn-primary btn-rounded">Новая запись</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Оборудование</th>
                                <th>Наименование</th>
                                <th>Значение</th>
                                <th>Дата создания</th>
                                <th>Дата обновления</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($params as $k => $param)

                                <tr id="{{ $param->id }}">
                                    <th> {{ $param->devices->name }} </th>
                                    <td> {{ $param->name }}</td>
                                    <td> {{ $param->val }}</td>
                                    <td> {{ $param->created_at }}</td>
                                    <td> {{ $param->updated_at }}</td>
                                    <td style="width:90px;">
                                        <div class="form-group" role="group">
                                            <button class="btn btn-success btn-sm param_edit" type="button" data-toggle="modal" data-target="#editParam" title = "Редактироватьть запись"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></button>
                                            <button class="btn btn-danger btn-sm param_delete" type="button" title = "Удалить запись"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
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
            $("#edit_param").find(":input").each(function() {// проверяем каждое поле ввода в форме
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
                    url: '{{ route('editParam') }}',
                    data: $('#edit_param').serialize(),
                    success: function(res){
                        //alert(res);
                        if(res=='OK'){
                            var name = $('#name').val();
                            var val = $('#val').val();
                            var id = $('#param_id').val();
                            $("#"+id).children('td').first().next().text(val);
                            $("#"+id).children('td').first().text(name);
                        }
                        if(res=='ERR')
                            alert('Ошибка обновления данных.');
                        if(res=='NO')
                            alert('Выполнение операции запрещено!');
                    },
                    error: function(xhr, response){
                        alert('Error! '+ xhr.responseText);
                    }
                });
            }
        });

        $('.param_edit').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            var name = $(this).parent().parent().prevAll().eq(3).text();
            var val = $(this).parent().parent().prevAll().eq(2).text();
            //var descr = $(this).parent().parent().prevAll().eq(3).text();

            $('#name').val(name);
            $('#val').val(val);
            $('#param_id').val(id);
        });

        $('.param_delete').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            var x = confirm("Выбранный параметр будет удален. Продолжить (Да/Нет)?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteParam') }}',
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
