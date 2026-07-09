<footer class="site-footer">
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <span class="logo-badge" style="width:64px;height:64px;">
        <img src="/img/logo1.png" alt="Вдохновение">
      </span>
      <p>Цветочный магазин с доставкой по Богдановичу и Богдановичскому району. Букеты, комнатные растения, сладкие подарки и открытки.</p>
    </div>
    <div class="footer-col">
      <h4>Покупателям</h4>
      <ul>
        <li><a href="{{ route('dostavka') }}">Доставка и оплата</a></li>
        <li><a href="{{ route('comment') }}">Отзывы</a></li>
        <li><a href="{{ route('corsina') }}">Корзина</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Контакты</h4>
      <ul>
        <li><a href="tel:+79193778804">+7 (919) 377-88-04</a></li>
        <li><a href="https://vk.com/wild_flower_shop">ВКонтакте</a></li>
        <li><a href="https://web.telegram.org/a/#7984889021" target="_blank">Telegram</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Магазин</h4>
      <ul>
        @auth
          <li><a href="{{ route('admin') }}">Админ-панель</a></li>
        @else
          <li><a href="{{ route('login') }}">Вход для администратора</a></li>
        @endauth
      </ul>
    </div>
  </div>
  <div class="wrap footer-bottom">
    <span>© {{ date('Y') }} Вдохновение — цветочный магазин</span>
    <span>Можете позвонить нам по номеру +7 (919) 377-88-04</span>
  </div>
</footer>
