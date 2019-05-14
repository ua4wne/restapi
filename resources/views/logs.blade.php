@extends('layouts.main')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Рабочий стол</a></li>
        <li class="active">Журнал событий</li>
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
        <h2 class="text-center">{{ $head }}</h2>
        @if($logs)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="{{ route('deleteLog') }}">
                            <button type="button" class="btn btn-danger btn-rounded" id="btn_clear">Очистить журнал</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Тип события</th>
                                <th>Инициатор</th>
                                <th>Описание</th>
                                <th>IP</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($logs as $k => $log)

                                <tr id="{{ $log->id }}">
                                    <th>{{ $log->type }}</th>
                                    <td>{{ $log->users->name }} ({{ $log->users->login }})</td>
                                    <td>{{ $log->text }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td>{{ $log->created_at }}</td>
                                    <td style="width:100px;">
                                        <div class="form-group" role="group">
                                            <button class="btn btn-danger btn-sm log_delete" type="button" title = "Удалить запись"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links() }}
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

        $('#datatable').DataTable( {
            "order": [[ 4, "desc" ]]
        } );

        $('.log_delete').click(function(){
            var id = $(this).parent().parent().parent().attr("id");
            var x = confirm("Выбранная запись будет удалена. Продолжить (Да/Нет)?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('delOnelog') }}',
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

        $('#btn_clear').click(function(e){
            e.preventDefault();
            var id = 'clear';
            var x = confirm("Журнал событий будет очищен. Продолжить (Да/Нет)?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteLog') }}',
                    data: {'id':id},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res){
                        //alert(res);
                        if(res=='OK')
                            window.location.replace('/eventlog');
                        if(res=='NO')
                            alert('Выполнение операции запрещено!');
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
