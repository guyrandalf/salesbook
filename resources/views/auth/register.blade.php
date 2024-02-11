<x-layout.auth>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form method="POST" action="{{ route('register.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="firstname" type="text" class="form-control"
                                            placeholder="First Name" value="{{ old('firstname') }}">
                                        @if ($errors->has('firstname'))
                                            <small class="text-danger">{{ $errors->first('firstname') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="lastname" type="text" class="form-control"
                                            placeholder="Last Name" value="{{ old('lastname') }}">
                                        @if ($errors->has('lastname'))
                                            <small class="text-danger">{{ $errors->first('lastname') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control"
                                        placeholder="Email Address" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control"
                                            placeholder="Password">
                                        @if ($errors->has('password'))
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="password_confirmation" type="password" class="form-control"
                                            placeholder="Repeat Password">
                                        @if ($errors->has('password_confirmation'))
                                            <small
                                                class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                    Create Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('password') }}">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.auth>
