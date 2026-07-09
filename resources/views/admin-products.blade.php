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
    <title>Товары — админ-панель</title>
</head>
<body>
  @include('partials.admin-header')

  <div class="wrap admin-page">
    <div class="admin-page-head">
      <h1>Товары</h1>
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Добавить товар</a>
    </div>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="product-admin-list">
      @forelse ($products as $product)
      <div class="product-admin-card">
        <div class="product-admin-photo">
          <img src="{{ $product->img }}" alt="{{ $product->name }}">
        </div>
        <div class="product-admin-body">
          <h3>{{ $product->name }}</h3>
          <div class="product-admin-meta">
            <span>{{ $product->price }} ₽</span>
            <span>Категория: {{ $product->type->name ?? '—' }}</span>
            <span>Остаток: {{ $product->count }} шт.</span>
          </div>
        </div>
        <div class="product-admin-actions">
          <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-ghost btn-sm">Редактировать</a>
          <form action="{{ route('admin.products.delete', $product->id) }}" method="post" onsubmit="return confirm('Удалить товар «{{ $product->name }}»?');">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm remove-btn">Удалить</button>
          </form>
        </div>
      </div>
      @empty
        <p class="section-sub">Товаров пока нет.</p>
      @endforelse
    </div>
  </div>
</body>
</html>
