@extends("Layout.auth")
@section("title","Register")

@section("content")
    <div class="container">
        <section class="sec1">
        </section>
        <section class="sec2">
            @if (session()->has("success"))
                <div class="alert alert-success">
                    {{ session()->get("success") }}
                </div>
            @endif
            @if (session()->has("error"))
                <div class="alert alert-success">
                    {{ session()->get("error") }}
                </div>
            @endif
            <div class="header">
                <h1>REGISTER</h1>
            </div>
            <div class="cardlogin">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                        <label for="name">NAME: </label>
                        <input type="text" id="name" name="name" required>

                        <label for="email">EMAIL ADDRESS: </label>
                        <input type="text" id="email" name="email" required>

                        <label for="password">PASSWORD: </label>
                        <input type="password" id="password" name="password" required>

                        <label for="password_confirmation">CONFIRM PASSWORD: </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>

                    <button type="submit">REGISTER</button>
                    <p>Have account? <a href="/">Login</a> here</p>
                </form>
            </div>
        </section>
    </div>
@endsection