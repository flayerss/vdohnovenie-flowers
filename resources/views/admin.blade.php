<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleadmin.css">
    <link rel="icon" href="/img/logo.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo.jpg">
    <title>Админ панель</title>
    <style>
    nav {
        background-color: #333; /* Цвет фона навигации */
        padding: 10px 20px; /* Отступы внутри навигации */
        border-radius: 5px; /* Закругленные углы */
    }

    nav ul {
        list-style-type: none; /* Убираем маркеры списка */
        padding: 0; /* Убираем отступы */
        margin: 0; /* Убираем внешние отступы */
        display: flex; /* Используем flexbox для горизонтального расположения элементов */
    }

    nav li {
        margin-right: 20px; /* Отступ между пунктами меню */
    }

    nav a {
        color: white; /* Цвет текста ссылок */
        text-decoration: none; /* Убираем подчеркивание по умолчанию */
        font-weight: bold; /* Жирный шрифт для ссылок */
        transition: color 0.3s, text-decoration 0.3s; /* Плавный переход для цвета и подчеркивания */
    }

    nav a:hover {
        color: #ffcc00; /* Цвет текста при наведении */
        text-decoration: underline; /* Подчеркивание при наведении */
    }

    .underline {
        text-decoration: underline; /* Подчеркивание для активной ссылки */
    }
</style>
</head>
<body>
  <nav>
    <ul>
        <li>
            <a href="{{ route('otziv') }}" class="{{ request()->is('admin/otziv') ? 'underline' : '' }}">Комментарии</a>
        </li>
        <li>
            <a href="{{ route('admin') }}" class="{{ request()->is('admin') ? 'underline' : '' }}">Заявки</a>
        </li>
        <li>
            <a href="{{ route('index') }}">На сайт</a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}">Профиль</a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="post" style="margin:0;">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;font-weight:bold;cursor:pointer;padding:0;">Выйти</button>
            </form>
        </li>
    </ul>
</nav>

<h2>Заявки</h2>
<form action="{{ route('sort') }}" method="post" id="dateSortForm">
    @csrf
    <select name="sort" id="sortSelect" style="margin: 10px 0;" onchange="document.getElementById('dateSortForm').submit()">
        <option value="0">По дате оформления</option>
        <option value="1">Сначала новые</option>
        <option value="2">Сначала старые</option>
    </select>
</form>

<form action="{{ route('sort_status') }}" method="post" id="statusSortForm">
    @csrf
    <select name="sort_status" id="sortStatus" style="margin: 10px 0;" onchange="document.getElementById('statusSortForm').submit()">
        <option value="">По статусу заказа</option>
        @foreach ($statuses as $status)
            <option value="{{$status->id}}">{{$status->name}}</option>
        @endforeach
    </select>
</form>
<a href="{{route('admin')}}">Сбросить сортировку</a>
<a href="{{ route('export', ['status' => request('status')]) }}">Выгрузить Excel</a>
@foreach ($orders as $order)
<div class="card">
    <h1>Имя: {{ $order->name }}</h1>
    <p>Адрес: {{ $order->dostavka }}</p>
    <p>Телефон: {{ $order->phone }}</p>
    <p>Почта: {{ $order->email }}</p>
    <p>Дата: {{ $order->date }}</p>
    <p>Время: {{ $order->time }}</p>
    <p>Тип оплаты: {{ $order->type_oplata }}</p>
    <p>Статус заказа: {{ $order->status->name }}</p>
    <p>Заказ: {{ $order->id }}</p>
    @foreach ($order->basket->productsinbasket as $item)
    <p>Название продукта: {{ $item->product->name }}</p>
    <p>Количество: {{ $item->product->count }}</p>
    @endforeach
    <p>Оформлен: {{ $order->created_at }}</p>
    <form action="{{ route('setstatus', $order->id) }}" method="post">
        @csrf
        <select name="status" id="">
            @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
        <button type="submit">Сохранить</button>
    </form>
</div>
@endforeach
<style>
    .underline {
        text-decoration: underline;
    }
</style>
<script>
    
    // Объединенный обработчик для всех форм
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sortSelect');
        const statusSelect = document.getElementById('sortStatus');
    
        [sortSelect, statusSelect].forEach(select => {
            select.addEventListener('change', function(e) {
                const form = document.getElementById(select.id.includes('Status') ? 
                    'statusSortForm' : 'dateSortForm');
                
                if (!shouldSubmit(e)) return;
                form.submit();
            });
        });
    });
    
    function shouldSubmit(event) {
        return event.target.options[event.target.selectedIndex].value !== '';
    }
    </script>
</body>
</html>