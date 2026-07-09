<div class="top-banner">Доставка от 3 000 ₽ <strong>БЕСПЛАТНО</strong> · Богданович и Богдановичский район</div>

<header class="site-header">
  <div class="wrap header-row">
    <a class="logo" href="{{ route('index') }}">
      <span class="logo-badge">
        <img src="/img/logo1.png" alt="Вдохновение">
      </span>
    </a>
    <nav class="primary">
      <a href="{{ route('comment') }}" class="{{ request()->routeIs('comment') ? 'is-active' : '' }}">Отзывы</a>
      <a href="{{ route('dostavka') }}" class="{{ request()->routeIs('dostavka') ? 'is-active' : '' }}">Доставка</a>
    </nav>
    <div class="header-actions">
      @auth
        <a class="btn btn-ghost btn-sm" href="{{ route('admin') }}">Админ-панель</a>
      @else
        <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Вход для администратора</a>
      @endauth
      @php
        $cartCount = \App\Models\ProductsInBasket::whereHas('basket', function ($q) {
            $q->where('session_id', session()->getId())->where('active', 1);
        })->sum('count');
      @endphp
      <a class="icon-btn" href="{{ route('corsina') }}" aria-label="Корзина" id="cart-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
        <span class="cart-badge" id="cart-badge" style="{{ $cartCount > 0 ? '' : 'display:none;' }}">{{ (int) $cartCount }}</span>
      </a>
    </div>
  </div>
</header>

@isset($types)
<div class="cat-nav">
  <div class="wrap cat-nav-row">
    <a href="{{ route('index') }}" class="cat-chip {{ request()->routeIs('index') ? 'is-active' : '' }}">Все товары</a>
    @foreach ($types as $type)
      <a href="{{ route('getType', $type->id) }}" class="cat-chip {{ request()->is('product/'.$type->id) ? 'is-active' : '' }}">{{ $type->name }}</a>
    @endforeach
  </div>
</div>
@endisset
