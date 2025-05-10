<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="form-title">Forgot Password</h1>
    <p class="form-subtitle">Reset your password in two simple steps</p>

    <div class="form-message">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="username@ilinix.me">
            </div>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="button">Email Password Reset Link</button>
    </form>

    <div class="form-footer">
        Remember your password? <a href="{{ route('login') }}">Back to login</a>
    </div>

    <script>
        // Front-end form validation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');

            form.addEventListener('submit', function (e) {
                let valid = true;

                // Clear previous errors
                form.querySelectorAll('.form-error').forEach(el => el.remove());

                // Show error
                const showError = (input, message) => {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('form-error');
                    errorEl.textContent = message;
                    input.parentNode.appendChild(errorEl);
                };

                const email = document.getElementById('email');

                if (!email.value.trim()) {
                    showError(email, 'Email is required');
                    valid = false;
                } else if (!/^[^@]+@[^@]+\.[^@]+$/.test(email.value.trim())) {
                    showError(email, 'Enter a valid email');
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <style>
        .form-message {
            margin-bottom: 20px;
            text-align: center;
            line-height: 1.5;
            color: #6B7280;
        }
    </style>
</x-guest-layout>