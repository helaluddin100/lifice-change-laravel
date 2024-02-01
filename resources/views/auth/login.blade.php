    @include('layouts.backend.style')


    <div class="sign-up-top">

        <div class="sign-up-main">
            <div class="sign-up-logo">
                <img src="assets/images/logo/Logo.svg" alt="logo">
            </div>
            <div class="sign-up-text">
                <h2>Sign in to Bankco.</h2>
                <p>Send, spend and save smarter</p>
            </div>

            <div class="sign-up-top-btn">
                <a href="#">
                    <span>
                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.8758 11.2139C20.8758 10.4225 20.8103 9.84497 20.6685 9.24609H11.4473V12.818H16.8599C16.7508 13.7057 16.1615 15.0425 14.852 15.9408L14.8336 16.0603L17.7492 18.2738L17.9512 18.2936C19.8063 16.6145 20.8758 14.1441 20.8758 11.2139Z"
                                fill="#4285F4" />
                            <path
                                d="M11.4467 20.6248C14.0984 20.6248 16.3245 19.7692 17.9506 18.2934L14.8514 15.9405C14.022 16.5073 12.9089 16.903 11.4467 16.903C8.84946 16.903 6.64512 15.224 5.85933 12.9033L5.74415 12.9129L2.7125 15.2122L2.67285 15.3202C4.28791 18.4644 7.60536 20.6248 11.4467 20.6248Z"
                                fill="#34A853" />
                            <path
                                d="M5.86006 12.9034C5.65272 12.3045 5.53273 11.6628 5.53273 10.9997C5.53273 10.3366 5.65272 9.695 5.84915 9.09612L5.84366 8.96857L2.774 6.63232L2.67357 6.67914C2.00792 7.98388 1.62598 9.44905 1.62598 10.9997C1.62598 12.5504 2.00792 14.0155 2.67357 15.3203L5.86006 12.9034Z"
                                fill="#FBBC05" />
                            <path
                                d="M11.4467 5.09664C13.2909 5.09664 14.5349 5.87733 15.2443 6.52974L18.0161 3.8775C16.3138 2.32681 14.0985 1.375 11.4467 1.375C7.60539 1.375 4.28792 3.53526 2.67285 6.6794L5.84844 9.09638C6.64514 6.77569 8.84949 5.09664 11.4467 5.09664Z"
                                fill="#EB4335" />
                        </svg>
                        Sign In with Apple
                    </span>
                </a>
                <a href="#">
                    <span>
                        <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.8744 7.50391C19.7653 7.56519 17.1672 8.85841 17.1672 11.7258C17.2897 14.9959 20.4459 16.1427 20.5 16.1427C20.4459 16.2039 20.0235 17.7049 18.7724 19.2783C17.7795 20.6336 16.6775 22 15.004 22C13.4121 22 12.8407 21.0967 11.004 21.0967C9.03147 21.0967 8.47335 22 6.96314 22C5.28967 22 4.10599 20.5603 3.05896 19.2178C1.69871 17.4606 0.54254 14.703 0.501723 12.0553C0.474217 10.6522 0.774128 9.27304 1.53544 8.10158C2.60998 6.46614 4.52835 5.35595 6.6233 5.31935C8.22845 5.2708 9.65703 6.30777 10.6366 6.30777C11.5754 6.30777 13.3305 5.31935 15.3163 5.31935C16.1735 5.32014 18.4592 5.55173 19.8744 7.50391ZM10.5009 5.03921C10.2151 3.75792 11.004 2.47663 11.7387 1.65931C12.6774 0.670887 14.1601 0 15.4388 0C15.5204 1.28129 15.0031 2.53791 14.0785 3.45312C13.2489 4.44154 11.8203 5.18565 10.5009 5.03921Z"
                                fill="#1A202C" />
                        </svg>
                        Sign In with Apple
                    </span>
                </a>
            </div>

            <div class="sign-up-top-btn-text">
                <p>Or with email</p>
            </div>

            <div class="sign-up-from">
                <div class="sign-up-from-item">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="sign-up-from-inner">
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Inter Your Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="sign-up-from-inner">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Inter Your Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="sign-up-from-inner">

                            <div class="sign-up-from-df">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                {{-- <div class="main-btn">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div> --}}
                            </div>
                        </div>

                        <div class="sign-up-btn">
                            <div class="btn-one">
                                <button type="submit" class="login-btn">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="sign-up-main-two">

            <div class="sign-up-main-two-item">
                <div class="sign-up-img">
                    <img src="assets/images/sign-up.svg" alt="img">
                </div>

                <div class="sign-up-main-two-item-text">
                    <h2>Speady, Easy and Fast</h2>
                    <p>BankCo. help you set saving goals, earn cash back offers, Go to disclaimer for more details and
                        get paychecks up to two days early. Get a $20 bonus when you receive qualifying direct deposits
                    </p>
                </div>
            </div>


        </div>

    </div>
    @include('layouts.backend.js')
