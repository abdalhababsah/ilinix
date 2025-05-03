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

        <!-- Email Address -->
        <div class="form-group">
            <label for="email_username" class="form-label">Email Username</label>
            <div class="form-flex">
                <div class="form-input-container" style="position: relative; width: 80%;">
                    <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <input type="text" id="email_username" name="email_username" value="{{ old('email_username') }}" required autofocus
                           class="form-input-prefix" placeholder="username">
                </div>
                <div style="width: 20%;">
                    <span class="form-input-suffix">@ilinix.me</span>
                </div>
            </div>
            <input type="hidden" name="email" id="email">
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

    <div class="form-footer">
        Don't have an account? <a href="{{ route('register') }}">Create account</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle the email username field
            function updateEmail() {
                const usernameField = document.getElementById('email_username');
                const emailField = document.getElementById('email');
                
                if (usernameField.value) {
                    emailField.value = usernameField.value + '@ilinix.me';
                } else {
                    emailField.value = '';
                }
            }
            
            // Update email field on input change
            document.getElementById('email_username').addEventListener('input', updateEmail);
            
            // Update email field before form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                updateEmail();
            });
        });
        
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
    </script>
</x-guest-layout>