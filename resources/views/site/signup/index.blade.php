@extends('site/layout/site-app')

@section('content')

<style>
.signup-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1) 0%, rgba(83, 52, 131, 0.1) 100%);
}

.signup-card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow-heavy);
    border: 1px solid var(--border-color);
    max-width: 600px;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.signup-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.signup-header {
    text-align: center;
    margin-bottom: 2rem;
}

.signup-header h2 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.signup-header p {
    color: var(--text-secondary);
    font-size: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-control {
    background: var(--primary-color);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
    width: 100%;
}

.form-control:focus {
    outline: none;
    border-color: #4a9eff;
    box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
    background: var(--primary-color);
}

.form-control::placeholder {
    color: var(--text-muted);
}

.password-field {
    position: relative;
}

.eye-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: var(--transition);
}

.eye-toggle:hover {
    color: var(--text-primary);
    background: rgba(255, 255, 255, 0.1);
}

.signup-actions {
    text-align: center;
    margin-bottom: 2rem;
}

.signup-actions a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    transition: var(--transition);
}

.signup-actions a:hover {
    color: #4a9eff;
}

.submit-btn {
    background: var(--gradient-accent);
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

.submit-btn:active {
    transform: translateY(0);
}

.social-signup {
    margin-top: 2rem;
    text-align: center;
}

.social-signup p {
    color: var(--text-muted);
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.social-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 12px;
    border: 2px solid var(--border-color);
    background: var(--card-bg);
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
}

.social-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    border-color: #4a9eff;
}

.social-btn.google:hover {
    border-color: #ea4335;
    color: #ea4335;
}

.social-btn.facebook:hover {
    border-color: #1877f2;
    color: #1877f2;
}

.social-btn.twitter:hover {
    border-color: #1da1f2;
    color: #1da1f2;
}

.error-message {
    background: rgba(220, 38, 38, 0.1);
    border: 1px solid rgba(220, 38, 38, 0.3);
    color: #dc2626;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.success-message {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #22c55e;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.terms-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.terms-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #4a9eff;
}

.terms-checkbox a {
    color: #4a9eff;
    text-decoration: none;
}

.terms-checkbox a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .signup-card {
        padding: 2rem;
        margin: 1rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .social-buttons {
        flex-wrap: wrap;
    }
}
</style>

<div class="main-container">
    <main class="site-main">
        <div class="signup-container">
            <div class="signup-card">
                <div class="signup-header">
                    <h2>🚀 {{__('lang.website_signup_title')}}</h2>
                    <p>Créez votre compte pour accéder à tout le contenu</p>
                </div>

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="user-signup" onsubmit="return validateAlphabeticName() && validateEmail() && validatePhoneNumber() && validate{{ __('lang.site_password') }}();" action="{{url('/do-user-signup')}}" method="POST">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{__('lang.website_name_placeholder')}}" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="{{__('lang.website_email_placeholder')}}" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="tel" class="form-control" placeholder="{{__('lang.website_phone_placeholder')}}" name="phone" id="phone" inputmode="numeric" maxlength="10" required>
                    </div>

                    <div class="form-group">
                        <div class="password-field">
                            <input type="password" class="form-control" placeholder="{{ __("lang.site_password") }}" name="password" id="password" required>
                            <button type="button" class="eye-toggle" onclick="toggle{{ __('lang.site_password') }}()">
                                <i class="fa fa-eye-slash" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            J'accepte les <a href="#" target="_blank">conditions d'utilisation</a> et la <a href="#" target="_blank">politique de confidentialité</a>
                        </label>
                    </div>

                    <div class="signup-actions">
                        <a href="{{url('/login')}}">{{__('lang.website_signin_title')}}</a>
                    </div>

                    <button type="submit" class="submit-btn">
                        {{__('lang.website_signup_button')}}
                    </button>
                </form>

                <div class="social-signup">
                    <p>Ou inscrivez-vous avec</p>
                    <div class="social-buttons">
                        <a href="#" class="social-btn google" title="Google">
                            <i class="fa fa-google"></i>
                        </a>
                        <a href="#" class="social-btn facebook" title="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="social-btn twitter" title="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function toggle{{ __('lang.site_password') }}() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.className = "fa fa-eye";
    } else {
        passwordInput.type = "password";
        eyeIcon.className = "fa fa-eye-slash";
    }
}

function validateAlphabeticName() {
    var name = document.getElementById('name').value;
    var nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(name)) {
        toastr.error("{{ __('lang.site_name_alphabetic_only') }}");
        return false;
    }
    return true;
}

function validateEmail() {
    var email = document.getElementById('email').value;
    var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        toastr.error("{{ __('lang.site_invalid_email_format') }}");
        return false;
    }
    return true;
}

function validatePhoneNumber() {
    var phone = document.getElementById('phone').value;
    var phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
        toastr.error("{{ __('lang.site_phone_10_digits') }}");
        return false;
    }
    return true;
}

function validate{{ __('lang.site_password') }}() {
    var password = document.getElementById('password').value;
    if (password.length < 6) {
        toastr.error("{{ __("lang.site_password_min_length") }}");
        return false;
    }
    return true;
}

// Add loading state to form submission
document.getElementById('user-signup').addEventListener('submit', function() {
    const submitBtn = this.querySelector('.submit-btn');
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ __("lang.site_registering") }}';
    submitBtn.disabled = true;
});
</script>
@endsection