@extends('layouts.auth')

@section('css')

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">

@endsection

@section('content')

<div class="verify-email__container">
 <div class="verify-email__wrapper">
    <h1 class="visually-hidden">メール認証</h1>
    <p class="verify-email__text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

<a href="http://localhost:8025" class="verify-email__button">
        認証はこちらから
    </a>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="resend-button">
            認証メールを再送する
        </button>
    </form>

    @if (session('status'))
        <div class="success-message">
            認証メールを再送しました。
        </div>
    @endif
 </div>
</div>

@endsection    