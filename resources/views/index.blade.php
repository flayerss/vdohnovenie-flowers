<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/img/logo1.png" type="image/x-icon">
  <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/img/logo1.png">
  <link rel="stylesheet" href="/css/shop-theme.css">
  <title>Вдохновение — цветочный магазин</title>
</head>

<body>
  @include('partials.shop-header')

  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <p class="eyebrow">Богданович и Богдановичский район</p>
        <h1 class="display">Цветы, которые <em>говорят</em><br>раньше слов</h1>
        <p class="hero-copy">Свежие букеты, комнатные растения и подарки к любому поводу — собираем и доставляем в день заказа.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#catalog">Смотреть каталог</a>
          <a class="btn btn-ghost" href="{{ route('dostavka') }}">Условия доставки</a>
        </div>
      </div>
      @if ($products->count())
        @php $featured = $products->first(); @endphp
        <div class="bouquet-art">
          <img src="{{ $featured->img }}" alt="{{ $featured->name }}">
          <div class="bouquet-caption"><strong>{{ $featured->name }}</strong> — {{ $featured->price }} ₽</div>
        </div>
      @endif
    </div>
  </section>

  <section class="section" id="catalog" style="padding-top:0;">
    <div class="wrap">
      <div class="section-head">
        <div>
          <h2 class="display">Каталог</h2>
          <p class="section-sub">Всё, что есть в наличии прямо сейчас</p>
        </div>
      </div>
      <div class="prod-grid">
        @foreach ($products as $product)
        <div class="prod-card">
          <a href="{{ route('card', $product->id) }}" class="prod-photo-link">
            <div class="prod-photo">
              <img src="{{ $product->img }}" alt="{{ $product->name }}">
              @if ($product->count < 1)
                <span class="out-tag">нет в наличии</span>
              @elseif ($product->count <= 3)
                <span class="stock-tag">осталось {{ $product->count }}</span>
              @endif
            </div>
          </a>
          <div class="prod-body">
            <a href="{{ route('card', $product->id) }}" class="prod-name-link">
              <div class="prod-name">{{ $product->name }}</div>
            </a>
            <div class="prod-foot">
              <span class="prod-price">{{ $product->price }} ₽</span>
              @if ($product->count > 0)
                <a href="{{ route('corsinad', $product->id) }}" class="add-btn" aria-label="Добавить в корзину">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                </a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  @include('partials.shop-footer')
</body>

</html>
