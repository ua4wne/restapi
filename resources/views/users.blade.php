@extends('layouts.main')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Рабочий стол</a></li>
        <li class="active">Пользователи</li>
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
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <h4 class="modal-title">Редактирование</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => '#','id'=>'edit_login','class'=>'form-horizontal','method'=>'POST']) !!}

                        <div class="form-group">
                            <div class="col-xs-8">
                                {!! Form::hidden('id','',['class' => 'form-control','required'=>'required','id'=>'login_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name','ФИО:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('name',old('name'),['class' => 'form-control','placeholder'=>'Введите ФИО','required','id'=>'name'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email','E-mail:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::email('email',old('email'),['class' => 'form-control','placeholder'=>'Введите E-mail','required','id'=>'email'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('login','Логин:',['class' => 'col-xs-3 control-label'])   !!}
                            <div class="col-xs-8">
                                {!! Form::text('login',old('login'),['class' => 'form-control','placeholder'=>'Введите логин','required','id'=>'login'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('active', 'Статус:',['class'=>'col-xs-3 control-label']) !!}
                            <div class="col-xs-8">
                                {!! Form::select('active', array('0'=>'Не активен','1'=>'Активен'), old('active'),['class' => 'form-control','required','id'=>'active']); !!}
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
        @if($users)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{route('userAdd')}}">
                            <button type="button" class="btn btn-primary btn-rounded">Новая запись</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Аватар</th>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th>Логин</th>
                    <th>Активность</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $k => $user)

                    <tr>
                        @if($user->image)
                            <td style="width:70px;"><img src="{{ $user->image }}" alt="..." class="img-responsive center-block"></td>
                        @else
                            <td style="width:70px;"><img src="/images/male.png" alt="..." class="img-responsive center-block"></td>
                        @endif
                        <th>{{ $user->name }}</th>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->login }}</td>
                        <td>
                            @if($user->isOnline())
                                <span role="button" class="label label-success">Online</span>
                            @else
                                <span role="button" class="label label-danger">Offline</span>
                            @endif
                        </td>
                        @if($user->active)
                            <td><span role="button" class="label label-success" id="{{ $user->id }}">Активен</span></td>
                        @else
                            <td><span role="button" class="label label-danger" id="{{ $user->id }}">Не активен</span></td>
                        @endif
                        @if($user->id==1)
                            <td style="width:150px;">
                                <div class="form-group" role="group">
                                    <button class="btn btn-success btn-sm login_edit" type="button" data-toggle="modal" data-target="#editUser" title = "Редактироватьть запись"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></button>
                                </div>
                            </td>
                        @else
                            <td style="width:200px;">
                                <div class="form-group" role="group">
                                    <button class="btn btn-success btn-sm login_edit" type="button" data-toggle="modal" data-target="#editUser" title = "Редактироватьть запись"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></button>
                                    <a href="{{ route('userReset',['id'=>$user->id]) }}" class="btn btn-warning btn-sm" type="button" title = "Сбросить пароль"><i class="fa fa-recycle fa-lg" aria-hidden="true"></i></a>
                                    <button class="btn btn-danger btn-sm login_delete" type="button" title = "Удалить запись"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                </div>
                            </td>
                        @endif
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
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
            $("#edit_login").find(":input").each(function() {// проверяем каждое поле ввода в форме
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
                    url: '{{ route('editLogin') }}',
                    data: $('#edit_login').serialize(),
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
                    }
                });
            }
        });

        $('.label-success').click(function(){
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '{{ route('switchLogin') }}',
                data: {'id':id,'active':0},
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    //alert(res);
                    if(res=='OK'){
                        location.reload(true);
                    }
                    if(res=='NO')
                        alert('Выполнение операции запрещено!');
                    else
                        alert('Ошибка операции.');
                }
            });
        });

        $('.label-danger').click(function(){
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '{{ route('switchLogin') }}',
                data: {'id':id,'active':1},
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    //alert(res);
                    if(res=='OK'){
                        location.reload(true);
                    }
                    if(res=='NO')
                        alert('Выполнение операции запрещено!');
                    else
                        alert('Ошибка операции.');
                }
            });
        });

        $('.login_edit').click(function(){
            var id = $(this).parent().parent().prevAll().eq(0).find('span').attr("id");
            var status = $(this).parent().parent().prevAll().eq(0).text();
            var login = $(this).parent().parent().prevAll().eq(2).text();
            var email = $(this).parent().parent().prevAll().eq(3).text();
            var name = $(this).parent().parent().prevAll().eq(4).text();
            if(id==1){
                $("#active :contains("+status+")").attr("selected", "selected");
                $("#active").attr("disabled", true);
            }
            else {
                $("#active").attr("disabled", false);
                $("#active :contains("+status+")").attr("selected", "selected");
            }
            $('#email').val(email);
            $('#login').val(login);
            $('#name').val(name);
            $('#login_id').val(id);
        });

        $('.login_delete').click(function(){
            var id = $(this).parent().parent().prevAll().eq(0).find('span').attr("id");
            var x = confirm("Выбраный логин будет удален. Продолжить (Да/Нет)?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteLogin') }}',
                    data: {'id':id},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res){
                        //alert(res);
                        if(res=='OK')
                            $('#'+id).parent().parent().hide();
                        if(res=='NO')
                            alert('Выполнение операции запрещено!');
                    }
                });
            }
            else {
                return false;
            }
        });

    </script>
@endsection
