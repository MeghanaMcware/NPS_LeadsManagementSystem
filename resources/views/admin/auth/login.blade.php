<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | NPS Digital Leads Management</title>

    {{-- Bootstrap 5 + Icons + Inter font --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nps-primary: #2f6fed;
            --nps-primary-dark: #2456e8;
            --nps-navy: #0a1840;
            --nps-muted: #7a859b;
            --nps-border: #e3e8f2;
            --nps-danger: #dc3545;
            --nps-success: #1c9a56;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f6f8fd;
            color: #0f1a33;
            min-height: 100vh;
        }

        .login-layout { min-height: 100vh; }

        /* ---------- Left brand panel ---------- */
        .brand-panel {
            position: relative;
            overflow: hidden;
            color: #fff;
            height: 100%;
            min-height: 100vh;
            background: radial-gradient(600px 500px at 85% 10%, #0a1840 0%, transparent 60%), radial-gradient(500px 500px at 10% 95%, #0a1840 0%, transparent 60%), linear-gradient(145deg, #0a1840 0%, #112a73 55%, #0a1840 100%);
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .05) 1px, transparent 1px);
            background-size: 48px 48px;
            -webkit-mask-image: radial-gradient(ellipse at 40% 40%, #000 20%, transparent 75%);
            mask-image: radial-gradient(ellipse at 40% 40%, #000 20%, transparent 75%);
        }

        .brand-inner {
            position: relative;
            z-index: 1;
            padding: 3.5rem 4rem;
            min-height: 100vh;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            color: #1f55e0;
            font-weight: 800;
            font-size: 24px;
            display: grid;
            place-items: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .25);
        }

        .brand-title {
            font-size: clamp(2.2rem, 3.4vw, 3.4rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
        }

        .brand-title em {
            font-style: normal;
            background: linear-gradient(90deg, #9fc4ff, #d6c8ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .brand-sub { color: #cddcff; max-width: 520px; font-size: 1.05rem; line-height: 1.6; }

        .float-card {
            background: #fff;
            color: #0f1a33;
            border-radius: 20px;
            box-shadow: 0 28px 60px rgba(4, 12, 40, .4);
        }

        .mini-bars { display: flex; align-items: flex-end; gap: 7px; height: 44px; }
        .mini-bars i { flex: 1; border-radius: 4px; background: #cfdcfb; }
        .mini-bars i:last-child { background: linear-gradient(#4f8bff, #2f6fed); }

        .wa-bubble {
            background: #dcf8c6;
            border-radius: 4px 14px 14px 14px;
            font-size: .82rem;
            line-height: 1.45;
        }

        /* ---------- Right form panel ---------- */
        .form-panel { width: 100%; height: 100%; min-height: 100vh; background: #fff; }

        .login-card {
            width: 100%;
            max-width: 600px;
            background: #fff;
            border: 0;
            padding: 2.75rem 2.5rem;
        }

        .welcome-tag {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #eef3ff;
            color: #021b45;
            font-size: .75rem;
            font-weight: 700;
            padding: .4rem .8rem;
            border-radius: 50rem;
        }

        .login-card h2 { font-weight: 800; letter-spacing: -.8px; }

        .form-label {
            font-size: .75rem;
            font-weight: 700;
            color: #4a5670;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .input-group-text {
            background: #fbfcff;
            border: 1.5px solid var(--nps-border);
            border-right: 0;
            color: #8a95ab;
            border-radius: 14px 0 0 14px;
            padding-left: 1rem;
        }

        .form-control {
            height: 54px;
            border: 1.5px solid var(--nps-border);
            border-left: 0;
            background: #fbfcff;
            font-size: .95rem;
            border-radius: 0 14px 14px 0;
        }

        .form-control::placeholder { color: #aab3c5; }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--nps-primary);
            background: #fff;
        }

        .input-group:focus-within { border-radius: 14px; box-shadow: 0 0 0 4px rgba(47, 111, 237, .12); }
        .input-group:focus-within .input-group-text { color: var(--nps-primary); }
        .form-control:focus { box-shadow: none; }

        /* Validation state */
        .input-group.has-error .input-group-text,
        .input-group.has-error .form-control { border-color: var(--nps-danger); }
        .input-group.has-error:focus-within { box-shadow: 0 0 0 4px rgba(220, 53, 69, .12); }
        .input-group.has-error .input-group-text { color: var(--nps-danger); }

        .toggle-pass {
            border: 1.5px solid var(--nps-border);
            border-left: 0;
            background: #fbfcff;
            color: var(--nps-primary);
            font-weight: 700;
            font-size: .8rem;
            border-radius: 0 14px 14px 0 !important;
            padding: 0 1rem;
        }

        .input-group.has-error .toggle-pass { border-color: var(--nps-danger); }
        .input-group:focus-within .toggle-pass { border-color: var(--nps-primary); background: #fff; }
        .input-group > .form-control.pass { border-radius: 0; border-right: 0; }

        .form-check-input { width: 1.2rem; height: 1.2rem; border-radius: 6px !important; border-color: #c3cbdc; }
        .form-check-input:checked { background-color: var(--nps-primary); border-color: var(--nps-primary); }
        .form-check-label { font-size: .88rem; padding-left: .25rem; }

        .link-primary-nps { color: var(--nps-primary); font-weight: 700; text-decoration: none; font-size: .88rem; }
        .link-primary-nps:hover { text-decoration: underline; }

        .btn-nps {
            height: 56px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #021b45, #021b45);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 12px 28px rgba(47, 111, 237, .4);
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }

        .btn-nps:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 16px 32px rgba(47, 111, 237, .45); }
        .btn-nps:disabled { opacity: .55; transform: none; box-shadow: none; color: #fff; }
        .btn-nps:focus-visible, .btn-outline-nps:focus-visible { outline: 3px solid rgba(47, 111, 237, .4); outline-offset: 2px; }

        .btn-outline-nps {
            height: 54px;
            border: 1.5px solid var(--nps-border);
            border-radius: 14px;
            font-weight: 700;
            font-size: .95rem;
            color: #1c2333;
            background: #fff;
        }

        .btn-outline-nps:hover { border-color: var(--nps-primary); color: var(--nps-primary); background: #f5f8ff; }

        .divider { display: flex; align-items: center; gap: 1rem; color: #9aa5ba; font-size: .8rem; }
        .divider::before, .divider::after { content: ""; flex: 1; height: 1px; background: #e6eaf3; }

        .invalid-feedback { font-size: .8rem; font-weight: 500; }
        .invalid-feedback i { margin-right: .25rem; }

        .alert-nps { border: 0; border-radius: 14px; font-size: .875rem; }

        /* ---------- View switching (email / OTP) ---------- */
        .view { display: none; }
        .view.is-active { display: block; animation: viewIn .28s ease both; }
        @keyframes viewIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ---------- OTP flow ---------- */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 0;
            background: transparent;
            padding: 0;
            color: var(--nps-muted);
            font-weight: 600;
            font-size: .88rem;
        }
        .back-link:hover { color: var(--nps-primary); }

        .otp-steps { display: flex; gap: 8px; margin: 1.1rem 0 1.4rem; }
        .otp-steps span {
            height: 5px;
            width: 44px;
            border-radius: 99px;
            background: #e3e8f2;
            transition: background .3s;
        }
        .otp-steps span.is-on { background: var(--nps-primary); }

        .phone-prefix {
            gap: .5rem;
            font-weight: 700;
            color: #1c2333;
            font-size: .95rem;
        }
        .phone-prefix i { color: #8a95ab; }
        .input-group:focus-within .phone-prefix i { color: var(--nps-primary); }
        .phone-input { letter-spacing: .5px; font-weight: 500; }

        .otp-sent-to {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: #f3f7ff;
            border: 1px solid #dfe9ff;
            border-radius: 14px;
            padding: .8rem 1rem;
            font-size: .9rem;
        }
        .otp-sent-to .ic {
            width: 34px; height: 34px; border-radius: 50%;
            background: #dbe7ff; color: var(--nps-primary);
            display: grid; place-items: center; flex: none;
        }

        .otp-boxes { display: flex; gap: 10px; justify-content: space-between; }
        .otp-box {
            flex: 1 1 0;
            min-width: 0;
            height: 64px;
            border: 1.5px solid var(--nps-border);
            border-radius: 14px;
            background: #fbfcff;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f1a33;
            caret-color: var(--nps-primary);
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .otp-box:focus {
            outline: 0;
            border-color: var(--nps-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(47, 111, 237, .12);
        }
        .otp-box.filled { border-color: #b9cdf7; background: #fff; }
        .otp-boxes.is-error .otp-box { border-color: var(--nps-danger); background: #fff7f8; }
        .otp-boxes.is-error { animation: shake .4s; }
        .otp-boxes.is-ok .otp-box { border-color: var(--nps-success); background: #f3fbf6; color: var(--nps-success); }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-7px); }
            40% { transform: translateX(7px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
        }

        .otp-msg { min-height: 22px; font-size: .85rem; font-weight: 600; margin-top: .75rem; }
        .otp-msg.err { color: var(--nps-danger); }
        .otp-msg.ok { color: var(--nps-success); }

        .resend-row { font-size: .88rem; color: var(--nps-muted); }
        .resend-btn {
            border: 0; background: transparent; padding: 0;
            color: var(--nps-primary); font-weight: 700; font-size: .88rem;
        }
        .resend-btn:disabled { color: #a9b2c4; cursor: not-allowed; }
        .timer { font-variant-numeric: tabular-nums; font-weight: 700; color: #1c2333; }

        .demo-hint {
            background: #fff8e6;
            border: 1px dashed #f0cf85;
            color: #8a6410;
            border-radius: 12px;
            font-size: .8rem;
            padding: .55rem .8rem;
        }

        /* Success state */
        .success-wrap { text-align: center; padding: 1.5rem 0; }
        .success-ring {
            width: 84px; height: 84px; border-radius: 50%;
            background: #e1f6ea; color: var(--nps-success);
            display: grid; place-items: center; margin: 0 auto 1.25rem;
            font-size: 2.4rem;
            animation: pop .45s cubic-bezier(.2, 1.4, .4, 1) both;
        }
        @keyframes pop { from { transform: scale(.4); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        /* ---------- Responsive ---------- */
        @media (max-width: 991.98px) {
            .form-panel { padding: 1.5rem 1rem; }
            .mobile-brand { display: flex !important; }
        }

        @media (max-width: 575.98px) {
            .login-card { padding: 2rem 1.35rem; border-radius: 22px; }
            .login-card h2 { font-size: 1.6rem; }
            .otp-boxes { gap: 7px; }
            .otp-box { height: 56px; font-size: 1.35rem; border-radius: 12px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .view.is-active, .success-ring, .otp-boxes.is-error { animation: none; }
        }
    </style>
</head>

<body>
<div class="container-fluid p-0">
    <div class="row g-0 login-layout align-items-stretch">

        {{-- ================= LEFT : BRAND PANEL (desktop only) ================= --}}
        <div class="col-lg-6 d-none d-lg-block">
            <div class="brand-panel">
                <div class="brand-inner d-flex flex-column">

                    <div class="d-flex align-items-center gap-3">
                        <div class="brand-mark"><img src="{{ asset('admin/assets/images/logo/NPS_logo (1).png') }}" width="100%" alt="NPS Digital"></div>
                        <div>
                            <div class="fw-bold fs-5">NATIONAL PUBLIC SCHOOL</div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4">
                        <h1 class="brand-title">Leads Management <em>System.</em></h1>
                        <p class="brand-sub mt-4">
                            Capture, track and follow up all your leads in one place &mdash;
                            with automatic WhatsApp and SMS greetings.
                        </p>
                    </div>

                    <div class="row g-3 mt-4">
                        <div class="col-xl-5">
                            <div class="float-card p-3 h-100">
                                <small class="text-secondary fw-semibold">New leads today</small>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="fs-1 fw-bold lh-1">24</span>
                                    <span class="badge rounded-pill" style="background:#e1f6ea;color:#1d9a5b">+18%</span>
                                </div>
                                <div class="mini-bars">
                                    <i style="height:35%"></i><i style="height:55%"></i><i style="height:42%"></i>
                                    <i style="height:70%"></i><i style="height:60%"></i><i style="height:82%"></i>
                                    <i style="height:100%"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <div class="float-card p-3 h-100">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-grid fw-bold"
                                         style="width:42px;height:42px;place-items:center;background:#dbe7ff;color:var(--nps-primary)">A</div>
                                    <div class="lh-sm">
                                        <div class="fw-semibold small">Anita Desai</div>
                                        <small class="text-secondary">+91 99001 55678</small>
                                    </div>
                                    <span class="badge rounded-pill ms-auto" style="background:#fff3dc;color:#d98a00">Contacted</span>
                                </div>
                                <div class="wa-bubble p-2 px-3 mt-3">
                                    Hi Anita, welcome to NPS Digital! How can we help you today?
                                    <div style="font-size:.65rem;color:#5d7f5d" class="mt-1">
                                        Sent automatically &bull; 10:42 <i class="bi bi-check2-all"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= RIGHT : LOGIN FORM ================= --}}
        <div class="col-lg-6">
            <div class="form-panel d-flex flex-column align-items-center justify-content-center">

                {{-- Brand (mobile / tablet only) --}}
                <div class="mobile-brand align-items-center gap-3 mb-4" style="display:none">
                    <div class="brand-mark" style="background:linear-gradient(135deg,#3b7cff,#2456e8);color:#fff">N</div>
                    <div>
                        <div class="fw-bold">NPS Digital</div>
                        <small class="text-secondary">Leads Management System</small>
                    </div>
                </div>

                <div class="login-card"
                     id="loginCard"
                     {{-- Set this to the page opened after a successful OTP, e.g. url('/dashboard'). Empty = stay on page (static demo). --}}
                     data-redirect="">

                    {{-- =====================================================
                         VIEW 1 : EMAIL + PASSWORD
                    ===================================================== --}}
                    <div class="view is-active" id="viewEmail">
                        <span class="welcome-tag"><i class="bi bi-hand-thumbs-up-fill"></i> Welcome back</span>
                        <h2 class="mt-3 mb-1">Sign in to your portal</h2>
                        <p class="text-secondary mb-4">Manage leads, send messages and track status.</p>

                        @if (session('status'))
                            <div class="alert alert-success alert-nps d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-nps d-flex align-items-start" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <div>
                                    <strong>Unable to sign in.</strong>
                                    <div class="small">Please correct the highlighted fields and try again.</div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.submit') }}" class="needs-validation" id="loginForm" novalidate>
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group @error('email') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           id="email" style="border-radius: 0px 15px 15px 0px !important;"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="you@company.com"
                                           autocomplete="username"
                                           required
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback d-block w-100">
                                            <i class="bi bi-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback w-100">
                                            <i class="bi bi-exclamation-circle"></i>Please enter a valid email address.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group @error('password') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control pass @error('password') is-invalid @enderror"
                                           placeholder="Enter your password"
                                           autocomplete="current-password"
                                           minlength="6"
                                           required>
                                    <button class="btn toggle-pass" type="button" id="togglePassword" aria-label="Show or hide password">
                                        Show
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback d-block w-100">
                                            <i class="bi bi-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback w-100">
                                            <i class="bi bi-exclamation-circle"></i>Password is required (minimum 6 characters).
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Remember + Forgot --}}
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-primary-nps">Forgot password?</a>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-nps w-100 d-flex align-items-center justify-content-center gap-2" id="loginBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status" aria-hidden="true"></span>
                                <span id="loginText">Sign in</span>
                                <i class="bi bi-arrow-right" id="loginArrow"></i>
                            </button>
                        </form>

                        <div class="divider my-4">or continue with</div>

                        {{-- Opens the OTP flow (view 2) --}}
                        <button type="button" id="btnShowOtp"
                                class="btn btn-outline-nps w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-phone"></i> Sign in with OTP
                        </button>
                    </div>

                    {{-- =====================================================
                         VIEW 2 : OTP SIGN IN
                    ===================================================== --}}
                    <div class="view" id="viewOtp">

                        <button type="button" class="back-link" id="btnBackEmail">
                            <i class="bi bi-arrow-left"></i> Back to email sign in
                        </button>

                        <div class="otp-steps" aria-hidden="true">
                            <span class="is-on" id="stepDot1"></span>
                            <span id="stepDot2"></span>
                        </div>

                        {{-- ---- Step 1 : mobile number ---- --}}
                        <div id="otpStepPhone">
                            <h2 class="mb-1">Sign in with OTP</h2>
                            <p class="text-secondary mb-4">Enter your registered mobile number and we will send you a 6-digit code.</p>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Mobile number</label>
                                <div class="input-group" id="phoneGroup">
                                    <span class="input-group-text phone-prefix"><i class="bi bi-phone"></i> +91</span>
                                    <input type="tel"
                                           id="phone"
                                           class="form-control phone-input"
                                           placeholder="98450 11223"
                                           inputmode="numeric"
                                           autocomplete="tel-national"
                                           maxlength="11">
                                </div>
                                <div class="text-danger small fw-medium mt-2 d-none" id="phoneError">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>Enter a valid 10-digit mobile number.</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-nps w-100 d-flex align-items-center justify-content-center gap-2 mt-4" id="btnSendOtp" disabled>
                                <span class="spinner-border spinner-border-sm d-none" id="sendSpinner" role="status" aria-hidden="true"></span>
                                <span id="sendText">Send OTP</span>
                                <i class="bi bi-arrow-right" id="sendArrow"></i>
                            </button>

                            <p class="text-secondary small text-center mt-4 mb-0">
                                <i class="bi bi-shield-check"></i> Standard SMS rates may apply. We never share your number.
                            </p>
                        </div>

                        {{-- ---- Step 2 : enter code ---- --}}
                        <div id="otpStepCode" class="d-none">
                            <h2 class="mb-1">Enter the code</h2>
                            <p class="text-secondary mb-3">We sent a 6-digit code by SMS. It is valid for 5 minutes.</p>

                            <div class="otp-sent-to mb-4">
                                <span class="ic"><i class="bi bi-chat-dots"></i></span>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold" id="maskedPhone">+91 98XXX XX123</div>
                                </div>
                                <button type="button" class="link-primary-nps border-0 bg-transparent p-0" id="btnChangeNumber">Change</button>
                            </div>

                            <div class="otp-boxes" id="otpBoxes" role="group" aria-label="6-digit verification code">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" aria-label="Digit 1">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" aria-label="Digit 2">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" aria-label="Digit 3">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" aria-label="Digit 4">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" aria-label="Digit 5">
                                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" aria-label="Digit 6">
                            </div>

                            <div class="otp-msg" id="otpMsg" aria-live="polite"></div>

                            <button type="button" class="btn btn-nps w-100 d-flex align-items-center justify-content-center gap-2 mt-2" id="btnVerify" disabled>
                                <span class="spinner-border spinner-border-sm d-none" id="verifySpinner" role="status" aria-hidden="true"></span>
                                <span id="verifyText">Verify and sign in</span>
                                <i class="bi bi-arrow-right" id="verifyArrow"></i>
                            </button>

                            <div class="resend-row d-flex justify-content-center align-items-center gap-1 mt-4">
                                <span id="resendLabel">Resend code in <span class="timer" id="otpTimer">00:30</span></span>
                                <button type="button" class="resend-btn d-none" id="btnResend">Resend code</button>
                            </div>

                            {{-- Static demo only. Delete this block when you connect a real SMS service. --}}
                            <div class="demo-hint mt-4 text-center">
                                <i class="bi bi-info-circle"></i> Demo mode: use code <b>123456</b>
                            </div>
                        </div>

                        {{-- ---- Step 3 : success ---- --}}
                        <div id="otpStepDone" class="d-none success-wrap">
                            <div class="success-ring"><i class="bi bi-check-lg"></i></div>
                            <h2 class="mb-1">Verified</h2>
                            <p class="text-secondary mb-0" id="doneText">Signing you in to your portal...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        'use strict';

        var $ = function (id) { return document.getElementById(id); };

        /* =====================================================
           EMAIL + PASSWORD (existing behaviour)
        ===================================================== */
        var form       = $('loginForm');
        var password   = $('password');
        var toggleBtn  = $('togglePassword');
        var loginBtn   = $('loginBtn');
        var spinner    = $('loginSpinner');
        var loginText  = $('loginText');
        var loginArrow = $('loginArrow');

        toggleBtn.addEventListener('click', function () {
            var show = password.type === 'password';
            password.type = show ? 'text' : 'password';
            toggleBtn.textContent = show ? 'Hide' : 'Show';
        });

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.querySelectorAll('.input-group').forEach(function (group) {
                    var input = group.querySelector('input');
                    group.classList.toggle('has-error', !input.checkValidity());
                });
            } else {
                loginBtn.disabled = true;
                spinner.classList.remove('d-none');
                loginArrow.classList.add('d-none');
                loginText.textContent = 'Signing in...';
            }
            form.classList.add('was-validated');
        }, false);

        form.querySelectorAll('input').forEach(function (input) {
            input.addEventListener('input', function () {
                input.classList.remove('is-invalid');
                var group = input.closest('.input-group');
                if (group) {
                    group.classList.toggle('has-error', !input.checkValidity());
                    var server = group.querySelector('.invalid-feedback.d-block');
                    if (server) server.classList.remove('d-block');
                }
            });
        });

        /* =====================================================
           OTP SIGN IN (static demo)
           Replace the setTimeout blocks with fetch() calls to your
           routes when the backend is ready (see comments).
        ===================================================== */
        var DEMO_CODE    = '123456';   // remove when using a real SMS service
        var OTP_LENGTH   = 6;
        var RESEND_SECS  = 30;
        var MAX_ATTEMPTS = 3;

        var card        = $('loginCard');
        var viewEmail   = $('viewEmail');
        var viewOtp     = $('viewOtp');
        var stepPhone   = $('otpStepPhone');
        var stepCode    = $('otpStepCode');
        var stepDone    = $('otpStepDone');
        var dot1        = $('stepDot1');
        var dot2        = $('stepDot2');

        var phoneInput  = $('phone');
        var phoneGroup  = $('phoneGroup');
        var phoneError  = $('phoneError');
        var btnSend     = $('btnSendOtp');
        var sendSpinner = $('sendSpinner');
        var sendText    = $('sendText');
        var sendArrow   = $('sendArrow');

        var boxesWrap   = $('otpBoxes');
        var boxes       = Array.prototype.slice.call(boxesWrap.querySelectorAll('.otp-box'));
        var otpMsg      = $('otpMsg');
        var btnVerify   = $('btnVerify');
        var verifySpin  = $('verifySpinner');
        var verifyText  = $('verifyText');
        var verifyArrow = $('verifyArrow');
        var maskedPhone = $('maskedPhone');
        var timerEl     = $('otpTimer');
        var resendLabel = $('resendLabel');
        var btnResend   = $('btnResend');

        var attemptsLeft = MAX_ATTEMPTS;
        var timerId = null;
        var phoneDigits = '';

        function showView(name) {
            viewEmail.classList.toggle('is-active', name === 'email');
            viewOtp.classList.toggle('is-active', name === 'otp');
        }

        function showStep(name) {
            stepPhone.classList.toggle('d-none', name !== 'phone');
            stepCode.classList.toggle('d-none', name !== 'code');
            stepDone.classList.toggle('d-none', name !== 'done');
            dot1.classList.add('is-on');
            dot2.classList.toggle('is-on', name !== 'phone');
            // Restart the entrance animation for the new step
            stepCode.style.animation = 'none';
            void stepCode.offsetWidth;
            stepCode.style.animation = '';
        }

        /* ---- switch between email and OTP ---- */
        $('btnShowOtp').addEventListener('click', function () {
            showView('otp');
            showStep('phone');
            phoneInput.focus();
        });

        $('btnBackEmail').addEventListener('click', function () {
            stopTimer();
            resetCode();
            showView('email');
            $('email').focus();
        });

        /* ---- step 1 : phone number ---- */
        function digitsOnly(value) { return value.replace(/\D/g, ''); }

        function formatPhone(digits) {
            return digits.length > 5 ? digits.slice(0, 5) + ' ' + digits.slice(5) : digits;
        }

        function isValidPhone(digits) { return /^[6-9]\d{9}$/.test(digits); }

        function setPhoneError(show) {
            phoneGroup.classList.toggle('has-error', show);
            phoneError.classList.toggle('d-none', !show);
        }

        phoneInput.addEventListener('input', function () {
            phoneDigits = digitsOnly(phoneInput.value).slice(0, 10);
            phoneInput.value = formatPhone(phoneDigits);
            btnSend.disabled = phoneDigits.length !== 10;
            if (phoneDigits.length === 10) {
                setPhoneError(!isValidPhone(phoneDigits));
                if (!isValidPhone(phoneDigits)) btnSend.disabled = true;
            } else {
                setPhoneError(false);
            }
        });

        phoneInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !btnSend.disabled) { e.preventDefault(); sendOtp(); }
        });

        function setSending(on) {
            btnSend.disabled = on;
            sendSpinner.classList.toggle('d-none', !on);
            sendArrow.classList.toggle('d-none', on);
            sendText.textContent = on ? 'Sending code...' : 'Send OTP';
        }

        function sendOtp() {
            if (!isValidPhone(phoneDigits)) { setPhoneError(true); return; }
            setSending(true);

            /* Real version:
               fetch('/otp/send', {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                   },
                   body: JSON.stringify({ phone: phoneDigits })
               }).then(...)
            */
            setTimeout(function () {
                setSending(false);
                maskedPhone.textContent = '+91 ' + phoneDigits.slice(0, 2) + 'XXX XX' + phoneDigits.slice(-3);
                attemptsLeft = MAX_ATTEMPTS;
                resetCode();
                showStep('code');
                startTimer();
                boxes[0].focus();
            }, 1100);
        }

        btnSend.addEventListener('click', sendOtp);

        $('btnChangeNumber').addEventListener('click', function () {
            stopTimer();
            resetCode();
            showStep('phone');
            phoneInput.focus();
        });

        /* ---- step 2 : code boxes ---- */
        function getCode() {
            return boxes.map(function (b) { return b.value; }).join('');
        }

        function setMessage(text, type) {
            otpMsg.textContent = text || '';
            otpMsg.className = 'otp-msg' + (type ? ' ' + type : '');
        }

        function refreshState() {
            var code = getCode();
            boxes.forEach(function (b) { b.classList.toggle('filled', b.value !== ''); });
            btnVerify.disabled = code.length !== OTP_LENGTH || attemptsLeft <= 0;
        }

        function clearError() {
            boxesWrap.classList.remove('is-error');
            setMessage('');
        }

        function resetCode() {
            boxes.forEach(function (b) { b.value = ''; b.disabled = false; });
            boxesWrap.classList.remove('is-error', 'is-ok');
            setMessage('');
            btnVerify.disabled = true;
            setVerifying(false);
        }

        boxes.forEach(function (box, i) {
            box.addEventListener('input', function () {
                var digit = digitsOnly(box.value);
                box.value = digit.slice(-1);
                clearError();
                if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
                refreshState();
                if (getCode().length === OTP_LENGTH) setTimeout(verifyOtp, 180);
            });

            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !box.value && i > 0) {
                    boxes[i - 1].value = '';
                    boxes[i - 1].focus();
                    refreshState();
                    e.preventDefault();
                } else if (e.key === 'ArrowLeft' && i > 0) {
                    boxes[i - 1].focus();
                    e.preventDefault();
                } else if (e.key === 'ArrowRight' && i < boxes.length - 1) {
                    boxes[i + 1].focus();
                    e.preventDefault();
                } else if (e.key === 'Enter' && !btnVerify.disabled) {
                    e.preventDefault();
                    verifyOtp();
                }
            });

            box.addEventListener('focus', function () { box.select(); });

            box.addEventListener('paste', function (e) {
                var text = (e.clipboardData || window.clipboardData).getData('text');
                var digits = digitsOnly(text).slice(0, OTP_LENGTH);
                if (!digits) return;
                e.preventDefault();
                digits.split('').forEach(function (d, k) { if (boxes[k]) boxes[k].value = d; });
                boxes[Math.min(digits.length, boxes.length - 1)].focus();
                clearError();
                refreshState();
                if (getCode().length === OTP_LENGTH) setTimeout(verifyOtp, 180);
            });
        });

        /* ---- verify ---- */
        function setVerifying(on) {
            verifySpin.classList.toggle('d-none', !on);
            verifyArrow.classList.toggle('d-none', on);
            verifyText.textContent = on ? 'Verifying...' : 'Verify and sign in';
            if (on) btnVerify.disabled = true;
        }

        var verifying = false;

        function verifyOtp() {
            var code = getCode();
            if (verifying || code.length !== OTP_LENGTH || attemptsLeft <= 0) return;
            verifying = true;
            setVerifying(true);
            boxes.forEach(function (b) { b.disabled = true; });

            /* Real version:
               fetch('/otp/verify', { method: 'POST', headers: {...}, body: JSON.stringify({ phone: phoneDigits, code: code }) })
                 .then(function (r) { return r.json(); })
                 .then(function (res) { res.ok ? onSuccess() : onFail(); });
            */
            setTimeout(function () {
                verifying = false;
                setVerifying(false);
                if (code === DEMO_CODE) onSuccess(); else onFail();
            }, 900);
        }

        btnVerify.addEventListener('click', verifyOtp);

        function onSuccess() {
            stopTimer();
            boxesWrap.classList.add('is-ok');
            setMessage('Code verified', 'ok');
            setTimeout(function () {
                showStep('done');
                var url = card.getAttribute('data-redirect');
                if (url) {
                    setTimeout(function () { window.location.href = url; }, 1400);
                } else {
                    $('doneText').textContent = 'Demo complete. Set data-redirect on the card to open your dashboard.';
                }
            }, 500);
        }

        function onFail() {
            attemptsLeft--;
            boxes.forEach(function (b) { b.disabled = false; });
            boxesWrap.classList.remove('is-error');
            void boxesWrap.offsetWidth;            // restart shake animation
            boxesWrap.classList.add('is-error');

            if (attemptsLeft > 0) {
                setMessage('That code is not correct. ' + attemptsLeft + (attemptsLeft === 1 ? ' attempt' : ' attempts') + ' left.', 'err');
                boxes.forEach(function (b) { b.value = ''; });
                boxes[0].focus();
            } else {
                setMessage('Too many wrong attempts. Please request a new code.', 'err');
                boxes.forEach(function (b) { b.disabled = true; });
            }
            refreshState();
        }

        /* ---- resend timer ---- */
        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function stopTimer() {
            if (timerId) { clearInterval(timerId); timerId = null; }
        }

        function startTimer() {
            stopTimer();
            var left = RESEND_SECS;
            resendLabel.classList.remove('d-none');
            btnResend.classList.add('d-none');
            timerEl.textContent = '00:' + pad(left);

            timerId = setInterval(function () {
                left--;
                timerEl.textContent = pad(Math.floor(left / 60)) + ':' + pad(left % 60);
                if (left <= 0) {
                    stopTimer();
                    resendLabel.classList.add('d-none');
                    btnResend.classList.remove('d-none');
                }
            }, 1000);
        }

        btnResend.addEventListener('click', function () {
            /* Real version: call your resend route here. */
            attemptsLeft = MAX_ATTEMPTS;
            resetCode();
            startTimer();
            setMessage('A new code has been sent.', 'ok');
            boxes[0].focus();
        });

    })();
</script>
</body>
</html>