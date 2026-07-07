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
  <title>Доставка — Вдохновение</title>
</head>

<body>
  @include('partials.shop-header')

  <section class="section">
    <div class="wrap" style="max-width:760px;">
      <h1 class="display">Доставка</h1>
      <p class="hero-copy" style="max-width:none;">Наша курьерская служба доставки цветов работает круглосуточно. Курьеры в любое время суток, в любую погоду по любому адресу в пределах города Богданович и Богдановичского района доставят ваш заказ бережно и аккуратно!</p>
      <p class="hero-copy" style="max-width:none;">Мы лояльно относимся к своим клиентам и мы единственные в городе, кто предоставляет бесплатную доставку цветов при покупке на сумму выше 3 000 рублей.</p>
    </div>
  </section>

  <div class="strip">
    <div class="wrap strip-row">
      <div class="item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        Доставка круглосуточно
      </div>
      <div class="item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        Бесплатно от 3 000 ₽
      </div>
      <div class="item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5-5 18-3-8-8-3z"/></svg>
        +7 (919) 377-88-04
      </div>
    </div>
  </div>

  @include('partials.shop-footer')
</body>

</html>
