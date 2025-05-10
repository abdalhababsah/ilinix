<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="form-title">Welcome Back</h1>
    <p class="form-subtitle">Sign in to access your intern tracking dashboard</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
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

        <!-- Password -->
        <div class="form-group">
            <div class="justify-between">
                <label for="password" class="form-label">Password</label>
                @if (Route::has('password.request'))
                    <a class="form-link" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <input type="password" id="password" name="password" required 
                       class="form-input form-input-password" placeholder="Enter your password">
                <svg id="eye-icon" class="form-input-icon icon-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="togglePassword('password')">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-checkbox-container">
            <input type="checkbox" id="remember_me" name="remember" class="form-checkbox">
            <label for="remember_me" class="form-checkbox-label">Remember me</label>
        </div>

        <button type="submit" class="button">Sign In</button>
    </form>

    @if (Route::has('password.request'))
        <div class="forgot-password-btn-container">
            <a href="{{ route('password.request') }}" class="forgot-password-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="forgot-password-icon">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0110 0v4"></path>
                </svg>
                Forgot Password
            </a>
        </div>
    @endif

    <div class="form-footer">
        Don't have an account? <a href="{{ route('register') }}">Create account</a>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

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
                const password = document.getElementById('password');

                if (!email.value.trim()) {
                    showError(email, 'Email is required');
                    valid = false;
                } else if (!/^[^@]+@[^@]+\.[^@]+$/.test(email.value.trim())) {
                    showError(email, 'Enter a valid email');
                    valid = false;
                }

                if (password.value.length < 8) {
                    showError(password, 'Password must be at least 8 characters');
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <style>
        .forgot-password-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        
        .forgot-password-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            background-color: #F3F4F6;
            color: #4B5563;
            border: 1px solid #E5E7EB;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .forgot-password-btn:hover {
            background-color: #E5E7EB;
            color: #1F2937;
        }
        
        .forgot-password-icon {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }
    </style>
</x-guest-layout>