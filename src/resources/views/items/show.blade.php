@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')

<div class="item-detail">

  <div class="item-card">
    @foreach($item->images as $image) 
        <div class="item-image"> 
          <img src="{{ asset('storage/' . $image->image_path) }}" alt="商品画像">
        </div>
    @endforeach
  </div>
  

  <div class="item-info">
    <h1 class="item-name">{{ $item->name }}</h1>
    <p class="item-brand">{{ $item->brand }}</p>
    <p class="price">¥{{ number_format($item->price) }}（税込）</p>
   
    <div class="item-icons">
      <div class="icon-box">
        @auth
          @if($isFavorited)
            <form action="/items/{{ $item->id }}/favorite" method="POST">
                @csrf
                @method('DELETE') 
                <button type="submit" class="icon-button liked">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </form>
            @else
            <form action="/items/{{$item->id}}/favorite" method="POST">
                @csrf
                <button type="submit" class="icon-button">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </form>
          @endif
        @else
        <a href="/login" class="icon-button">
          <i class="fa-regular fa-heart"></i>
        </a>
        @endauth
        <span>{{$item->favorites_count}}</span>
      </div>
      <div class="icon-box">
        <i class="fa-regular fa-comment"></i>
        <span>{{$item->comments_count}}</span>
      </div>
    </div>

    <a href="/purchase/{{$item->id}}" class="red-button purchase-button">
      購入手続きへ
    </a>

    <h2 class="section-title">商品説明</h2>
    <p>{!! nl2br (e($item->description)) !!}</p>
    
    <h2 class="section-title">商品の情報</h2>

    <div class="info-row">
      <p class="info-label">カテゴリー</p>
      <div class="info-content">
        @foreach($item->categories as $category)
          <span class="item-category">{{ $category->name }}</span>
        @endforeach
      </div>
    </div>

    <div class="info-row">
      <p class="info-label">商品の状態</p>
      <div class="info-content">
        <p class="item-condition-text">{{ $item->condition }}</p>
      </div>
    </div>   

    <h2 class="item-comment">コメント({{ $item->comments_count }})</h2>
    @foreach($item->comments as $comment)
     <div class="comment-item">
       <div class="comment-header">
         <div class="comment-user-image">
           @if($comment->user->profile_image)
             <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}">
           @else
             <div class="comment-user-image-placeholder"></div>
           @endif
         </div>

         <p class="comment-user-name">{{ $comment->user->name }}</p>
       </div>

       <div class="comment-body">
         <p class="comment-text">{{ $comment->comment }}</p>
       </div>
     </div>
    @endforeach
    
    <form class="form-comment" action="/items/{{ $item->id }}/comments" method="POST">
      @csrf
      <label class="form-comment__label" for="comment">商品へのコメント</label>
      <textarea class="form-comment__input" id="comment" name="comment" cols="50" rows="5"></textarea>
         @error('comment')
           <div class="input-error">
             {{ $message }}
           </div>
         @enderror
      <button class="red-button comment-button" type="submit">コメントを送信する</button>
    </form>
  </div>  
</div>

@endsection