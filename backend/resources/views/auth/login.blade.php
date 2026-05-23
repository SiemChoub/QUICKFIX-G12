<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <div class="qf-login">
        {{-- Atmospheric background --}}
        <div class="qf-login__atmos" aria-hidden="true">
            <span class="qf-orb qf-orb--1"></span>
            <span class="qf-orb qf-orb--2"></span>
            <span class="qf-grid"></span>
        </div>

        <div class="qf-login__shell">
            {{-- ── Brand panel ── --}}
            <aside class="qf-brandpane">
                <a href="{{ url('/') }}" class="qf-lockup">
                    <span class="qf-lockup__mark"><i class='bx bxs-wrench'></i></span>
                    <span class="qf-lockup__text"><strong>QUICK</strong><span>FIX</span></span>
                    <span class="qf-lockup__tag">ADMIN</span>
                </a>

                <div class="qf-hero">
                    <p class="qf-hero__kicker">Control center</p>
                    <h1 class="qf-hero__title">Every fix,<br><span>under control.</span></h1>
                    <p class="qf-hero__sub">Manage bookings, dispatch fixers, and track every job from request to done — all from one panel.</p>

                    <ul class="qf-hero__list">
                        <li><i class='bx bx-bolt-circle'></i> Real-time booking requests</li>
                        <li><i class='bx bx-user-check'></i> Verified fixer network</li>
                        <li><i class='bx bx-shield-quarter'></i> Secure admin access</li>
                    </ul>
                </div>

                <p class="qf-brandpane__foot">© <script>document.write(new Date().getFullYear())</script> QuickFix. All rights reserved.</p>
            </aside>

            {{-- ── Form panel ── --}}
            <main class="qf-formpane">
                <div class="qf-card">
                    <a href="{{ url('/') }}" class="qf-lockup qf-lockup--mobile">
                        <span class="qf-lockup__mark"><i class='bx bxs-wrench'></i></span>
                        <span class="qf-lockup__text"><strong>QUICK</strong><span>FIX</span></span>
                    </a>

                    <header class="qf-card__head">
                        <h2>Welcome back</h2>
                        <p>Sign in to the QuickFix admin panel.</p>
                    </header>

                    @if ($errors->any())
                        <div class="qf-alert" role="alert">
                            <i class='bx bx-error-circle'></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <span>{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="qf-alert qf-alert--ok" role="status">
                            <i class='bx bx-check-circle'></i>
                            <div><span>{{ session('status') }}</span></div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}" class="qf-form">
                        @csrf

                        <label class="qf-field">
                            <span class="qf-field__label">Email address</span>
                            <span class="qf-input">
                                <i class='bx bx-envelope qf-input__icon'></i>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       placeholder="you@quickfix.com" required autofocus autocomplete="username">
                            </span>
                        </label>

                        <label class="qf-field">
                            <span class="qf-field__row">
                                <span class="qf-field__label">Password</span>
                                <a href="{{ route('password.request') }}" class="qf-link">Forgot?</a>
                            </span>
                            <span class="qf-input">
                                <i class='bx bx-lock-alt qf-input__icon'></i>
                                <input type="password" name="password" id="password"
                                       placeholder="••••••••" required autocomplete="current-password">
                                <button type="button" class="qf-input__toggle" id="qfTogglePw" aria-label="Show password">
                                    <i class='bx bx-show'></i>
                                </button>
                            </span>
                        </label>

                        <label class="qf-remember">
                            <input type="checkbox" name="remember">
                            <span>Keep me signed in</span>
                        </label>

                        <button type="submit" class="qf-submit">
                            <span>Sign in</span>
                            <i class='bx bx-right-arrow-alt'></i>
                        </button>
                    </form>
                </div>

                <p class="qf-formpane__foot">Authorized personnel only · QuickFix Admin</p>
            </main>
        </div>
    </div>

    <style>
        :root {
            --qf-ink:    #0a0e13;
            --qf-ink-2:  #0e1319;
            --qf-amber:  #f59e0b;
            --qf-amber2: #f97316;
            --qf-text:   #e8edf2;
            --qf-muted:  #8b95a3;
            --qf-line:   rgba(255, 255, 255, .08);
        }

        html, body { background: #0a0e13; }

        .qf-login {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(120% 120% at 80% -10%, #16202b 0%, var(--qf-ink) 55%) ,
                var(--qf-ink);
            font-family: 'Manrope', system-ui, sans-serif;
            color: var(--qf-text);
        }

        /* ── Atmosphere ── */
        .qf-login__atmos { position: absolute; inset: 0; pointer-events: none; }
        .qf-orb { position: absolute; border-radius: 50%; filter: blur(70px); opacity: .5; }
        .qf-orb--1 {
            width: 460px; height: 460px; top: -120px; left: -80px;
            background: radial-gradient(circle, rgba(245, 158, 11, .55), transparent 70%);
            animation: qf-float 14s ease-in-out infinite;
        }
        .qf-orb--2 {
            width: 380px; height: 380px; bottom: -140px; left: 36%;
            background: radial-gradient(circle, rgba(249, 115, 22, .35), transparent 70%);
            animation: qf-float 18s ease-in-out infinite reverse;
        }
        .qf-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(var(--qf-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--qf-line) 1px, transparent 1px);
            background-size: 46px 46px;
            -webkit-mask-image: radial-gradient(120% 90% at 20% 10%, #000 0%, transparent 65%);
                    mask-image: radial-gradient(120% 90% at 20% 10%, #000 0%, transparent 65%);
            opacity: .5;
        }
        @keyframes qf-float {
            0%, 100% { transform: translate(0, 0); }
            50%      { transform: translate(26px, -22px); }
        }

        /* ── Shell ── */
        .qf-login__shell {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            min-height: 100vh;
            max-width: 1280px;
            margin: 0 auto;
        }

        /* ── Brand pane ── */
        .qf-brandpane {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3.2rem 3.4rem;
            border-right: 1px solid var(--qf-line);
        }
        .qf-lockup { display: inline-flex; align-items: center; gap: .7rem; text-decoration: none; }
        .qf-lockup__mark {
            width: 42px; height: 42px; border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, var(--qf-amber), var(--qf-amber2));
            color: #1b1207; font-size: 1.4rem;
            box-shadow: 0 8px 22px rgba(245, 158, 11, .4);
        }
        .qf-lockup__text { font-size: 1.25rem; letter-spacing: .5px; line-height: 1; color: #fff; }
        .qf-lockup__text strong { font-weight: 800; }
        .qf-lockup__text span { color: var(--qf-amber); font-weight: 800; }
        .qf-lockup__tag {
            margin-left: .35rem; font-size: .58rem; font-weight: 700; letter-spacing: .25em;
            color: var(--qf-amber); border: 1px solid rgba(245, 158, 11, .4);
            padding: .22rem .45rem; border-radius: 6px;
        }

        .qf-hero { max-width: 30rem; animation: qf-rise .8s .05s both; }
        .qf-hero__kicker {
            font-size: .72rem; font-weight: 700; letter-spacing: .28em; text-transform: uppercase;
            color: var(--qf-amber); margin: 0 0 1rem;
        }
        .qf-hero__title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800; font-size: clamp(2.6rem, 4.5vw, 4rem);
            line-height: .98; letter-spacing: -.02em; margin: 0 0 1.3rem; color: #fff;
        }
        .qf-hero__title span {
            background: linear-gradient(100deg, var(--qf-amber), var(--qf-amber2));
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
        }
        .qf-hero__sub { color: var(--qf-muted); font-size: 1.02rem; line-height: 1.6; margin: 0 0 2.2rem; }
        .qf-hero__list { list-style: none; margin: 0; padding: 0; display: grid; gap: .9rem; }
        .qf-hero__list li {
            display: flex; align-items: center; gap: .7rem;
            font-size: .94rem; font-weight: 500; color: #cdd5df;
        }
        .qf-hero__list i {
            font-size: 1.3rem; color: var(--qf-amber);
            background: rgba(245, 158, 11, .12); border-radius: 9px; padding: .35rem;
        }
        .qf-brandpane__foot { font-size: .76rem; color: #5b6675; margin: 0; }

        /* ── Form pane ── */
        .qf-formpane {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 1.4rem; padding: 2.5rem 2rem;
        }
        .qf-card {
            width: 100%; max-width: 25rem;
            background: rgba(20, 26, 34, .72);
            border: 1px solid var(--qf-line);
            border-radius: 22px;
            padding: 2.4rem 2.2rem;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 30px 70px -25px rgba(0, 0, 0, .8);
            animation: qf-rise .8s .12s both;
        }
        .qf-lockup--mobile { display: none; margin: 0 auto 1.5rem; }

        .qf-card__head { margin-bottom: 1.6rem; }
        .qf-card__head h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 700; font-size: 1.7rem; letter-spacing: -.01em; margin: 0 0 .35rem; color: #fff;
        }
        .qf-card__head p { color: var(--qf-muted); font-size: .9rem; margin: 0; }

        .qf-alert {
            display: flex; gap: .6rem; align-items: flex-start;
            background: rgba(239, 68, 68, .12); border: 1px solid rgba(239, 68, 68, .35);
            color: #fca5a5; border-radius: 12px; padding: .7rem .85rem; margin-bottom: 1.1rem; font-size: .82rem;
        }
        .qf-alert i { font-size: 1.1rem; flex: 0 0 auto; }
        .qf-alert div { display: flex; flex-direction: column; gap: .15rem; }
        .qf-alert--ok { background: rgba(16, 185, 129, .12); border-color: rgba(16, 185, 129, .35); color: #6ee7b7; }

        .qf-form { display: flex; flex-direction: column; gap: 1.15rem; }
        .qf-field { display: flex; flex-direction: column; gap: .45rem; }
        .qf-field__label { font-size: .78rem; font-weight: 600; color: #c2cbd6; letter-spacing: .01em; }
        .qf-field__row { display: flex; align-items: center; justify-content: space-between; }
        .qf-link { font-size: .76rem; font-weight: 600; color: var(--qf-amber); text-decoration: none; }
        .qf-link:hover { text-decoration: underline; }

        .qf-input {
            position: relative; display: flex; align-items: center;
            background: rgba(10, 14, 19, .6);
            border: 1px solid var(--qf-line); border-radius: 12px;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .qf-input:focus-within {
            border-color: var(--qf-amber);
            background: rgba(10, 14, 19, .85);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .15);
        }
        .qf-input__icon { font-size: 1.2rem; color: var(--qf-muted); padding: 0 .2rem 0 .85rem; }
        .qf-input:focus-within .qf-input__icon { color: var(--qf-amber); }
        .qf-input input {
            flex: 1 1 auto; width: 100%; border: 0; outline: none; box-shadow: none; background: transparent;
            color: var(--qf-text); font-size: .95rem; font-family: inherit;
            padding: .85rem .9rem .85rem .65rem;
        }
        /* Kill the framework's blue focus ring; the amber .qf-input:focus-within glow is the focus cue */
        .qf-input input:focus,
        .qf-input input:focus-visible { outline: none; box-shadow: none; border: 0; }
        .qf-input input::placeholder { color: #5b6675; }
        .qf-input input:-webkit-autofill {
            -webkit-text-fill-color: var(--qf-text);
            transition: background-color 9999s ease-in-out 0s;
        }
        .qf-input__toggle {
            border: 0; background: transparent; color: var(--qf-muted); cursor: pointer;
            font-size: 1.2rem; padding: 0 .85rem; display: grid; place-items: center;
        }
        .qf-input__toggle:hover { color: var(--qf-amber); }

        .qf-remember {
            display: flex; align-items: center; gap: .5rem;
            font-size: .82rem; color: var(--qf-muted); cursor: pointer; user-select: none;
        }
        .qf-remember input { width: 16px; height: 16px; accent-color: var(--qf-amber); cursor: pointer; }

        .qf-submit {
            position: relative; overflow: hidden;
            margin-top: .35rem;
            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; border: 0; cursor: pointer;
            padding: .95rem 1rem; border-radius: 12px;
            font-family: inherit; font-size: .98rem; font-weight: 700; color: #1b1207;
            background: linear-gradient(100deg, var(--qf-amber), var(--qf-amber2));
            box-shadow: 0 12px 30px -8px rgba(245, 158, 11, .55);
            transition: transform .15s ease, box-shadow .2s ease;
        }
        .qf-submit i { font-size: 1.3rem; transition: transform .2s ease; }
        .qf-submit:hover { transform: translateY(-2px); box-shadow: 0 18px 40px -10px rgba(245, 158, 11, .65); }
        .qf-submit:hover i { transform: translateX(4px); }
        .qf-submit:active { transform: translateY(0); }
        .qf-submit::before {
            content: ''; position: absolute; top: 0; left: -120%; width: 60%; height: 100%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .45), transparent);
            transform: skewX(-20deg); transition: left .6s ease;
        }
        .qf-submit:hover::before { left: 130%; }

        .qf-formpane__foot { font-size: .74rem; color: #4f5a68; letter-spacing: .04em; margin: 0; }

        @keyframes qf-rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 920px) {
            .qf-login__shell { grid-template-columns: 1fr; }
            .qf-brandpane { display: none; }
            .qf-lockup--mobile { display: inline-flex; }
            .qf-formpane { min-height: 100vh; }
        }
        @media (prefers-reduced-motion: reduce) {
            .qf-orb, .qf-hero, .qf-card { animation: none; }
            .qf-submit, .qf-submit i, .qf-submit::before { transition: none; }
        }
    </style>

    <script>
        (function () {
            const btn = document.getElementById('qfTogglePw');
            const input = document.getElementById('password');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('i').className = show ? 'bx bx-hide' : 'bx bx-show';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</x-guest-layout>
