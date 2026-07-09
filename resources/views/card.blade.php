<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
    <link rel="stylesheet" href="/css/shop-theme.css">
    <title>{{ $product->name }} — Вдохновение</title>
</head>
<body>
  @include('partials.shop-header')

  <section class="section">
    <div class="wrap">
      <div class="product-detail">
        <div class="bouquet-art" style="aspect-ratio:4/3;">
          <img src="{{ $product->img }}" alt="{{ $product->name }}">
        </div>
        <div>
          <h1 class="display" style="font-size:clamp(26px,3vw,36px);">{{ $product->name }}</h1>
          <p class="prod-price" style="font-size:28px; display:block; margin:12px 0 20px;">{{ $product->price }} ₽</p>
          @if ($product->count < 1)
            <div class="alert" style="display:inline-block;">Нет в наличии</div><br>
          @elseif ($product->count <= 3)
            <div class="alert" style="display:inline-block;">Осталось {{ $product->count }} шт.</div><br>
          @endif
          @if ($product->count > 0)
            <a href="{{ route('corsinad', $product->id) }}" class="btn btn-primary js-add-cart" data-add-url="{{ route('corsinad', $product->id) }}" style="margin-top:16px;">Добавить в корзину</a>
          @endif
        </div>
      </div>
    </div>
  </section>

  @include('partials.shop-footer')
  <script src="/js/main.js"></script>
</body>
</html>
