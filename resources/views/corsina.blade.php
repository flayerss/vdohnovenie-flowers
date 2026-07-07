<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/stylecorsina.css">
    <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
    
  <title>Бутик цветов</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
  .number {
	display: grid;
	position: relative;
	width: 100px;
}
.number input[type="number"] {
	display: block;
	height: 32px;
	line-height: 32px;
	width: 100%;
	padding: 0;
	margin: 0;
	box-sizing: border-box;
	text-align: center;
	-moz-appearance: textfield;
	-webkit-appearance: textfield;
	appearance: textfield;
}
.number input[type="number"]::-webkit-outer-spin-button,
.number input[type="number"]::-webkit-inner-spin-button {
	display: none;
}
.number-minus {
	position: absolute;
	top: 1px;
	left: 1px;
	bottom: 1px;
	width: 20px;
	padding: 0;
	display: block;
	text-align: center;
	border: none;
	border-right: 1px solid #ddd;
	font-size: 16px;
	font-weight: 600;
}
.number-plus {
	position: absolute;
	top: 1px;
	right: 1px;
	bottom: 1px;
	width: 20px;
	padding: 0;
	display: block;
	text-align: center;
	border: none;
	border-left: 1px solid #ddd;
	font-size: 16px;
	font-weight: 600;
}
</style>
<body>
  <!--шапка-->
   <header>
    <div class="header_content">
      <div class="logo">
        <a href="{{ route('index') }}"><img src="/img/logo1.png" /></a>
      </div>
      <div class="logo__info">
        <p>Связаться с нами: +7 (919) 377-88-04</p>
        <p>Доставка по Богдановичу и Богдановичскому району</p>
      </div>
      <div id="menu">
        <a href="{{ route('comment') }}" id="menuLink">Отзывы</a>
        <a href="{{  route('dostavka') }}" id="menuLink">Доставка</a>
        <a href="{{route('corsina')}}" id="menuLink">Корзина</a>
        @auth
          <a href="{{ route('admin') }}" id="menuLink">Админ-панель</a>
        @else
          <a href="{{ route('login') }}" id="menuLink">Вход для администратора</a>
        @endauth
      </div>
    </div>
  </header>
  
  <!--контент-->
  <div class="main__content">
    @if ($errors->any())
      <div class="alert" style="color:red;">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif
    <div class="corsblock">
      @if (isset($basketproducts))
      @foreach ($basketproducts as $basketproduct)
      <div class="container" data-item-id="{{ $basketproduct->id }}" data-update-url="{{ route('updateQuantity', $basketproduct->id) }}">
        <img class="corsimg" src="{{$basketproduct->product->img}}">
        <div class="text-container">
          <p class="strc">{{$basketproduct->product->name}}</p>
          <p class="strcs price" data-price="{{$basketproduct->product->price}}">{{$basketproduct->product->price}} ₽</p>
          @if ($basketproduct->product->count < 1)
            <p style="color:red;">Нет в наличии</p>
          @endif
        </div>
        <div class="number">
          <button class="number-minus" type="button">-</button>
          <input type="number" min="1" max="{{ $basketproduct->product->count }}" value="{{ $basketproduct->count }}" class="quantity">
          <button class="number-plus" type="button">+</button>
        </div>
        <form action="{{ route('delProduct', $basketproduct->id) }}" class="form-delete" method="GET">
          <button type="submit">Удалить</button>
        </form>
      </div>
      @endforeach
    </div>
    <div class="info">
      <h2>Данные о доставке</h2>
      <form action="{{ route('adorder') }}" method="post" class="rp" id="order-form">
        @csrf
        <input type="text" name="name" id="fullName" placeholder="Имя" required>
        <input type="text" name="phone" id="phoneNumber" placeholder="Номер телефона" required>
        <input type="email" name="email" id="email" placeholder="Почта" required>
        <input type="text" name="address" id="address" placeholder="Адрес доставки" required>
        <input id="date" name="date" type="date" placeholder="Дата доставки" required>
        <h5>Время доставки</h5>
        <select id="time" name="time"  required>
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
        <select id="time" name="type" required>
          <option>безналичный</option>
          <option>наличный</option>
        </select>
        <div class="div">
          <input type="hidden" id="total" name="total"></input>
          <h5 id="dostavka"></h5>
          <h5 id="more" style="color:gray;"></h5>
          <h5 id="totalPrice"></h5>
        </div>
        <button type="submit" class="cors1">Оформить заказ</button>
      </form>
    </div>
    @elseif (!session('order'))
    <h1>Ваша корзина пуста</h1>
    @endif
  </div>
@if(session('order'))
    @php $order = session('order'); @endphp
    <div class="cardd">
        <h1>Заказ № {{$order->id}}</h1>
        <h1>Имя: {{ $order->name}}</h1>
        <p>Адрес: {{ $order->dostavka }}</p>
        <p>Телефон: {{ $order->phone }}</p>
        <p>Почта: {{ $order->email }}</p>
        <p>Дата: {{ $order->date }}</p>
        <p>Время: {{ $order->time }}</p>
        <p>Тип оплаты: {{ $order->type_oplata }}</p>
        <p>Статус заказа: {{ $order->status->name }}</p>
        <div class="card_order">
          @foreach ($order->basket->productsinbasket as $item)
          <div class="card" id="n1" style="width: 25rem;">
            <img class="card-img-top" src="{{ $item->product->img }}">
            <div class="card-body">
              <h5 class="card-title">{{$item->product->name}}</h5>
              <p id="price" class="card-text">{{$item->product->price }} ₽</p>
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
  
<!--подвал-->
<footer>
  <div class="footer_content">
    <div id="menu1">
      <p>Заказать цветы и подарки через наш сайт с доставкой легко и просто</p>
    </div>
  </div>
  <div class="footer_content2">
    <div class="contact">
      <p>Можете позвонить нам по номеру +7 (919) 377-88-04</p><br>
    </div>
    <div class="site">
      <a href="https://vk.com/wild_flower_shop"><img src="/img/Vk.png" width="33" height="30" /></a>
      <a href="https://web.telegram.org/a/#7984889021" target="_blank"><img src="/img/Tг.png" width="33" height="30" /></a>
      </div>
    </div>
  </footer>
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