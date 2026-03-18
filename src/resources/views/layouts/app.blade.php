<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    @yield('css')
</head>
<body>
    <header class="toppage-header">
      <div class="header__inner">
        <img class="header__logo" src="{{ asset('images/logo.png')}}">
     
        <div class="header__form">
         <form action="/" method="GET">
          <input class="search__form-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
         </form>
        </div>

        <nav class="header-nav">
         <ul class="header-nav__item">
           @if(Auth::check())
           <li class="nav-item">
            <form class="form" action="/logout" method="POST">
              @csrf
              <button class="nav-link" type="submit">ログアウト</button>
            </form>
           </li>
           <li class="nav-item"><a href="/mypage">マイページ</a></li>
           <li class="nav-item"><a class="header__nav-button" href="/sell">出品</a></li>
           @else
           <li class="nav-item"><a href="/login">ログイン</a></li>
           
           <li class="nav-item"><a href="/login">マイページ</a></li>
           <li class="nav-item"><a class="header__nav-button" href="/login">出品</a></li>
           @endif
          </ul>
        </nav>
      </div>
     
    </header>

  <main>
    @yield('content')
  </main>
</body>
</html>