@extends('layouts.app')

@section('content')
<header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторррская</span>
</header>
  
<main>
    <section class="login">
        <header class="login__header">
            <h2 class="login__title">Авторизация</h2>
        </header>
        <div class="login__wrapper">
            <form class="login__form" action="{{ route('login') }}" method="POST">
                @csrf
                <label class="login__label" for="mail">
                    E-mail
                    <input class="login__input form-control @error('email') is-invalid @enderror" id="email" type="email" placeholder="example@domain.xyz" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </label>
                <label class="login__label" for="pwd">
                    Пароль
                    <input id="password" class="login__input form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </label>
                <div class="text-center">
                    <input value="Авторизоваться" type="submit" class="login__button">
                </div>
            </form>
        </div>
    </section>
</main>

  <script src="js/accordeon.js"></script>
@endsection
