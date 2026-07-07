<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/img/logo1.png" type="image/x-icon">
  <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/img/logo1.png">
  <link rel="stylesheet" href="/css/shop-theme.css">
  <title>Отзывы — Вдохновение</title>
</head>

<body>
  @include('partials.shop-header')

  <section class="section">
    <div class="wrap" style="max-width:760px;">
      <div class="section-head">
        <div>
          <h2 class="display">Отзывы покупателей</h2>
          <p class="section-sub">Поделитесь впечатлением о заказе</p>
        </div>
      </div>

      @if ($errors->any())
        <div class="alert">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form action="{{ route('comment') }}" method="POST" class="info-card" style="margin-bottom:32px;">
        @csrf
        <label class="field-label" for="name">Ваше имя</label>
        <input type="text" name="name" id="name" placeholder="Как к вам обращаться" value="{{ old('name') }}" required>
        <label class="field-label" for="comment" style="margin-top:8px;">Отзыв</label>
        <textarea name="comment" id="comment" placeholder="Расскажите, как всё прошло" required>{{ old('comment') }}</textarea>
        <button class="btn btn-primary" type="submit" style="align-self:flex-start; margin-top:4px;">Оставить отзыв</button>
      </form>

      <div style="display:flex; flex-direction:column; gap:16px;">
        @forelse ($comments as $comment)
        <div class="info-card">
          <h5>{{ $comment->name_user }}</h5>
          <p>{{ $comment->name }}</p>
        </div>
        @empty
          <p class="section-sub">Пока нет отзывов — станьте первым!</p>
        @endforelse
      </div>
    </div>
  </section>

  @include('partials.shop-footer')
</body>

</html>
