<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/stylecomments.css">
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
    </ul>
</nav>
    <h2>Комментарии</h2>
    <form action="{{ route('sort_comment') }}" method="post" id="statusSortForm">
    @csrf
    <select name="sort_status" id="sortStatus" style="margin: 10px 0;" onchange="document.getElementById('statusSortForm').submit()">
        <option value="">По статусу заказа</option>
        @foreach ($statuses as $status)
            <option value="{{$status->id}}">{{$status->name}}</option>
        @endforeach
    </select>
<a href="{{route('otziv')}}">Сбросить сортировку</a>
</form>
    @foreach ($comments as $comment)
    <div class="card">
        <h1>Комментарий: {{ $comment->name }}</h1>
        <p>Статус: {{ $comment->status->name }}</p>
        <form action="{{ route('setotziv', $comment->id) }}" method="post">
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