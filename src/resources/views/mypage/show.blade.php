@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')

<div class="mypage__content">
  <div class="profile-area ">
    <div class="profile-image">
          <div class="profile-image-preview">
            @if($user->profile_image)
              <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="">
            @endif
          </div>
          <div class="user-name">
              <p>{{ $user->name }}</p>
          </div>
    </div>
    <div class="edit__mypage-button">
        <a class="button--red-outline" href="/mypage/profile">プロフィールを編集</a>
    </div>
  </div>
</div>
 
<div class="toppage-list ">
     <div class="toppage-list__container">
      <div class="toppage-list__inner">
        <a class="tab {{ $page !== 'buy' ? 'active' : '' }}" href="/mypage?page=sell" >出品した商品</a>
        <a class="tab {{ $page === 'buy' ? 'active' : '' }}" href="/mypage?page=buy" >購入した商品</a>
      </div>
     </div>
</div>

<div class="item-index">
     <div class="item-container">
      @if($page === 'buy')

       <div class="item-grid">
        @foreach($buyItems as $purchase )
          <div class="item-card">
            <div class="item-image">
                <img src="{{ $purchase->item->images->first()
                     ? asset('storage/' . $purchase->item->images->first()->image_path)
                     : asset('images/no-image.png') }}"
                  alt="商品画像">
            </div>
            <p class="item-name">{{ $purchase->item->name }}</p>
          </div>
        @endforeach
       </div>
       
      @else

        <div class="item-grid">
          @foreach($sellItems as $item)
            <div class="item-card">
              <div class="item-image">
                  <img src="{{ $item->images->first()
                       ? asset('storage/' . $item->images->first()->image_path)
                       : asset('images/no-image.png') }}"
                    alt="商品画像">
              </div>
              <p class="item-name">{{ $item->name }}</p>
            </div>
          @endforeach
        </div>

      @endif
     </div>
</div>

@endsection