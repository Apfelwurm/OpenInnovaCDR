@extends ('layouts.default')

@section ('page_title', 'Login')

@section ('content')

    <div class="container">
        <div class="pb-2 mt-4 mb-4 border-bottom">
            <h1>@lang('auth.please_login')</h1>
        </div>
        <div class="row">
            <div class="col">
                    <form method="POST" action="/login">
                        @csrf
                        <div class="form-group row">

                            <div class="col @error('username') is-invalid @enderror">
                                <input type="text" id="username" name="username" class="form-control" placeholder="@lang('auth.username')" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col @error('password') is-invalid @enderror">
                                <input type="password" id="password" name="password" class="form-control" placeholder="@lang('auth.password')" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" value="remember-me"> @lang('auth.remember')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('auth.signin')</button>
                            </div>
                        </div>

                    </form>
            </div>
        </div>
    </div>

@endsection
