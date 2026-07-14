@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile-edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
 
@endsection

@section('content')

<div class="mypage__content">
   
    <div class="mypage__tittle">
        <h1>プロフィール設定</h1>
    </div>
     
    <form class="mypage__form" method="POST" action="/mypage/profile" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

    <div class="profile-image-area">
        <div class="profile-image-preview">
         @if($user->profile_image)
          <img src="{{ asset('storage/'.$user->profile_image) }}" alt="プロフィール画像">
         @endif
        </div>
        <div class="select__image">
           <label class="button--red-outline">画像を選択する
             <input type="file" name="profile_image" hidden>
           </label>
           @error('profile_image')
             <div class="input-error">
               {{ $message }}
             </div>
           @enderror
        </div>
    </div>
     
        <div class="mypage__form-group">
            <label class="mypage__label">ユーザー名</label>
            <input class="mypage__input" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="input-error">
                   {{ $message }}
                </div>
            @enderror
       </div>

       <div class="mypage__form-group">
            <label class="mypage__label">郵便番号</label>
            <input class="mypage__input" type="text" name="postcode" value="{{ old('postcode', $address->postcode ?? '') }}"/>
            @error('postcode')
                <div class="input-error">
                   {{ $message }}
                </div>
            @enderror
       </div>

       <div class="mypage__form-group">
            <label class="mypage__label">住所</label>
            <input class="mypage__input" type="text" name="address" value="{{ old('address', $address->address ?? '') }}">
            @error('address')
                <div class="input-error">
                   {{ $message }}
                </div>
            @enderror
       </div>

       <div class="mypage__form-group">
            <label class="mypage__label">建物名</label>
            <input class="mypage__input" type="text" name="building" value="{{ old('building', $address->building ?? '') }}">
       </div>

       <button class="mypage__button" type="submit">更新する</button>
    </form>
</div>

@endsection