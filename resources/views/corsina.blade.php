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
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Корзина — Вдохновение</title>
</head>

<body>
  @include('partials.shop-header')

  <section class="section">
    <div class="wrap">
      @if ($errors->any())
        <div class="alert">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      @if (isset($basketproducts) && $basketproducts->count() > 0)
      <div class="cart-layout">
        <div class="cart-items">
          @foreach ($basketproducts as $basketproduct)
          <div class="cart-item container" data-item-id="{{ $basketproduct->id }}" data-update-url="{{ route('updateQuantity', $basketproduct->id) }}">
            <div class="cart-item-photo">
              <img class="corsimg" src="{{ $basketproduct->product->img }}" alt="{{ $basketproduct->product->name }}">
            </div>
            <div class="cart-item-info text-container">
              <p class="cart-item-name strc">{{ $basketproduct->product->name }}</p>
              <span class="cart-item-price strcs price" data-price="{{ $basketproduct->product->price }}">{{ $basketproduct->product->price }} ₽</span>
              @if ($basketproduct->product->count < 1)
                <p class="cart-item-warning">Нет в наличии</p>
              @endif
            </div>
            <div class="qty-control number">
              <button class="number-minus" type="button">−</button>
              <input type="number" min="1" max="{{ $basketproduct->product->count }}" value="{{ $basketproduct->count }}" class="quantity">
              <button class="number-plus" type="button">+</button>
            </div>
            <form action="{{ route('delProduct', $basketproduct->id) }}" class="form-delete remove-form" method="GET">
              <button type="submit" class="remove-btn">Удалить</button>
            </form>
          </div>
          @endforeach
        </div>

        <form action="{{ route('adorder') }}" method="post" class="order-panel rp" id="order-form">
          @csrf
          <h2>Данные о доставке</h2>
          <input type="text" name="name" id="fullName" placeholder="Имя" required>
          <input type="text" name="phone" id="phoneNumber" placeholder="Номер телефона" required>
          <input type="email" name="email" id="email" placeholder="Почта" required>
          <input type="text" name="address" id="address" placeholder="Адрес доставки" required>
          <input id="date" name="date" type="date" placeholder="Дата доставки" required>
          <h5>Время доставки</h5>
          <select id="time" name="time" required>
            <option value="00:00-01:00">00:00-01:00</option>
            <option value="01:00-02:00">01:00-02:00</option>
            <option value="02:00-03:00">02:00-03:00</option>
            <option value="03:00-04:00">03:00-04:00</option>
            <option value="04:00-05:00">04:00-05:00</option>
            <option value="05:00-06:00">05:00-06:00</option>
            <option value="06:00-07:00">06:00-07:00</option>
            <option value="07:00-08:00">07:00-08:00</option>
            <option value="08:00-09:00">08:00-09:00</option>
            <option value="09:00-10:00">09:00-10:00</option>
            <option value="10:00-11:00">10:00-11:00</option>
            <option value="11:00-12:00">11:00-12:00</option>
            <option value="12:00-13:00">12:00-13:00</option>
            <option value="13:00-14:00">13:00-14:00</option>
            <option value="14:00-15:00">14:00-15:00</option>
            <option value="15:00-16:00">15:00-16:00</option>
            <option value="16:00-17:00">16:00-17:00</option>
            <option value="17:00-18:00">17:00-18:00</option>
            <option value="18:00-19:00">18:00-19:00</option>
            <option value="19:00-20:00">19:00-20:00</option>
            <option value="20:00-21:00">20:00-21:00</option>
            <option value="21:00-22:00">21:00-22:00</option>
            <option value="22:00-23:00">22:00-23:00</option>
            <option value="23:00-00:00">23:00-00:00</option>
          </select>
          <h5>Способ оплаты</h5>
          <select id="payment-type" name="type" required>
            <option>безналичный</option>
            <option>наличный</option>
          </select>
          <div class="order-summary">
            <input type="hidden" id="total" name="total">
            <h5 id="dostavka"></h5>
            <h5 id="more" style="color:var(--ink-soft);"></h5>
            <p id="totalPrice"></p>
          </div>
          <button type="submit" class="btn btn-primary cors1">Оформить заказ</button>
        </form>
      </div>
      @elseif (!session('order'))
        <div class="cart-empty">
          <h1>Ваша корзина пуста</h1>
          <p>Загляните в <a href="{{ route('index') }}" style="color:var(--accent-strong); font-weight:600;">каталог</a>, чтобы выбрать букет.</p>
        </div>
      @endif

      @if(session('order'))
        @php $order = session('order'); @endphp
        <div class="order-confirmation">
          <h1>Заказ №{{ $order->id }} оформлен</h1>
          <p>Имя: {{ $order->name }}</p>
          <p>Адрес: {{ $order->dostavka }}</p>
          <p>Телефон: {{ $order->phone }}</p>
          <p>Почта: {{ $order->email }}</p>
          <p>Дата: {{ $order->date }}</p>
          <p>Время: {{ $order->time }}</p>
          <p>Тип оплаты: {{ $order->type_oplata }}</p>
          <p>Статус заказа: {{ $order->status->name }}</p>
          <div class="card_order">
            @foreach ($order->basket->productsinbasket as $item)
            <div class="card" id="n1">
              <img class="card-img-top" src="{{ $item->product->img }}">
              <div class="card-body">
                <h5 class="card-title">{{ $item->product->name }}</h5>
                <p id="price" class="card-text">{{ $item->product->price }} ₽</p>
              </div>
            </div>
            @endforeach
          </div>
          <p>Оформлен: {{ $order->created_at }}</p>
          @if (session('total'))
            @php $total = session('total'); @endphp
          @endif
          <p>Итоговая сумма: {{ $total }} ₽</p>
        </div>
      @endif
    </div>
  </section>

  @include('partials.shop-footer')

  <script src="/js/main.js"></script>
  <script src="/js/jquery-3.3.3.js"></script>
  <script src="/js/jquery.mask.js"></script>
  <script>
    $(document).ready(function() {
      // Маска для телефона (Россия)
      $('#phoneNumber').mask('+7 (000) 000-00-00');
    });
  </script>
</body>
</html>
