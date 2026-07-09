<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/shop-theme.css">
    <link rel="stylesheet" href="/css/admin-theme.css">
    <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
    <title>Комментарии — админ-панель</title>
</head>
<body>
  @include('partials.admin-header')

  <div class="wrap admin-page">
    <div class="admin-page-head">
      <h1>Комментарии</h1>
    </div>

    <div class="toolbar">
      <form action="{{ route('sort_comment') }}" method="post" id="statusSortForm">
        @csrf
        <select name="sort_status" id="sortStatus" onchange="document.getElementById('statusSortForm').submit()">
          <option value="">По статусу заказа</option>
          @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('otziv') }}" class="btn btn-ghost btn-sm">Сбросить сортировку</a>
    </div>

    <div class="comment-list">
      @forelse ($comments as $comment)
      <div class="comment-card">
        <div class="comment-card-text">
          <h3>{{ $comment->name_user }}</h3>
          <p>{{ $comment->name }}</p>
          <span class="status-badge status-{{ $comment->status_id }}">{{ $comment->status->name }}</span>
        </div>
        <form action="{{ route('setotziv', $comment->id) }}" method="post">
          @csrf
          <select name="status">
            @foreach ($statuses as $status)
              <option value="{{ $status->id }}" @selected($status->id == $comment->status_id)>{{ $status->name }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
        </form>
      </div>
      @empty
        <p class="section-sub">Отзывов пока нет.</p>
      @endforelse
    </div>
  </div>
</body>
</html>
