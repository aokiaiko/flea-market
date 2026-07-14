@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/addresses/edit.css') }}">
@endsection

@section('content')

<div class="form__content">
    <div class="form__title">
        <h1>住所の変更</h1>
    </div>
    <form class="form" method="POST" action="/purchase/address/{{ $item_id }}">
        @csrf
        @method('PATCH')
        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <input class="form__input" type="text" name="postcode" value="{{ old('postcode', optional($address)->postcode) }}"/>
            @error('postcode')
               <div class="input-error">
                {{$message}}
               </div>
            @enderror
        </div>

       <div class="form__group">
            <label class="form__label">住所</label>
            <input class="form__input" type="text" name="address" value="{{ old('address', optional($address)->address) }}"/>
             @error('address')
               <div class="input-error">
                {{$message}}
               </div>
            @enderror
       </div>

       <div class="form__group">
            <label class="form__label">建物名</label>
            <input class="form__input" type="text" name="building" value="{{ old('building', optional($address)->building) }}"/>
       </div>


       <button class="form__button" type="submit">更新する</button>
    </form>

    
</div>

@endsection