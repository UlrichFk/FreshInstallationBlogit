@extends('site/layout/site-app')
@section('content')

<style>
.login-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1) 0%, rgba(83, 52, 131, 0.1) 100%);
}

.login-card {
    background: var(--card-bg);
    border-radius: var(--border-radius-lg);
    padding: 3rem;
    box-shadow: var(--shadow-heavy);
    border: 1px solid var(--border-color);
    max-width: 500px;
    width: 100%;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(20px);
}

.login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.login-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
    z-index: 2;
}

.login-header h2 {
    color: var(--text-primary);
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.login-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin: 0;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
}

.form-control {
    background: var(--secondary-color);
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 1.2rem 1.5rem;
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
    width: 100%;
    position: relative;
}

.form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
    background: var(--secondary-color);
    transform: translateY(-2px);
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
    z-index: 3;
}

.eye-toggle:hover {
    color: var(--text-primary);
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-50%) scale(1.1);
}

.login-btn {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border: none;
    border-radius: var(--border-radius-xl);
    padding: 1.2rem 2rem;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.login-btn::before {
    content: '🔐';
    font-size: 1.2rem;
}

.login-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-heavy);
}

.login-btn:active {
    transform: translateY(-1px);
}

.social-login {
    margin-top: 2rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.social-login p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
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
    border-radius: 50%;
    border: 2px solid var(--border-color);
    background: var(--secondary-color);
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
    font-size: 1.2rem;
}

.social-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: var(--shadow-medium);
    border-color: var(--accent-color);
}

.social-btn.google:hover {
    background: #db4437;
    color: white;
}

.social-btn.facebook:hover {
    background: #1877f2;
    color: white;
}

.social-btn.twitter:hover {
    background: #1da1f2;
    color: white;
}

.login-footer {
    margin-top: 2rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.login-footer a {
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.login-footer a:hover {
    color: var(--text-primary);
    text-decoration: underline;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
    border: 1px solid;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border-color: #dc3545;
    color: #dc3545;
}

.alert-success {
    background: rgba(40, 167, 69, 0.1);
    border-color: #28a745;
    color: #28a745;
}

.alert-info {
    background: rgba(23, 162, 184, 0.1);
    border-color: #17a2b8;
    color: #17a2b8;
}

/* Loading state */
.login-btn.loading {
    opacity: 0.7;
    pointer-events: none;
}

.login-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid var(--text-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        padding: 1rem;
    }

    .login-card {
        padding: 2rem;
        margin: 1rem;
    }

    .login-header h2 {
        font-size: 2rem;
    }

    .login-header p {
        font-size: 1rem;
    }

    .social-buttons {
        flex-wrap: wrap;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
}
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Sign in to your account to continue</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('login') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="{{ __('lang.site_email_address') }}" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <div class="password-field">
                    <input type="password" name="password" class="form-control" placeholder="{{ __('lang.site_password') }}" required id="password">
                    <button type="button" class="eye-toggle" onclick="toggle{{ __('lang.site_password') }}()">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label style="color: var(--text-secondary); font-size: 0.9rem;">
                    <input type="checkbox" name="remember" style="margin-right: 0.5rem;"> {{ __('lang.site_remember_me') }}
                </label>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                Sign In
            </button>
        </form>

        <div class="social-login">
            <p>Or continue with</p>
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

        <div class="login-footer">
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Don't have an account? 
                <a href="{{ url('signup') }}">Sign up here</a>
            </p>
            <a href="{{ url('forget-password') }}">Forgot your password?</a>
        </div>
    </div>
</div>

<script>
function toggle{{ __('lang.site_password') }}() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.className = 'fa fa-eye-slash';
    } else {
        passwordField.type = 'password';
        eyeIcon.className = 'fa fa-eye';
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.classList.add('loading');
    loginBtn.textContent = 'Signing In...';
});

// Add animation on page load
document.addEventListener('DOMContentLoaded', function() {
    const loginCard = document.querySelector('.login-card');
    loginCard.style.opacity = '0';
    loginCard.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
        loginCard.style.transition = 'all 0.6s ease-out';
        loginCard.style.opacity = '1';
        loginCard.style.transform = 'translateY(0)';
    }, 100);
});
</script>
@endsection