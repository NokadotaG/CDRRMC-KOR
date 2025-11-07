@extends("Layout.auth")
@section("title","Login")

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
                <div class="alert alert-danger">
                    {{ session()->get("error") }}
                </div>
            @endif
            <div class="header">
                <h1>LOG-IN</h1>
            </div>
            <div class="cardlogin">
                <form action="{{route('login.post') }}" method="POST">
                    @csrf
                        <label for="email">EMAIL ADDRESS: </label>
                        <input type="text" id="email" name="email" required>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                        <label for="password">PASSWORD: </label>
                        <input type="password" id="password" name="password" required>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif

                    <button type="submit">LOG IN</button>
                    <p>No account? <a href="/register">Register</a> here</p>
                </form>
            </div>
        </section>
    </div>
@endsection