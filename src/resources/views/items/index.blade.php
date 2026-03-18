@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')

<div class="toppage-list">
  <div class="toppage-list__container">
   <div class="toppage-list__inner">
     
    @if(request('tab') == 'mylist')
        <a class="tab" href="/">おすすめ</a>
        <a class="tab active" href="/?tab=mylist{{ request('keyword') ? '&keyword='.request('keyword') : '' }}">マイリスト</a>
        
    @else
        <a class="tab active" href="/">おすすめ</a>
        <a class="tab" href="/?tab=mylist{{ request('keyword') ? '&keyword='.request('keyword') : '' }}">マイリスト</a>
    @endif
    </div>
  </div>
</div>
  
<div class="item-index">
  <div class="item-container">
   <div class="item-grid">

    @foreach($items as $item)
     <a href="/item/{{$item->id}}">
      <div class="item-card">
        <div class="item-image">
          @if($item->images->isNotEmpty())
            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="商品画像">
          @else
            <img src="{{ asset('images/no-image.png') }}" alt="画像無し">
          @endif
        </div>
        <p class="item-name">{{ $item->name }}</p>

        @if($item->status==\App\Models\Item::STATUS_SOLD)
        <span class="sold-label">Sold</span>
        @endif
      </div>
     </a>
    @endforeach
      
   </div>
  </div>

</div>
@endsection