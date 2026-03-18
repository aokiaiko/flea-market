@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@section('content')

<div class="create-item__content">

  <form class="create-item__form" action="/sell" method="POST" enctype="multipart/form-data">
    @csrf

      <h1 class="tittle">商品の出品</h1>

      <div class="item__section">
        <h3 class="item-heading">商品画像</h3>
        <div class="select__image">
          <label class="select__image-button">画像を選択する
            <input class="file-input" type="file" name="images[]" multiple hidden>
          </label>
        </div>   
      </div>

      <h2 class="item-detail">商品の詳細</h2>

      <div class="item__section">
        <h3 class="item-heading">カテゴリー</h3>
        <div class="item__category">
            <input type="checkbox" id="fashion" name="category_ids[]" value="1" hidden>
              <label for="fashion" class="category-name">ファッション</label>
            <input type="checkbox" id="electronics" name="category_ids[]" value="2" hidden>
              <label for="electronics" class="category-name">家電</label>
            <input type="checkbox" id="interior" name="category_ids[]" value="3" hidden>
              <label for="interior" class="category-name">インテリア</label>
            <input type="checkbox" id="ladies" name="category_ids[]" value="4" hidden>
              <label for="ladies" class="category-name">レディース</label>
            <input type="checkbox" id="mens" name="category_ids[]" value="5" hidden>
              <label for="mens" class="category-name">メンズ</label>
            <input type="checkbox" id="cosmetics" name="category_ids[]" value="6" hidden>
              <label for="cosmetics"class="category-name">コスメ</label>
            <input type="checkbox" id="book" name="category_ids[]" value="7" hidden>
              <label for="book" class="category-name">本</label>
            <input type="checkbox" id="game" name="category_ids[]" value="8" hidden>
              <label for="game" class="category-name">ゲーム</label>
            <input type="checkbox" id="sports" name="category_ids[]" value="9" hidden>
              <label for="sports" class="category-name">スポーツ</label>
            <input type="checkbox" id="kitchen" name="category_ids[]" value="10" hidden>
              <label for="kitchen" class="category-name">キッチン</label>
            <input type="checkbox" id="handmade" name="category_ids[]" value="11" hidden>
              <label for="handmade" class="category-name">ハンドメイド</label>
            <input type="checkbox" id="accessory" name="category_ids[]" value="12" hidden>
              <label for="accessory" class="category-name">アクセサリー</label>
            <input type="checkbox" id="toy" name="category_ids[]" value="13" hidden>
              <label for="toy" class="category-name">おもちゃ</label>
            <input type="checkbox" id="baby-kids" name="category_ids[]" value="14" hidden>
              <label for="baby-kids"class="category-name">ベビー・キッズ</label>
        </div>
      </div>

        <div class="item__section">
            <h3 class="item-heading">商品の状態</h3>
            <select class="condition" name="condition">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <h2 class="item-detail">商品名と説明</h2>

        <div class="item__section">
            <h3 class="item-heading">商品名</h3>
            <input class="item-input" type="text" name="name" value="{{ old('name' )}}">
        </div>

        <div class="item__section">
            <h3 class="item-heading">ブランド名</h3>
            <input class="item-input" type="text" name="brand" value="{{ old('brand' )}}">
        </div>

        <div class="item__section">
            <h3 class="item-heading">商品の説明</h3>
            <textarea class="item-textarea" name="description">{{ old('description' )}}</textarea>
        </div>

        <div class="item__section">
            <h3 class="item-heading">販売価格</h3>
            <div class="price-field">
               <span class="price-yen">¥</span>
               <input class="item-input price-input" type="number" name="price" min="0" value="{{ old('price' )}}" >
        </div>

        <button class="create-item__button" type="submit">出品する</button>
  </form>
</div>

@endsection