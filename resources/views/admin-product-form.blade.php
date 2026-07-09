<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/shop-theme.css">
    <link rel="stylesheet" href="/css/admin-theme.css">
    <link rel="icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="shortcut icon" href="/img/logo1.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/logo1.png">
    <title>{{ $product ? 'Редактирование товара' : 'Новый товар' }} — админ-панель</title>
</head>
<body>
  @include('partials.admin-header')

  <div class="wrap admin-page" style="max-width:640px;">
    <div class="admin-page-head">
      <h1>{{ $product ? 'Редактирование товара' : 'Новый товар' }}</h1>
    </div>

    @if ($errors->any())
      <div class="alert">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ $product ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
          method="post" enctype="multipart/form-data" class="info-card field-group">
      @csrf

      <div>
        <label class="field-label" for="name">Название</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required>
      </div>

      <div>
        <label class="field-label" for="type_id">Категория</label>
        <select name="type_id" id="type_id" required>
          @foreach ($types as $type)
            <option value="{{ $type->id }}" @selected(old('type_id', $product->type_id ?? null) == $type->id)>{{ $type->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="field-label" for="price">Цена, ₽</label>
        <input type="number" name="price" id="price" min="0" value="{{ old('price', $product->price ?? '') }}" required>
      </div>

      <div>
        <label class="field-label" for="count">Остаток, шт.</label>
        <input type="number" name="count" id="count" min="0" value="{{ old('count', $product->count ?? '') }}" required>
      </div>

      <div>
        <label class="field-label" for="description">Описание</label>
        <textarea name="description" id="description">{{ old('description', $product->description ?? '') }}</textarea>
      </div>

      <div>
        <label class="field-label" for="image">Фото товара{{ $product ? ' (оставьте пустым, чтобы не менять)' : '' }}</label>
        @if ($product)
          <div class="product-admin-photo" style="width:120px;height:120px;margin-bottom:10px;">
            <img src="{{ $product->img }}" alt="{{ $product->name }}">
          </div>
        @endif
        <input type="file" name="image" id="image" accept="image/*" @if(!$product) required @endif>
      </div>

      <div style="display:flex; gap:10px;">
        <button type="submit" class="btn btn-primary">{{ $product ? 'Сохранить' : 'Добавить товар' }}</button>
        <a href="{{ route('admin.products') }}" class="btn btn-ghost">Отмена</a>
      </div>
    </form>
  </div>
</body>
</html>
