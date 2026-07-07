<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/styledostavka.css">
  <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
  <title>Бутик цветов</title>
</head>

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
        <a href="{{ route('comment') }}" class="{{ request()->routeIs('comment') ? 'active' : '' }}" id="menuLink">Отзывы</a>
        <a href="{{  route('dostavka') }}" class="{{ request()->routeIs('comment') ? 'active' : '' }}" id="menuLink">Доставка</a>
        <a href="{{route('corsina')}}" class="{{ request()->routeIs('comment') ? 'active' : '' }}" id="menuLink">Корзина</a>
        @auth
          <a href="{{ route('admin') }}" id="menuLink">Админ-панель</a>
        @else
          <a href="{{ route('login') }}" id="menuLink">Вход для администратора</a>
        @endauth
      </div>
    </div>
  </header>
  <!--контент-->
  <!--контент-->
  <div class="main">
    <div class="main_menu">
      @foreach ($types as $type)
      <a href="{{ route('getType', $type->id) }}" id="menus">{{ $type->name}}</a>
      @endforeach
    </div>
  </div>
    <div class="content">
      <h1>Доставка</h1><br>
      <p>Наша курьерская служба доставки цветов работает круглосуточно.
        Курьеры в любое время суток, в любую погоду по любому адресу
        в пределах города Богданович и Богдановичского района
        доставят Ваш заказ бережно и аккуратно!</p><br>
      <p>Мы лояльно относимся к своим клиентам и мы единственные в городе,
        кто предоставляет бесплатнную доставку цветов при покупке на сумму выше 3000 рублей</p>
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
</body>

</html>