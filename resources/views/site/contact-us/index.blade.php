@extends('site/layout/site-app')

@section('content')

<style>
.contact-container {
    padding: 4rem 0;
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.05) 0%, rgba(83, 52, 131, 0.05) 100%);
}

.contact-header {
    text-align: center;
    margin-bottom: 4rem;
}

.contact-header h1 {
    color: var(--text-primary);
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.contact-header p {
    color: var(--text-secondary);
    font-size: 1.2rem;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.contact-info-section {
    background: var(--card-bg);
    border-radius: var(--border-radius-lg);
    padding: 3rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.contact-info-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.contact-info-section h3 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
}

.contact-info-section p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.contact-methods {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--secondary-color);
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.contact-method::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: var(--transition);
}

.contact-method:hover::before {
    left: 100%;
}

.contact-method:hover {
    transform: translateX(8px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-medium);
}

.contact-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: var(--gradient-accent);
    border-radius: var(--border-radius);
    flex-shrink: 0;
    transition: var(--transition);
    position: relative;
    z-index: 2;
}

.contact-icon i {
    color: var(--text-primary);
    font-size: 1.5rem;
}

.contact-method:hover .contact-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: var(--shadow-medium);
}

.contact-details h4 {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 2;
}

.contact-details p {
    color: var(--text-secondary);
    margin: 0;
    position: relative;
    z-index: 2;
}

.contact-form-section {
    background: var(--card-bg);
    border-radius: var(--border-radius-lg);
    padding: 3rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.contact-form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.contact-form-section h3 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
}

.form-group label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 1rem 1.5rem;
    background: var(--secondary-color);
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: var(--text-muted);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.submit-btn {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border: none;
    padding: 1.2rem 2.5rem;
    border-radius: var(--border-radius-xl);
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.submit-btn::before {
    content: '📧';
    font-size: 1.2rem;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-heavy);
}

.submit-btn:active {
    transform: translateY(-1px);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
    border: 1px solid;
}

.alert-success {
    background: rgba(40, 167, 69, 0.1);
    border-color: #28a745;
    color: #28a745;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border-color: #dc3545;
    color: #dc3545;
}

/* Loading state */
.submit-btn.loading {
    opacity: 0.7;
    pointer-events: none;
}

.submit-btn.loading::after {
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
@media (max-width: 992px) {
    .contact-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .contact-container {
        padding: 2rem 0;
    }

    .contact-header h1 {
        font-size: 2.5rem;
    }

    .contact-header p {
        font-size: 1rem;
    }

    .contact-info-section,
    .contact-form-section {
        padding: 2rem;
    }

    .contact-info-section h3,
    .contact-form-section h3 {
        font-size: 1.5rem;
    }

    .contact-method {
        padding: 1rem;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
    }

    .contact-icon i {
        font-size: 1.2rem;
    }
}
</style>

<div class="contact-container">
    <div class="contact-header">
        <h1>Get in Touch</h1>
        <p>{{ __("lang.site_contact_us_description") }}</p>
    </div>

    <div class="contact-content">
        <div class="contact-info-section">
            <h3>Contact Information</h3>
            <p>Feel free to reach out to us through any of the following channels. We're here to help!</p>

            <div class="contact-methods">
                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email</h4>
                        <p>{{ setting('contact_email') ?? 'contact@example.com' }}</p>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Phone</h4>
                        <p>{{ setting('contact_phone') ?? '+1 (555) 123-4567' }}</p>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Address</h4>
                        <p>{{ setting('contact_address') ?? '123 Main Street, City, Country' }}</p>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Business Hours</h4>
                        <p>{{ setting('business_hours') ?? 'Monday - Friday: 9:00 AM - 6:00 PM' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-form-section">
            <h3>{{ __("lang.site_send_us_message") }}</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('contact') }}" id="contactForm">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('lang.site_full_name') }} *</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="{{ __("lang.site_enter_full_name") }}" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">{{ __('lang.site_email_address') }} *</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="{{ __("lang.site_enter_email_address") }}" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="subject">{{ __('lang.site_subject') }} *</label>
                    <input type="text" id="subject" name="subject" class="form-control" placeholder="{{ __("lang.site_enter_message_subject") }}" required value="{{ old('subject') }}">
                </div>

                <div class="form-group">
                    <label for="message">{{ __("lang.site_message") }} *</label>
                    <textarea id="message" name="message" class="form-control" placeholder="{{ __("lang.site_enter_message_here") }}" required rows="5">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    {{ __("lang.site_send_message") }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.textContent = 'Sending...';
});

// Add animation on page load
document.addEventListener('DOMContentLoaded', function() {
    const contactMethods = document.querySelectorAll('.contact-method');
    const formGroups = document.querySelectorAll('.form-group');
    
    contactMethods.forEach((method, index) => {
        method.style.opacity = '0';
        method.style.transform = 'translateX(-30px)';
        
        setTimeout(() => {
            method.style.transition = 'all 0.6s ease-out';
            method.style.opacity = '1';
            method.style.transform = 'translateX(0)';
        }, index * 200);
    });
    
    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            group.style.transition = 'all 0.6s ease-out';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, (index + 3) * 200);
    });
});
</script>
@endsection