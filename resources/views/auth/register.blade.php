<x-guest-layout>
    <h1 class="form-title">Create Account</h1>
    <p class="form-subtitle">Join the Ilinix intern management platform</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="first_name" class="form-label">First Name</label>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <input type="text" id="first_name" name="first_name" value="{{ old('name') }}" required autofocus
                       class="form-input" placeholder="Full Name">
            </div>
            @error('first_name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="last_name" class="form-label">Last Name</label>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <input type="text" id="last_name" name="last_name" value="{{ old('name') }}" required autofocus
                       class="form-input" placeholder="Full Name">
            </div>
            @error('last_name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email_username" class="form-label">Email Username</label>
            <div class="form-flex">
                <div class="form-input-container" style="position: relative; width: 80%;">
                    <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <input type="text" id="email_username" name="email_username" value="{{ old('email_username') }}" required
                           class="form-input-prefix" placeholder="username">
                </div>
                <div style="width: 20%;">
                    <span class="form-input-suffix">@ilinix.me</span>
                </div>
            </div>
            <div class="form-helper">Enter only your username, @ilinix.me will be added automatically</div>
            <input type="hidden" name="email" id="email">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <input type="password" id="password" name="password" required 
                       class="form-input form-input-password" placeholder="Create a secure password">
                <svg id="password-eye" class="form-input-icon icon-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="togglePassword('password')">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <div class="form-helper">Password must be at least 8 characters</div>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="form-input-container">
                <svg class="form-input-icon icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       class="form-input form-input-password" placeholder="Confirm your password">
                <svg id="confirm-eye" class="form-input-icon icon-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="togglePassword('password_confirmation')">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Terms Agreement -->
        <div class="form-group">
            <div style="display: flex; align-items: flex-start; margin-bottom: 1.5rem;">
                <input type="checkbox" id="terms" name="terms" required class="form-checkbox" style="margin-top: 0.25rem;">
                <div style="margin-left: 0.75rem;">
                    <label for="terms" class="form-label" style="margin-bottom: 0.25rem;">I agree to the <a href="#" style="color: var(--primary);">Terms and Conditions</a></label>
                    <p class="form-helper" style="margin-top: 0;">I accept Ilinix's intern tracking platform policies</p>
                </div>
            </div>
        </div>
        
        <button type="submit" class="button">Create Account</button>
        
        <div class="form-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in instead</a>
        </div>
    </form>

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
            const eyeIcon = document.getElementById(fieldId + '-eye') || document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                if (eyeIcon) {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                }
            } else {
                passwordInput.type = 'password';
                if (eyeIcon) {
                    eyeIcon.innerHTML = '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
        const emailUsernameField = document.getElementById('email_username');
        const emailField = document.getElementById('email');
        const passwordToggles = document.querySelectorAll('[data-toggle-password]');

        function updateEmail() {
            emailField.value = emailUsernameField.value
                ? emailUsernameField.value + '@ilinix.me'
                : '';
        }

        // Attach listener to update email in real-time
        if (emailUsernameField && emailField) {
            emailUsernameField.addEventListener('input', updateEmail);

            // Ensure value is updated before submission
            document.querySelector('form').addEventListener('submit', updateEmail);
        }

        // Password visibility toggles
        passwordToggles.forEach(icon => {
            icon.addEventListener('click', function () {
                const inputId = this.getAttribute('data-toggle-password');
                const input = document.getElementById(inputId);

                if (input) {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    this.innerHTML = isPassword
                        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`
                        : `<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
                }
            });
        });
    });
    </script>
</x-guest-layout>