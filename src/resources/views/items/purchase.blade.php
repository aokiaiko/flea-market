@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/purchase.css') }}">
@endsection

@section('content')

<form class="purchase__form" action="/purchase/{{ $item->id }}" method="post">
    @csrf

<div class="purchase__content">
  <h1 class="visually-hidden">商品購入</h1>

  <div class="purchase__left">

    <div class="purchase__section">
     <div class="item">
      <div class="item-image">
         <img src="{{asset('storage/' . $item->images->first()->image_path) }}" alt="商品画像">
      </div>
      <div class="item-name">
        <h2>{{ $item->name }}</h2>
        <p class="price">¥ {{$item->price}}</p>
      </div>
     </div>
    </div>

    <div class="purchase__section">
      <h2 class="purchase__item">支払い方法</h2>
      <select  class="pay-method" name="payment_method" id="paymentMethod" >
        <option value="">選択してください</option>
        <option value="konbini">コンビニ払い</option>
        <option value="card">カード支払い</option>
      </select>
      @error('payment_method')
                <div class="input-error">
                   {{ $message }}
                </div>
      @enderror
    </div>

    <div class="purchase__section">
     <div class="purchase__address">
        <h2 class="purchase__item">配送先</h2>
        <a class="address-change" href="/purchase/address/{{$item->id}}">変更する</a>
     </div>
     <div class="address">
      @if($address)
        <p>〒 {{ $address->postcode }}</p>
        <p>{{ $address->address}}{{$address->building }}</p>
        <input type="hidden" name="address_id" value="{{ $address->id }}">
      @else
        <p>住所が登録されていません</p>
      @endif
      @error('address_id')
                <div class="input-error">
                   {{ $message }}
                </div>
      @enderror
      </div>
    </div>
   </div>

  <div class="purchase__right">
    <div class="subtotal">
     <table>
       <tr>
         <th>商品代金</th>
         <td>¥{{$item->price}}</td>
       </tr>
       <tr>
         <th>支払い方法</th>
         <td id="paymentMethodLabel">未選択</td>
       </tr>
     </table>
    </div>
            
    <button class="purchase__button" type="submit">購入する</button>
  </div>
</div>
</form>

<script>
  const select = document.getElementById('paymentMethod');
  const label  = document.getElementById('paymentMethodLabel');

  const map = { konbini: 'コンビニ払い', card: 'カード支払い' };

  function render() {
    label.textContent = map[select.value] ?? '未選択';
  }

  render();
  select.addEventListener('change', render);
</script>


@endsection