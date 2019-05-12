@extends('layouts.404')

@section('tile_widget')

@endsection

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li class="active">Страница не найдена</li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- page content -->
    <div class="overlay"></div>
        <div class="terminal">
            <h1>Error <span class="errorcode">404</span></h1>
            <p class="output">Что-то пошло не так! Такой страницы не существует. Попробуйте ввести правильную ссылку.</p>
            <p class="output">Попробуйте перейти на <a href="{{ route('home') }}">Рабочий стол</a> или вернитесь <a href="{{ URL::previous() }}">Назад</a></p>
            <p class="output">_</p>
        </div>
    </div>

@endsection

@section('user_script')

@endsection