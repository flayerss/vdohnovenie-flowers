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
    <title>Заявки — админ-панель</title>
</head>
<body>
  @include('partials.admin-header')

  <div class="wrap admin-page">
    <div class="admin-page-head">
      <h1>Заявки</h1>
    </div>

    <div class="toolbar">
      <form action="{{ route('sort') }}" method="post" id="orderFilterForm">
        @csrf
        <select name="sort" id="sortSelect" onchange="document.getElementById('orderFilterForm').submit()">
          <option value="0">По дате оформления</option>
          <option value="1" @selected(request('sort')=='1')>Сначала новые</option>
          <option value="2" @selected(request('sort')=='2')>Сначала старые</option>
        </select>
        <select name="sort_status" id="sortStatus" onchange="document.getElementById('orderFilterForm').submit()">
          <option value="">По статусу заказа</option>
          @foreach ($statuses as $status)
            <option value="{{ $status->id }}" @selected(request('sort_status')==$status->id)>{{ $status->name }}</option>
          @endforeach
        </select>
      </form>

      <a href="{{ route('admin') }}" class="btn btn-ghost btn-sm">Сбросить сортировку</a>
      <a href="{{ route('export', ['status' => request('sort_status')]) }}" class="btn btn-primary btn-sm">Выгрузить Excel</a>
    </div>

    <div class="order-list">
      @forelse ($orders as $order)
      <div class="order-card">
        <div class="order-card-head">
          <h3>{{ $order->name }}</h3>
          <div style="display:flex; align-items:center; gap:10px;">
            <span class="order-id">Заказ №{{ $order->id }}</span>
            <span class="status-badge status-{{ $order->status_id }}">{{ $order->status->name }}</span>
          </div>
        </div>
        <div class="order-meta">
          <div><strong>Адрес:</strong> {{ $order->dostavka }}</div>
          <div><strong>Телефон:</strong> {{ $order->phone }}</div>
          <div><strong>Почта:</strong> {{ $order->email }}</div>
          <div><strong>Дата:</strong> {{ $order->date }}</div>
          <div><strong>Время:</strong> {{ $order->time }}</div>
          <div><strong>Оплата:</strong> {{ $order->type_oplata }}</div>
          <div><strong>Оформлен:</strong> {{ $order->created_at }}</div>
        </div>
        <div class="order-items">
          @foreach ($order->basket->productsinbasket as $item)
            <div>{{ $item->product->name }} — {{ $item->count }} шт.</div>
          @endforeach
        </div>
        <div class="order-actions">
          <form action="{{ route('setstatus', $order->id) }}" method="post">
            @csrf
            <select name="status">
              @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected($status->id == $order->status_id)>{{ $status->name }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
          </form>
        </div>
      </div>
      @empty
        <p class="section-sub">Заявок пока нет.</p>
      @endforelse
    </div>
  </div>
</body>
</html>
