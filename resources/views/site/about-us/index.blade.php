@extends('site/layout/site-app')

@section('title', __("lang.about_about_fri_verden_media") . " - " . setting('site_name'))

@section('content')
<style>
/* Page Wrapper */
.about-page {
    background: var(--primary-color);
}

/* Hero */
.about-hero {
    background: var(--gradient-hero);
    min-height: 60vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    margin-top: 100px;
}
.about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="aboutPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23aboutPattern)"/></svg>');
    opacity: 0.25;
}
.about-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}
.about-hero h1 {
    font-size: 3.5rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
}
.about-hero .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.about-hero p {
    font-size: 1.15rem;
    color: var(--text-secondary);
    line-height: 1.8;
    margin: 0 auto var(--space-8);
}
.hero-badges {
    display: flex;
    justify-content: center;
    gap: var(--space-3);
    flex-wrap: wrap;
}
.hero-badge {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    color: var(--text-primary);
    padding: .5rem 1rem;
    border-radius: 999px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
}
.hero-badge i { color: #ffd700; }

/* Story Timeline */
.story-section { padding: var(--space-20) 0; }
.story-wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}
.section-title {
    text-align: center;
    font-size: 2.25rem;
    font-weight: 900;
    color: var(--text-primary);
    font-family: var(--font-display);
    margin-bottom: var(--space-8);
}
.timeline {
    position: relative;
    padding-left: 2rem;
}
.timeline::before {
    content: '';
    position: absolute;
    left: .5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
    opacity: .5;
}
.milestone {
    position: relative;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    margin-bottom: var(--space-5);
    box-shadow: var(--shadow-md);
}
.milestone::before {
    content: '';
    position: absolute;
    left: -1.05rem;
    top: 1.25rem;
    width: 14px; height: 14px;
    background: var(--accent-color);
    border-radius: 999px;
    box-shadow: 0 0 0 4px rgba(52,152,219,.2);
}
.milestone h4 { color: var(--text-primary); margin-bottom: .25rem; }
.milestone .meta { color: var(--text-muted); font-size: .9rem; margin-bottom: .75rem; }
.milestone p { color: var(--text-secondary); margin: 0; }

/* Founder Spotlight */
.founder-spotlight { padding: var(--space-20) 0; background: var(--secondary-color); }
.founder-grid { max-width: 1100px; margin: 0 auto; padding: 0 var(--space-4); display: grid; grid-template-columns: 1.1fr .9fr; gap: var(--space-10); align-items: center; }
.founder-text h3 { color: var(--text-primary); font-family: var(--font-display); font-weight: 900; font-size: 2rem; margin-bottom: .75rem; }
.founder-text h4 { color: var(--accent-color); font-weight: 800; margin-bottom: var(--space-3); }
.founder-text p { color: var(--text-secondary); line-height: 1.8; margin-bottom: var(--space-3); }
.founder-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-2xl); overflow: hidden; box-shadow: var(--shadow-xl); }
.founder-photo { width: 100%; height: 100%; object-fit: cover; display: block; }
.founder-meta { padding: var(--space-5); border-top: 1px solid var(--border-color); }
.founder-meta small { color: var(--text-muted); }

/* Values Grid */
.values-section { padding: var(--space-20) 0; background: var(--secondary-color); }
.values-grid {
    max-width: 1100px; margin: 0 auto; padding: 0 var(--space-4);
    display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);
}
.value-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    text-align: left;
    transition: var(--transition-normal);
}
.value-card:hover { transform: translateY(-4px); border-color: var(--accent-color); box-shadow: var(--shadow-lg); }
.value-card i { font-size: 2rem; color: var(--accent-color); margin-bottom: .75rem; }
.value-card h5 { color: var(--text-primary); font-weight: 800; margin-bottom: .5rem; }
.value-card p { color: var(--text-secondary); margin: 0; }

/* Impact Stats */
.impact-section { padding: var(--space-16) 0; }
.impact-grid { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6); padding: 0 var(--space-4); }
.impact-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: var(--space-6); text-align: center; box-shadow: var(--shadow-sm); }
.impact-number { font-size: 2rem; font-weight: 900; color: var(--accent-color); font-family: var(--font-display); }
.impact-label { color: var(--text-secondary); font-weight: 600; }

/* CTA Banner */
.cta-section { padding: var(--space-20) 0; }
.cta-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-6); padding: 0 var(--space-4); }
.cta-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-2xl); padding: var(--space-8); box-shadow: var(--shadow-xl); position: relative; overflow: hidden; }
.cta-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(52,152,219,0.08), rgba(44,128,182,0.08)); pointer-events: none; }
.cta-card h4 { color: var(--text-primary); font-weight: 900; font-family: var(--font-display); margin-bottom: .5rem; }
.cta-card p { color: var(--text-secondary); margin-bottom: var(--space-4); }
.cta-actions { display: flex; gap: var(--space-3); flex-wrap: wrap; }
.btn-pill { border-radius: 999px; padding: .75rem 1.25rem; font-weight: 700; border: 1px solid var(--border-color); color: var(--text-secondary); background: transparent; text-decoration: none; }
.btn-pill.primary { background: var(--gradient-accent); color: var(--text-primary); border: none; }
.btn-pill:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

