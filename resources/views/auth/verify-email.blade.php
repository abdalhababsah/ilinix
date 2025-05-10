<x-guest-layout>
    <!-- Session Status -->
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <h1 class="form-title">Verify Email</h1>
    <p class="form-subtitle">One more step to complete your registration</p>

    <div class="form-message">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="button">Resend Verification Email</button>
    </form>

    <div class="form-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-link">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <style>
        .form-message {
            margin-bottom: 20px;
            text-align: center;
            line-height: 1.5;
            color: #6B7280;
        }
        
        .text-link {
            background: none;
            border: none;
            padding: 0;
            color: #2563EB;
            text-decoration: underline;
            cursor: pointer;
            font-size: 14px;
        }
        
        .text-link:hover {
            color: #1E40AF;
        }
    </style>
</x-guest-layout>