@extends('admin.layouts.app')
@section('title','Редактировать профиль')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Редактировать профиль
            </div>
            <form action="{{ route('admin.profile.update') }}" method="post">
                @csrf
                <div class="form-label-group mt-1">
                    <input type="email" name="email" value="{{ auth()->user()->email }}" placeholder="Имя"
                           class="form-control" id="email">
                    <label for="email">Email</label>
                </div>
                <div class="form-label-group">
                    <input type="password" name="password" placeholder="Пароль" class="form-control" id="password">
                    <label for="password">Пароль</label>
                </div>
                <div class="form-label-group">
                    <input type="password" name="new_password" placeholder="Новый пароль" class="form-control"
                           id="new_password">
                    <label for="new_password">Новый пароль</label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