/* Responsive */
@media (max-width: 992px){ .founder-grid{ grid-template-columns: 1fr; } }
@media (max-width: 768px){ .about-hero h1{ font-size: 2.25rem; } }
</style>

<div class="about-page">
    <!-- Hero -->
    <section class="about-hero">
        <div class="about-hero-content">
            <div class="hero-badges">
                <span class="hero-badge"><i class="ti ti-shield-check"></i> {{ __("lang.about_independence") }}</span>
                <span class="hero-badge"><i class="ti ti-users"></i> {{ __("lang.about_community") }}</span>
                <span class="hero-badge"><i class="ti ti-world"></i> {{ __("lang.about_openness") }}</span>
            </div>
            <h1>{{ __("lang.about_about_fri_verden_media") }}</h1>
            <p>{{ __("lang.about_mission_description") }}</p>
        </div>
    </section>

    <!-- Story / Timeline -->
    <section class="story-section">
        <div class="story-wrapper">
            <h2 class="section-title">{{ __("lang.site_our_history") }}</h2>
            <div class="timeline">
                <div class="milestone">
                    <h4>{{ __("lang.about_beginnings") }}</h4>
                    <div class="meta">{{ __("lang.about_beginnings_period") }}</div>
                    <p>{{ __("lang.about_beginnings_description") }}</p>
                </div>
                <div class="milestone">
                    <h4>{{ __("lang.about_asserting_independence") }}</h4>
                    <div class="meta">{{ __("lang.about_asserting_period") }}</div>
                    <p>{{ __("lang.about_asserting_description") }}</p>
                </div>
                <div class="milestone">
                    <h4>{{ __("lang.about_accelerating_impact") }}</h4>
                    <div class="meta">{{ __("lang.about_accelerating_period") }}</div>
                    <p>{{ __("lang.about_accelerating_description") }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Spotlight -->
    <section class="founder-spotlight">
        <div class="founder-grid">
            <div class="founder-text">
                <h3>{{ __("lang.site_the_founder") }}</h3>
                <h4>{{ __("lang.about_founder_name") }}</h4>
                <p>{{ __("lang.about_founder_description_1") }}</p>
                <p>{{ __("lang.about_founder_description_2") }}</p>
                <p>{{ __("lang.about_founder_description_3") }}</p>
            </div>
            <div class="founder-card">
                <img src="https://friverdenmedia.com/wp-content/uploads/2022/12/Michel-Biem-250x333.jpeg" alt="{{ __("lang.about_founder_name") }} - {{ __("lang.site_the_founder") }} {{ setting('site_name') }}" class="founder-photo">
                <div class="founder-meta">
                    <small>{{ __("lang.about_founder_photo_copyright") }}</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="values-section">
        <div class="values-grid">
            <div class="value-card">
                <i class="ti ti-shield-check"></i>
                <h5>{{ __("lang.about_independence_title") }}</h5>
                <p>{{ __("lang.about_independence_description") }}</p>
            </div>
            <div class="value-card">
                <i class="ti ti-heart-handshake"></i>
                <h5>{{ __("lang.about_humanity_title") }}</h5>
                <p>{{ __("lang.about_humanity_description") }}</p>
            </div>
            <div class="value-card">
                <i class="ti ti-world"></i>
                <h5>{{ __("lang.about_openness_title") }}</h5>
                <p>{{ __("lang.about_openness_description") }}</p>
            </div>
        </div>
    </section>

    <!-- Impact -->
    <section class="impact-section">
        <div class="impact-grid">
            <div class="impact-card">
                <div class="impact-number">500+</div>
                <div class="impact-label">{{ __("lang.about_articles_published") }}</div>
            </div>
            <div class="impact-card">
                <div class="impact-number">50+</div>
                <div class="impact-label">{{ __("lang.about_countries_covered") }}</div>
            </div>
            <div class="impact-card">
                <div class="impact-number">10K+</div>
                <div class="impact-label">{{ __("lang.about_monthly_readers") }}</div>
            </div>
            <div class="impact-card">
                <div class="impact-number">24/7</div>
                <div class="impact-label">{{ __("lang.about_editorial_watch") }}</div>
            </div>
        </div>
    </section>

    <!-- CTAs -->
    <section class="cta-section">
        <div class="cta-grid">
            <div class="cta-card">
                <h4>{{ __("lang.about_become_member") }}</h4>
                <p>{{ __("lang.about_become_member_description") }}</p>
                <div class="cta-actions">
                    <a href="{{ url('membership/plans') }}" class="btn-pill primary"><i class="ti ti-star"></i> {{ __("lang.about_view_plans") }}</a>
                    <a href="{{ url('/about-us') }}#mission" class="btn-pill">{{ __("lang.about_learn_more") }}</a>
                </div>
            </div>
            <div class="cta-card">
                <h4>{{ __("lang.about_make_donation") }}</h4>
                <p>{{ __("lang.about_donation_description") }}</p>
                <div class="cta-actions">
                    <a href="{{ route('donation.form') }}" class="btn-pill primary"><i class="ti ti-heart"></i> {{ __("lang.about_i_donate") }}</a>
                    <a href="{{ url('/donation') }}#faq" class="btn-pill">{{ __("lang.about_why_donate") }}</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
