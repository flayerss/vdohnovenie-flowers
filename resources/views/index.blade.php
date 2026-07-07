<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
 <link rel="stylesheet" href="/css/bootstrap.min.css"> 
 <link rel="stylesheet" href="/css/style.css">
  
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
  <div class="stroka">
    <marquee behavior="scroll" class="marquee" scrollamount="10" direction="left">Доставка от 3000 ₽ <strong>БЕСПЛАТНО</strong></marquee>
  </div>
  <div class="main">
    <div class="main_menu">
      @foreach ($types as $type)
      <a href="{{ route('getType', $type->id) }}" id="menus">{{ $type->name}}</a>
      @endforeach
    </div>
    <div class="cards">
      @foreach ($products as $product)
      <div class="card" id="n1" style="width: 25rem;">
        <a href="{{ route('card', $product->id) }}"><img class="card-img-top" src="{{ $product->img }}"></a>
        <div class="card-body">
          <h5 class="card-title">{{$product->name}}</h5>
          <p id="price" class="card-text">{{ $product->price }} ₽</p>
          <a href="{{route('corsinad', $product->id)}}" class="btn btn-primary">В корзину</a>
        </div>
      </div>
      @endforeach
    </div>
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