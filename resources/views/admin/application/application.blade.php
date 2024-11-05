@extends('admin.layouts.app')
@section('title', 'Заявки')
@section('application.application', 'active')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Заявки
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Номер телефона</th>
                        <th>Сообщение</th>
                        <th class="float-right">Действия</th>
                        <th class="float-right">Время отправки</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->data['name'] }}</td>
                            <td>
                                <a href="tel:{{ $item->data['phone'] }}">{{ $item->data['phone'] }}</a>
                            </td>
                            <td>{{ $item->data['message'] }}</td>
                            <td class="float-right">
                                <x-delete-button href="{{ route('admin.application.delete', $item->id) }}"/>
                            </td>
                            <td class="float-right">{{ $item->created_at->format('H:i d.m.Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
@overwrite
