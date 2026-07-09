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
    <div class="wrap">
      <div class="section-head">
        <div>
          <h2 class="display">Отзывы покупателей</h2>
          <p class="section-sub">
            @if(count($comments))
              {{ count($comments) }} {{ count($comments) == 1 ? 'отзыв' : 'отзывов' }} от наших покупателей
            @else
              Поделитесь впечатлением о заказе — станьте первым
            @endif
          </p>
        </div>
      </div>

      <div class="review-layout">
        <aside class="review-form-card">
          <h3>Оставить отзыв</h3>
          <p class="section-sub" style="margin-top:0; margin-bottom:16px;">Отзыв появится на сайте после проверки модератором</p>

          @if ($errors->any())
            <div class="alert">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form action="{{ route('comment') }}" method="POST" class="field-group">
            @csrf
            <div>
              <label class="field-label" for="name">Ваше имя</label>
              <input type="text" name="name" id="name" placeholder="Как к вам обращаться" value="{{ old('name') }}" required>
            </div>
            <div>
              <label class="field-label" for="comment">Отзыв</label>
              <textarea name="comment" id="comment" placeholder="Расскажите, как всё прошло" required>{{ old('comment') }}</textarea>
            </div>
            <button class="btn btn-primary" type="submit">Отправить отзыв</button>
          </form>
        </aside>

        <div class="review-list">
          @forelse ($comments as $comment)
          <div class="review-card">
            <div class="review-avatar">{{ mb_substr($comment->name_user, 0, 1) }}</div>
            <div class="review-body">
              <h5>{{ $comment->name_user }}</h5>
              <p>{{ $comment->name }}</p>
            </div>
          </div>
          @empty
            <div class="review-empty">
              <p class="section-sub">Пока нет отзывов — станьте первым!</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </section>

  @include('partials.shop-footer')
</body>

</html>
