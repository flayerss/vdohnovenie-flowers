<header class="admin-header">
  <div class="wrap admin-header-row">
    <a class="admin-brand" href="{{ route('admin') }}">
      <span class="logo-badge" style="width:40px;height:40px;">
        <img src="/img/logo1.png" alt="Вдохновение">
      </span>
      <span class="logo-word">Вдохновение</span>
    </a>
    <nav class="admin-tabs">
      <a href="{{ route('admin') }}" class="admin-tab {{ request()->is('admin') ? 'is-active' : '' }}">Заявки</a>
      <a href="{{ route('otziv') }}" class="admin-tab {{ request()->is('admin/otziv') ? 'is-active' : '' }}">Комментарии</a>
      <a href="{{ route('admin.products') }}" class="admin-tab {{ request()->is('admin/products*') ? 'is-active' : '' }}">Товары</a>
    </nav>
    <div class="admin-actions">
      <a class="btn btn-ghost btn-sm" href="{{ route('index') }}">На сайт</a>
      <a class="btn btn-ghost btn-sm" href="{{ route('profile.edit') }}">Профиль</a>
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-primary btn-sm">Выйти</button>
      </form>
    </div>
  </div>
</header>
