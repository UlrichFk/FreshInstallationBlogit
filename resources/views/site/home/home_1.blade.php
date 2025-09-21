@extends('site/layout/site-app')
@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title fade-in">
                    <span class="highlight">{{ __("lang.site_hero_title_highlight") }}</span>
                    {{ __("lang.site_hero_title_rest") }}
                </h1>
                                    <p class="hero-description slide-in-left">
                        {{ __("lang.site_hero_description") }}
                    </p>
                <div class="hero-actions slide-in-left">
                    <a href="{{url('donation')}}" class="btn btn-donate">
                        <i class="fas fa-heart"></i>
                        {{ __("lang.site_support") }}
                    </a>
                    <a href="{{url('membership/plans')}}" class="btn btn-premium">
                        <i class="fas fa-crown"></i>
                        {{ __("lang.site_premium") }}
                    </a>
                </div>
                <div class="hero-stats slide-in-left">
                    <div class="stat-item">
                        <span class="stat-number">{{ \App\Models\Blog::where('status', 1)->count() }}+</span>
                        <span class="stat-label">{{ __("lang.site_published_articles") }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ \App\Models\User::count() }}+</span>
                        <span class="stat-label">{{ __("lang.site_active_readers") }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ \App\Models\Category::count() }}+</span>
                        <span class="stat-label">{{ __("lang.site_categories_label") }}</span>
                    </div>
                </div>
            </div>
            <div class="hero-image slide-in-right">
                <!-- Hero Slider -->
                <div class="hero-slider">
                    <!-- Main Hero Card -->
                    <div class="hero-slide active" data-slide="0">
                        <div class="hero-card">
                            <img src="{{ asset('site-assets/images/democracy-hero.jpg') }}" alt="Democracy and Human Rights" onerror="this.style.display='none'">
                            <div class="hero-card-overlay">
                                <!-- Top Section with Category Badge -->
                                <div class="hero-overlay-header">
                                    <div class="article-category-badge">
                                        <i class="fas fa-globe"></i>
                                        <span>{{ __("lang.site_global_coverage") }}</span>
                                    </div>
                                    <div class="hero-premium-badge">
                                        <i class="fas fa-star"></i>
                                        <span>{{ __("lang.site_exclusive") }}</span>
                                    </div>
                                </div>

                                <!-- Main Content Section -->
                                <div class="hero-overlay-content">
                                    <div class="hero-article-title">
                                        <h3>{{ __("lang.site_hero_article_title") }}</h3>
                                    </div>
                                    
                                    <div class="hero-article-excerpt">
                                        <p>{{ __("lang.site_hero_article_excerpt") }}</p>
                                    </div>

                                    <!-- Article Stats -->
                                    <div class="hero-article-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-globe-americas"></i>
                                            <span>{{ __("lang.site_50_plus_countries") }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-newspaper"></i>
                                            <span>{{ __("lang.site_500_plus_articles") }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-users"></i>
                                            <span>{{ __("lang.site_10k_plus_readers") }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Section with Meta and CTA -->
                                <div class="hero-overlay-footer">
                                    <div class="hero-article-meta">
                                        <div class="meta-author">
                                            <div class="author-avatar">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="author-info">
                                                <span class="author-name">Fri Verden Media</span>
                                                <span class="publish-date">{{ __("lang.site_independent_journalism") }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ url('all-blogs') }}" class="all-blogs hero-read-more">
                                        <span>{{ __("lang.site_all_blogs") }}</span>
                                        <div class="read-more-icon">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Articles Slides -->
                    @php 
                        $latest_hero_articles = \App\Models\Blog::where('status', 1)
                            ->with('blog_category')
                            ->orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();
                    @endphp

                    @foreach($latest_hero_articles as $index => $article)
                        <div class="hero-slide" data-slide="{{ $index + 1 }}">
                            <div class="hero-card">
                                <img src="{{ url('uploads/blog/'.($article->image ?? 'default.jpg')) }}" 
                                     alt="{{ $article->title }}" 
                                     onerror="this.src='{{ asset('uploads/image_preview.jpg') }}'">
                                <div class="hero-card-overlay">
                                    <!-- Top Section with Category and Premium Badge -->
                                    <div class="hero-overlay-header">
                                        <div class="article-category-badge">
                                            @if($article->blog_category && count($article->blog_category) > 0)
                                                <i class="fas fa-tag"></i>
                                                <span>{{ $article->blog_category[0]->category->name }}</span>
                                            @else
                                                <i class="fas fa-newspaper"></i>
                                                <span>{{ __("lang.site_news") }}</span>
                                            @endif
                                        </div>
                                        @if($article->is_premium)
                                            <div class="hero-premium-badge">
                                                <i class="fas fa-crown"></i>
                                                <span>{{ __("lang.site_premium") }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Main Content Section -->
                                    <div class="hero-overlay-content">
                                        <div class="hero-article-title">
                                            <h3>{{ Str::limit($article->title, 50) }}</h3>
                                        </div>
                                        
                                        <div class="hero-article-excerpt">
                                            <p>{{ Str::limit(strip_tags($article->description), 100) }}</p>
                                        </div>

                                        <!-- Article Stats -->
                                        <div class="hero-article-stats">
                                            <div class="stat-item">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ ceil(str_word_count(strip_tags($article->description)) / 200) }} {{ __("lang.site_minutes") }}</span>
                                            </div>
                                            <div class="stat-item">
                                                <i class="fas fa-eye"></i>
                                                <span>{{ rand(100, 2000) }} {{ __("lang.site_views") }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Section with Meta and CTA -->
                                    <div class="hero-overlay-footer">
                                        <div class="hero-article-meta">
                                            <div class="meta-author">
                                                <div class="author-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="author-info">
                                                    <span class="author-name">{{ $article->author_name ?: 'Fri Verden Media' }}</span>
                                                    <span class="publish-date">{{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ url('blog/'.$article->slug) }}" class="hero-read-more">
                                            <span>{{ __("lang.site_read_article") }}</span>
                                            <div class="read-more-icon">
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <!-- Slider Navigation -->
                    <div class="hero-slider-nav">
                        <button class="slider-nav-btn prev" onclick="changeSlide(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="slider-dots">
                            <span class="dot active" onclick="currentSlide(0)"></span>
                            @for($i = 1; $i <= count($latest_hero_articles); $i++)
                                <span class="dot" onclick="currentSlide({{ $i }})"></span>
                            @endfor
                        </div>
                        <button class="slider-nav-btn next" onclick="changeSlide(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Auto-play indicator -->
                    <div class="slider-autoplay">
                        <div class="autoplay-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breaking News Banner Section -->
<section class="breaking-news-section">
    <div class="container">
        <div class="breaking-news-banner">
            <div class="breaking-news-content">
                <div class="breaking-label">
                    <i class="fas fa-bolt"></i>
                    <span>{{ __("lang.site_breaking_news") }}</span>
                </div>
                
                <div class="breaking-news-ticker">
                    <div class="ticker-wrapper">
                        @php 
                            $breaking_news = \App\Models\Blog::where('status', 1)
                                ->where('is_featured', 1)
                                ->with('blog_category')
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();
                            
                            if($breaking_news->isEmpty()) {
                                $breaking_news = \App\Models\Blog::where('status', 1)
                                    ->with('blog_category')
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
                            }
                        @endphp
                        
                        <div class="ticker-content">
                            @if(isset($breaking_news) && count($breaking_news))
                                @foreach($breaking_news as $index => $news)
                                    <div class="ticker-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="news-meta">
                                            @if($news->blog_category && count($news->blog_category) > 0)
                                                <span class="news-category">{{$news->blog_category[0]->category->name}}:</span>
                                            @endif
                                            <span class="news-date">{{\Carbon\Carbon::parse($news->created_at)->format('d M Y')}}</span>
                                        </div>
                                        <a href="{{url('blog/'.$news->slug)}}" class="news-link">
                                            {{$news->title}}
                                        </a>
                                        @if($news->is_premium)
                                            <span class="premium-indicator">
                                                <i class="fas fa-crown"></i>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="ticker-item active">
                                    <div class="news-meta">
                                        <span class="news-category">{{ __("lang.site_news") }}:</span>
                                        <span class="news-date">{{ date('d M Y') }}</span>
                                    </div>
                                                                            <span class="news-link">
                                        {{ __("lang.site_breaking_news_fallback") }}
                                        </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="breaking-news-controls">
                    <button class="ticker-control prev" onclick="previousNews()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="ticker-control next" onclick="nextNews()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="ticker-control pause" onclick="toggleAutoplay()">
                        <i class="fas fa-pause"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top News Section -->
<section class="top-news-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                <i class="fas fa-star"></i>
                {{ __("lang.site_today_headlines") }}
            </h2>
            <p class="section-subtitle">{{ __("lang.site_events_shaping_world") }}</p>
        </div>

        <div class="top-news-grid">
            @php 
                $featured_blogs = \App\Models\Blog::where('status', 1)
                    ->where('is_featured', 1)
                    ->with('blog_category')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @if(isset($featured_blogs) && count($featured_blogs))
                @foreach($featured_blogs as $index => $blog)
                    <article class="news-card {{ $index == 0 ? 'featured' : '' }} fade-in">
                        <div class="news-image">
                            <img src="{{ url('uploads/blog/'.($blog->image ?? 'default.jpg')) }}" 
                                 alt="{{$blog->title}}" 
                                 onerror="this.src='{{ asset('uploads/image_preview.jpg') }}'">
                            
                            @if($blog->is_premium)
                                <div class="premium-badge">
                                    <i class="fas fa-crown"></i>
                                    {{ __("lang.site_premium") }}
                                </div>
                            @endif
                            
                            <div class="news-overlay">
                                <div class="news-category">
                                    @if($blog->blog_category && count($blog->blog_category) > 0)
                                        <a href="{{url('category/'.$blog->blog_category[0]->category->slug)}}">
                                            {{$blog->blog_category[0]->category->name}}
                                        </a>
                                    @else
                                        <span>{{ __("lang.site_uncategorized") }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="news-content">
                            <h3 class="news-title">
                                <a href="{{url('blog/'.$blog->slug)}}">{{$blog->title}}</a>
                            </h3>
                            
                            @if($index == 0)
                                <p class="news-excerpt">{{Str::limit(strip_tags($blog->description), 120)}}</p>
                            @endif
                            
                            <div class="news-meta">
                                <span class="news-author">
                                    <i class="fas fa-user"></i>
                                    {{$blog->author_name ?: 'Fri Verden Media'}}
                                </span>
                                <span class="news-date">
                                    <i class="fas fa-calendar"></i>
                                    {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}}
                                </span>
                                <span class="news-reading-time">
                                    <i class="fas fa-clock"></i>
                                    {{ceil(str_word_count(strip_tags($blog->description)) / 200)}} {{ __("lang.site_minutes") }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
        
        <div class="text-center mt-8">
            <a href="{{url('all-blogs')}}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                {{ __("lang.site_view_all_news") }}
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                <i class="fas fa-th-large"></i>
                {{ __("lang.site_explore_by_category") }}
            </h2>
            <p class="section-subtitle">{{ __("lang.site_find_topics_interest") }}</p>
        </div>

        <div class="categories-grid">
            @php 
                $categories = \App\Models\Category::where('status', 1)
                    ->take(8)
                    ->get();
                
                // Ajouter le nombre de blogs pour chaque catégorie
                foreach($categories as $category) {
                    $category->blogs_count = \App\Models\BlogCategory::where('category_id', $category->id)->count();
                }
                
                // Trier par nombre de blogs (décroissant)
                $categories = $categories->sortByDesc('blogs_count');
                
                $categoryIcons = [
                    'management' => 'fas fa-briefcase',
                    'loi' => 'fas fa-balance-scale',
                    'humanitaires' => 'fas fa-hands-helping',
                    'sécurité' => 'fas fa-shield-alt',
                    'travail' => 'fas fa-hammer',
                    'politique' => 'fas fa-landmark',
                    'économie' => 'fas fa-chart-line',
                    'société' => 'fas fa-users',
                ];
            @endphp

            @if(isset($categories) && count($categories))
                @foreach($categories as $category)
                    <div class="category-card fade-in">
                        <a href="{{url('category/'.$category->slug)}}" class="category-link">
                            <div class="category-icon">
                                @php
                                    $icon = 'fas fa-folder';
                                    foreach($categoryIcons as $keyword => $categoryIcon) {
                                        if(stripos($category->name, $keyword) !== false) {
                                            $icon = $categoryIcon;
                                            break;
                                        }
                                    }
                                @endphp
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-name">{{$category->name}}</h3>
                                <p class="category-count">{{$category->blogs_count}} {{ __("lang.site_articles") }}</p>
                            </div>
                            <div class="category-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Latest Articles Section -->
<section class="latest-articles-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-newspaper"></i>
                {{ __("lang.site_latest_articles") }}
            </h2>
            <a href="{{url('all-blogs')}}" class="section-link">
                {{ __("lang.site_see_all") }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="articles-content">
            <div class="articles-main">
                @php 
                    $latest_blogs = \App\Models\Blog::where('status', 1)
                        ->with('blog_category')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();
                @endphp

                <div class="articles-grid loadList">
                    @if(isset($latest_blogs) && count($latest_blogs))
                        @foreach($latest_blogs as $blog)
                            <article class="article-card fade-in">
                                <div class="article-image">
                                    <a href="{{url('blog/'.$blog->slug)}}">
                                        <img src="{{ url('uploads/blog/'.($blog->image ?? 'default.jpg')) }}" 
                                             alt="{{$blog->title}}" 
                                             onerror="this.src='{{ asset('uploads/image_preview.jpg') }}'">
                                    </a>
                                    
                                    @if($blog->is_premium)
                                        <div class="premium-badge">
                                            <i class="fas fa-crown"></i>
                                            {{ __("lang.site_premium") }}
                                        </div>
                                    @endif
                                    
                                    <div class="article-category">
                                        @if($blog->blog_category && count($blog->blog_category) > 0)
                                            <a href="{{url('category/'.$blog->blog_category[0]->category->slug)}}">
                                                {{$blog->blog_category[0]->category->name}}
                                            </a>
                                        @else
                                            <span>{{ __("lang.site_uncategorized") }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="article-content">
                                    <h3 class="article-title">
                                        <a href="{{url('blog/'.$blog->slug)}}">{{$blog->title}}</a>
                                    </h3>
                                    
                                    <p class="article-excerpt">
                                        {{Str::limit(strip_tags($blog->description), 100)}}
                                    </p>
                                    
                                    <div class="article-meta">
                                        <span class="article-author">
                                            <i class="fas fa-user"></i>
                                            {{$blog->author_name ?: 'Fri Verden Media'}}
                                        </span>
                                        <span class="article-date">
                                            <i class="fas fa-calendar"></i>
                                            {{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="articles-sidebar">
                @include('site.home.partials.trending_sidebar')
                @include('site.home.partials.category_sidebar')
                @include('site.home.partials.popular')
            </aside>
        </div>
    </div>
</section>

<!-- About Founder Section -->
<section class="founder-section" aria-labelledby="founder-section-title">
    <div class="container">
        <div class="founder-content">
            <div class="founder-text">
                <div class="section-header">
                    <h2 class="founder-title" id="founder-section-title">{{ __("lang.site_about_founder") }}</h2>
                    <div class="title-underline"></div>
                </div>
                
                <div class="founder-info">
                    <h3 class="founder-name">{{ __("lang.site_founder_name") }}</h3>
                    <p class="founder-description">
                        {{ __("lang.site_founder_description") }}
                    </p>
                </div>
            </div>
            
            <div class="founder-image">
                <div class="image-container">
                    <div class="premium-badge">{{ __('lang.site_the_founder') }}</div>
                    <img src="{{ setting('founder_image') ? url('uploads/setting/'.setting('founder_image')) : 'https://friverdenmedia.com/wp-content/uploads/2022/12/Michel-Biem-250x333.jpeg' }}" 
                         alt="{{ __("lang.site_founder_name") }} - {{ __("lang.site_the_founder") }}" 
                         class="founder-photo" loading="lazy" decoding="async"
                         onerror="this.onerror=null;this.src='{{ asset('uploads/image_preview.png') }}'">
                    <div class="image-overlay" aria-hidden="true">
                        <div class="overlay-content">
                            <h4>{{ __("lang.site_founder_name") }}</h4>
                            <p>{{ __("lang.site_founder_description") }}</p>
                            <div class="social-links">
                                @php
                                    $socials = \Helpers::getSocialMedias(0);
                                @endphp
                                @forelse($socials as $social)
                                    @php
                                        $name = strtolower($social->name ?? '');
                                        $href = $social->link ?? '#';
                                        $isEmail = filter_var($href, FILTER_VALIDATE_EMAIL);
                                        if($isEmail){ $href = 'mailto:'.$href; }
                                        $icon = 'fas fa-link';
                                        if(str_contains($name, 'linkedin')){ $icon = 'fab fa-linkedin-in'; }
                                        elseif(str_contains($name, 'twitter') || str_contains($name, 'x')){ $icon = 'fab fa-twitter'; }
                                        elseif(str_contains($name, 'facebook')){ $icon = 'fab fa-facebook-f'; }
                                        elseif(str_contains($name, 'instagram')){ $icon = 'fab fa-instagram'; }
                                        elseif(str_contains($name, 'email') || $isEmail){ $icon = 'fas fa-envelope'; }
                                        $label = ucfirst($name ?: 'social');
                                        $title = $label;
                                        if(str_contains($name, 'twitter') || str_contains($name, 'x')){ $title = __('lang.site_share_twitter'); }
                                        if(str_contains($name, 'linkedin')){ $title = __('lang.site_share_linkedin'); }
                                    @endphp
                                    <a href="{{ $href }}" class="social-link" target="_blank" rel="noopener noreferrer" title="{{ $title }}" aria-label="{{ $title }}">
                                        <i class="{{ $icon }}"></i>
                                    </a>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="image-decorations" aria-hidden="true">
                    <div class="decoration-dot dot-1"></div>
                    <div class="decoration-dot dot-2"></div>
                    <div class="decoration-dot dot-3"></div>
                    <div class="decoration-line line-1"></div>
                    <div class="decoration-line line-2"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Membership CTA Section -->
<section class="membership-cta-section">
    <div class="container">
        <div class="cta-hero">
            <div class="cta-content">
                <div class="cta-text">
                    <div class="cta-badge">
                        <i class="fas fa-crown"></i>
                        <span>Premium</span>
                    </div>
                    <h2 class="cta-title">
                        <span class="highlight">{{ __("lang.site_support") }}</span> {{ __("lang.site_journalism") }} 
                        <span class="highlight">{{ __("lang.site_independent") }}</span>
                    </h2>
                    <p class="cta-description">
                        {{ __("lang.site_premium_cta_description") }}
                    </p>
                    
                    <div class="cta-stats">
                        <div class="stat">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">{{ __("lang.site_exclusive_articles") }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">{{ __("lang.site_priority_access") }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">{{ __("lang.site_independent") }}</span>
                        </div>
                    </div>
                    
                    <div class="cta-actions">
                        <a href="{{url('membership/plans')}}" class="cta-btn primary">
                            <i class="fas fa-crown"></i>
                            <span>{{ __("lang.site_become_premium_member") }}</span>
                        </a>
                        <a href="{{url('donation')}}" class="cta-btn secondary">
                            <i class="fas fa-heart"></i>
                            <span>{{ __("lang.site_make_donation") }}</span>
                        </a>
                    </div>
                </div>
                
                <div class="cta-visual">
                    <div class="premium-card">
                        <div class="card-header">
                            <div class="card-badge">
                                <i class="fas fa-star"></i>
                                <span>{{ __("lang.site_exclusive") }}</span>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3>{{ __("lang.site_premium_content") }}</h3>
                            <ul class="features-list">
                                <li><i class="fas fa-check"></i> {{ __("lang.site_exclusive_articles") }}</li>
                                <li><i class="fas fa-check"></i> {{ __("lang.site_deep_analysis") }}</li>
                                <li><i class="fas fa-check"></i> {{ __("lang.site_special_reports") }}</li>
                                <li><i class="fas fa-check"></i> {{ __("lang.site_premium_newsletter") }}</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <div class="price">
                                <span class="currency">{{ __("lang.site_from") }}</span>
                                <span class="amount">9.99€</span>
                                <span class="period">{{ __("lang.site_per_month") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ==============================================
   HOMEPAGE MODERN STYLES
   ============================================== */

/* Hero Section */
.hero-section {
    background: var(--gradient-hero);
    min-height: 80vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="heroPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23heroPattern)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    display: grid;
    grid-template-columns: 2fr 3fr;
    gap: var(--space-8);
    align-items: center;
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: var(--space-5);
    font-family: var(--font-display);
}

.hero-title .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-description {
    font-size: 1.1rem;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: var(--space-6);
}

.hero-actions {
    display: flex;
    gap: var(--space-3);
    margin-bottom: var(--space-6);
    flex-wrap: wrap;
}

/* Hero Action Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-xl);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 2px solid transparent;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition-normal);
}

.btn:hover::before {
    left: 100%;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn i {
    font-size: 1.1rem;
    transition: var(--transition-normal);
}

.btn:hover i {
    transform: scale(1.2);
}

/* Donate Button - Red/Heart Theme */
.btn-donate {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border-color: #e74c3c;
}

.btn-donate:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    color: white;
    border-color: #c0392b;
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
}

.btn-donate i {
    color: var(--text-secondary);
    animation: heartBeat 2s infinite;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Premium Button - Gold/Crown Theme */
.btn-premium {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    border-color: #f39c12;
}

.btn-premium:hover {
    background: linear-gradient(135deg, #e67e22, #d68910);
    color: white;
    border-color: #e67e22;
    box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
}

.btn-premium i {
    color: var(--text-secondary);
    animation: crownShine 3s infinite;
}

@keyframes crownShine {
    0%, 100% { 
        transform: scale(1) rotate(0deg); 
        filter: brightness(1);
    }
    50% { 
        transform: scale(1.1) rotate(5deg); 
        filter: brightness(1.3);
    }
}

.hero-stats {
    display: flex;
    gap: var(--space-6);
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: var(--accent-color);
    font-family: var(--font-display);
}

.stat-label {
    display: block;
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-top: var(--space-1);
}

/* Hero Slider */
.hero-slider {
    position: relative;
    width: 100%;
    height: 650px;
    border-radius: var(--radius-2xl);
    overflow: hidden;
    box-shadow: var(--shadow-2xl);
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
    transform: scale(1.05);
}

.hero-slide.active {
    opacity: 1;
    transform: scale(1);
}

.hero-card {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: var(--radius-2xl);
    overflow: hidden;
}

.hero-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        135deg,
        rgba(0,0,0,0.1) 0%,
        rgba(0,0,0,0.3) 30%,
        rgba(0,0,0,0.8) 70%,
        rgba(0,0,0,0.95) 100%
    );
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: var(--space-6);
}

/* Header Section */
.hero-overlay-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-4);
}

.article-category-badge {
    background: rgba(52, 152, 219, 0.9);
    color: white;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: var(--shadow-md);
}

.article-category-badge i {
    font-size: 0.8rem;
}

.hero-premium-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    box-shadow: var(--shadow-md);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-premium-badge i {
    font-size: 0.8rem;
}

/* Content Section */
.hero-overlay-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    margin: var(--space-4) 0;
}

.hero-article-title h3 {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: var(--space-4);
    line-height: 1.3;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-article-excerpt p {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: var(--space-4);
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.hero-article-stats {
    display: flex;
    justify-content: center;
    gap: var(--space-6);
    margin-bottom: var(--space-4);
}

.hero-article-stats .stat-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: rgba(255, 255, 255, 0.1);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-article-stats .stat-item i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

/* Footer Section */
.hero-overlay-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: var(--space-4);
}

.hero-article-meta {
    flex: 1;
}

.meta-author {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.author-avatar i {
    color: white;
    font-size: 1rem;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.author-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: white;
}

.publish-date {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
}

.hero-read-more {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    background: rgba(255, 255, 255, 0.15);
    color: white;
    text-decoration: none;
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-xl);
    font-weight: 600;
    transition: var(--transition-fast);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: var(--shadow-md);
}

.hero-read-more:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: white;
}

.read-more-icon {
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
}

.hero-read-more:hover .read-more-icon {
    background: var(--accent-color);
    transform: scale(1.1);
}

.read-more-icon i {
    font-size: 0.9rem;
    color: white;
}

/* Breaking News Banner Section */
.breaking-news-section {
    padding: var(--space-4) 0;
    /* background: var(--card-bg); */
    /* border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color); */
    position: relative;
    overflow: hidden;
}

.breaking-news-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(90deg, 
        rgba(231, 76, 60, 0.05) 0%, 
        rgba(52, 152, 219, 0.05) 50%, 
        rgba(231, 76, 60, 0.05) 100%
    ); */
    animation: backgroundShift 8s ease-in-out infinite;
}

@keyframes backgroundShift {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 0.6; }
}

.breaking-news-banner {
    position: relative;
    z-index: 2;
}

.breaking-news-content {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--space-4) var(--space-6);
    box-shadow: var(--shadow-lg);
    border: 2px solid var(--accent-color);
    position: relative;
    overflow: hidden;
}

.breaking-news-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #e74c3c, #c0392b);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.breaking-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: var(--space-3) var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    flex-shrink: 0;
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.breaking-label::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.breaking-label i {
    font-size: 1rem;
    animation: flash 1.5s infinite;
}

@keyframes flash {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.breaking-news-ticker {
    flex: 1;
    overflow: hidden;
    position: relative;
    height: 50px;
    display: flex;
    align-items: center;
}

.ticker-wrapper {
    width: 100%;
    position: relative;
}

.ticker-content {
    position: relative;
    height: 60px;
}

.ticker-item {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease-in-out;
}

.ticker-item.active {
    opacity: 1;
    transform: translateY(0);
}

.news-meta {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-1);
}

.news-category {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.news-date {
    color: var(--text-muted);
    font-size: 0.75rem;
    background: var(--secondary-color);
    padding: 0.2rem 0.5rem;
    border-radius: var(--radius-sm);
}

.news-link {
    color: #424a52;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    line-height: 1.4;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.news-link:hover {
    color: var(--accent-color);
    transform: translateX(3px);
}

.premium-indicator {
    color: #f39c12;
    font-size: 0.8rem;
    margin-left: var(--space-2);
    animation: crownGlow 2s infinite;
}

@keyframes crownGlow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.breaking-news-controls {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    flex-shrink: 0;
}

.ticker-control {
    width: 35px;
    height: 35px;
    border: none;
    background: var(--secondary-color);
    color: var(--text-primary);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    border: 2px solid var(--border-color);
}

.ticker-control:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: scale(1.1);
}

.ticker-control.pause.paused {
    background: var(--accent-color);
    color: white;
}

/* Section Headers */
.section-header {
    margin-bottom: var(--space-12);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: var(--space-4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-3);
    font-family: var(--font-display);
}

.section-title i {
    color: var(--accent-color);
    font-size: 2rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

.section-link {
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition-fast);
}

.section-link:hover {
    color: var(--accent-secondary);
    transform: translateX(5px);
}

/* Top News Section */
.top-news-section {
    padding: var(--space-20) 0;
    background: var(--secondary-color);
    position: relative;
}

.top-news-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: var(--space-6);
}

.news-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
    position: relative;
}

.news-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-2xl);
    border-color: var(--accent-color);
}

.news-card.featured {
    grid-row: span 2;
}

.news-image {
    position: relative;
    overflow: hidden;
}

.news-card.featured .news-image {
    height: 350px;
}

.news-card:not(.featured) .news-image {
    height: 200px;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-normal);
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}

.news-overlay {
    position: absolute;
    top: var(--space-4);
    left: var(--space-4);
    z-index: 2;
}

.news-category a {
    background: var(--gradient-accent);
    color: white;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.news-content {
    padding: var(--space-5);
}

.news-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: var(--space-3);
    line-height: 1.3;
}

.news-card.featured .news-title {
    font-size: 1.5rem;
}

.news-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-fast);
}

.news-title a:hover {
    color: var(--accent-color);
}

.news-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: var(--space-4);
}

.news-meta {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-4);
    color: var(--text-muted);
    font-size: 0.85rem;
}

.news-meta span {
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

/* Categories Section */
.categories-section {
    padding: var(--space-20) 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.category-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    transition: var(--transition-normal);
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.category-link {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-6);
    text-decoration: none;
    color: var(--text-primary);
}

.category-icon {
    width: 60px;
    height: 60px;
    background: var(--gradient-accent);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.category-content {
    flex: 1;
}

.category-name {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: var(--space-1);
}

.category-count {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.category-arrow {
    color: var(--accent-color);
    font-size: 1.2rem;
    transition: var(--transition-fast);
}

.category-card:hover .category-arrow {
    transform: translateX(5px);
}

/* Latest Articles Section */
.latest-articles-section {
    padding: var(--space-20) 0;
    background: var(--secondary-color);
}

.latest-articles-section .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: var(--space-8);
}

.latest-articles-section .section-title {
    justify-content: flex-start;
    margin-bottom: 0;
}

.articles-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--space-12);
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.article-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
    border-color: var(--accent-color);
}

.article-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-normal);
}

.article-card:hover .article-image img {
    transform: scale(1.05);
}

.article-category {
    position: absolute;
    top: var(--space-3);
    left: var(--space-3);
    z-index: 2;
}

.article-category a {
    background: var(--gradient-accent);
    color: white;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
}

.article-content {
    padding: var(--space-5);
}

.article-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: var(--space-3);
    line-height: 1.3;
}

.article-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-fast);
}

.article-title a:hover {
    color: var(--accent-color);
}

.article-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: var(--space-4);
    font-size: 0.9rem;
}

.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-3);
    color: var(--text-muted);
    font-size: 0.8rem;
}

.article-meta span {
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

/* Sidebar */
.articles-sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--space-8);
}

/* Premium Badge */
.premium-badge {
    position: absolute;
    top: var(--space-3);
    right: var(--space-3);
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 3;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    box-shadow: var(--shadow-md);
}

/* Founder Section */
.founder-section {
    padding: 60px 0;
    background: var(--gradient-hero);
    position: relative;
    overflow: hidden;
}

.founder-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="founderPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23founderPattern)"/></svg>');
    opacity: 0.3;
}

.founder-content {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-12);
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.founder-text {
    color: white;
    padding: var(--space-8);
}

.section-header {
    margin-bottom: var(--space-8);
}

.founder-title {
    font-size: 2.5rem;
    font-weight: 900;
    color: white;
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
    line-height: 1.1;
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.title-underline {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-secondary), var(--accent-color));
    border-radius: var(--radius-full);
    margin-bottom: var(--space-6);
}

.founder-info {
    margin-bottom: var(--space-8);
}

.founder-name {
    font-size: 2rem;
    font-weight: 800;
    color: var(--accent-secondary);
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

/* .founder-name::before {
    content: '';
    width: 3px;
    height: 30px;
    background: linear-gradient(180deg, var(--accent-secondary), var(--accent-color));
    border-radius: var(--radius-full);
} */

.founder-description {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.7;
    margin-bottom: var(--space-5);
    text-align: justify;
}

.founder-image {
    position: relative;
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-container {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: var(--radius-2xl);
    overflow: hidden;
    box-shadow: var(--shadow-2xl);
    transform: perspective(1000px) rotateY(-5deg);
    transition: var(--transition-normal);
}

.image-container:hover {
    transform: perspective(1000px) rotateY(0deg) translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
}

.founder-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-normal);
}

.image-container:hover .founder-photo {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        transparent 0%,
        rgba(0,0,0,0.3) 50%,
        rgba(0,0,0,0.8) 100%
    );
    display: flex;
    align-items: flex-end;
    color: white;
    padding: var(--space-8);
    opacity: 0;
    transition: var(--transition-normal);
}

.image-container:hover .image-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    width: 100%;
}

.overlay-content h4 {
    font-size: 1.8rem;
    font-weight: 900;
    margin-bottom: var(--space-2);
    font-family: var(--font-display);
}

.overlay-content p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: var(--space-3);
}

.social-links {
    display: flex;
    justify-content: center;
    gap: var(--space-3);
    margin-top: var(--space-3);
}

.social-link {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: var(--transition-fast);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: var(--accent-secondary);
    transform: translateY(-3px) scale(1.1);
    box-shadow: var(--shadow-lg);
}

.image-decorations {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    pointer-events: none;
}

.decoration-dot {
    width: 12px;
    height: 12px;
    background: var(--accent-secondary);
    border-radius: var(--radius-full);
    opacity: 0.3;
    animation: pulse 2s ease-in-out infinite;
}

.decoration-line {
    width: 2px;
    height: 100%;
    background: linear-gradient(180deg, transparent, var(--accent-secondary), transparent);
    opacity: 0.2;
}

.decoration-dot.dot-1 { 
    top: 10%; 
    animation-delay: 0s;
}
.decoration-dot.dot-2 { 
    top: 40%; 
    animation-delay: 0.5s;
}
.decoration-dot.dot-3 { 
    top: 70%; 
    animation-delay: 1s;
}
.decoration-line.line-1 { 
    top: 10%; 
}
.decoration-line.line-2 { 
    top: 40%; 
}

@keyframes pulse {
    0%, 100% { 
        opacity: 0.3; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.6; 
        transform: scale(1.2);
    }
}

/* Membership CTA Section */
.membership-cta-section {
    padding: var(--space-20) 0;
    background: var(--gradient-hero);
    position: relative;
    overflow: hidden;
}

.membership-cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="ctaPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23ctaPattern)"/></svg>');
    opacity: 0.3;
}

.cta-hero {
    position: relative;
    z-index: 2;
}

.cta-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-12);
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.cta-text {
    color: white;
}

.cta-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-full);
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: var(--space-6);
    box-shadow: var(--shadow-lg);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.cta-badge i {
    font-size: 1rem;
    animation: crownGlow 2s infinite;
}

@keyframes crownGlow {
    0%, 100% { 
        transform: scale(1) rotate(0deg); 
        filter: brightness(1);
    }
    50% { 
        transform: scale(1.1) rotate(5deg); 
        filter: brightness(1.3);
    }
}

.cta-title {
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: var(--space-6);
    font-family: var(--font-display);
}

.cta-title .highlight {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.cta-description {
    font-size: 1.25rem;
    line-height: 1.7;
    margin-bottom: var(--space-8);
    color: rgba(255, 255, 255, 0.9);
}

.cta-stats {
    display: flex;
    gap: var(--space-8);
    margin-bottom: var(--space-8);
}

.stat {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    color: #f39c12;
    font-family: var(--font-display);
}

.stat-label {
    display: block;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--space-1);
}

.cta-actions {
    display: flex;
    gap: var(--space-4);
    flex-wrap: wrap;
}

.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4) var(--space-8);
    border-radius: var(--radius-xl);
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-lg);
}

.cta-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition-normal);
}

.cta-btn:hover::before {
    left: 100%;
}

.cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-2xl);
}

.cta-btn.primary {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    border-color: #f39c12;
}

.cta-btn.primary:hover {
    background: linear-gradient(135deg, #e67e22, #d68910);
    border-color: #e67e22;
    box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
}

.cta-btn.secondary {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border-color: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(15px);
}

.cta-btn.secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
}

.cta-btn i {
    font-size: 1.1rem;
    transition: var(--transition-normal);
}

.cta-btn:hover i {
    transform: scale(1.2);
}

.cta-visual {
    display: flex;
    justify-content: center;
    align-items: center;
}

.premium-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: var(--shadow-2xl);
    position: relative;
    overflow: hidden;
    transform: perspective(1000px) rotateY(-5deg);
    transition: var(--transition-normal);
}

.premium-card:hover {
    transform: perspective(1000px) rotateY(0deg) translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.premium-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1));
    z-index: -1;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.card-badge {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.card-content h3 {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: var(--space-4);
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: var(--space-3);
    font-size: 0.95rem;
}

.features-list i {
    color: #27ae60;
    font-size: 1rem;
}

.card-footer {
    margin-top: var(--space-6);
    padding-top: var(--space-4);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.price {
    text-align: center;
}

.currency {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin-bottom: var(--space-1);
}

.amount {
    display: block;
    color: #f39c12;
    font-size: 2.5rem;
    font-weight: 800;
    font-family: var(--font-display);
}

.period {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

/* Slider Navigation */
.hero-slider-nav {
    position: absolute;
    bottom: var(--space-6);
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    z-index: 10;
}

.slider-nav-btn {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.slider-nav-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.slider-nav-btn:active {
    transform: scale(0.95);
}

.slider-dots {
    display: flex;
    gap: var(--space-2);
}

.dot {
    width: 12px;
    height: 12px;
    background: rgba(255, 255, 255, 0.4);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: var(--transition-fast);
    border: 2px solid transparent;
}

.dot:hover {
    background: rgba(255, 255, 255, 0.6);
}

.dot.active {
    background: white;
    transform: scale(1.2);
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

/* Auto-play progress bar */
.slider-autoplay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: rgba(255, 255, 255, 0.2);
    z-index: 10;
}

.autoplay-progress {
    height: 100%;
    background: var(--gradient-accent);
    width: 0%;
    transition: width 0.1s linear;
}

/* Slider animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: scale(1.1) translateX(50px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateX(0);
    }
}

@keyframes slideOut {
    from {
        opacity: 1;
        transform: scale(1) translateX(0);
    }
    to {
        opacity: 0;
        transform: scale(0.9) translateX(-50px);
    }
}

.hero-slide.sliding-in {
    animation: slideIn 0.8s ease-out;
}

.hero-slide.sliding-out {
    animation: slideOut 0.8s ease-out;
}

/* ==============================================
   RESPONSIVE DESIGN
   ============================================== */

@media (max-width: 1280px) {
    body {
        padding-top: 60px; /* Reduced padding for mobile */
    }
}

@media (max-width: 1024px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: var(--space-6);
        text-align: center;
    }
    
    .cta-content {
        grid-template-columns: 1fr;
        gap: var(--space-8);
        text-align: center;
    }

    .breaking-news-section {
        display: none;
    }

    .articles-sidebar {
        display: none;
    }

    .cta-visual {
        display: none;
    }

    .cta-actions{
        justify-content: center;
    }

    .hero-actions{
        justify-content: center;
    }
    
    .cta-title {
        font-size: 2.5rem;
    }
    
    .cta-stats {
        justify-content: center;
    }
    
    .premium-card {
        transform: perspective(1000px) rotateY(0deg);
    }
    
    .breaking-news-content {
        flex-direction: column;
        gap: var(--space-3);
        padding: var(--space-4);
    }
    
    .breaking-news-ticker {
        height: auto;
        min-height: 80px;
    }
    
    .ticker-content {
        height: auto;
        min-height: 80px;
    }
    
    .ticker-item {
        height: auto;
        min-height: 80px;
        position: relative;
        transform: none;
    }
    
    .ticker-item.active {
        transform: none;
    }
}

@media (max-width: 1024px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: var(--space-6);
        text-align: center;
    }
    
    .top-news-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .articles-content {
        grid-template-columns: 1fr;
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .hero-slider {
        height: 500px;
    }
    
    .hero-slider-nav {
        bottom: var(--space-4);
    }
    
    .slider-nav-btn {
        width: 40px;
        height: 40px;
    }
    
    .dot {
        width: 10px;
        height: 10px;
    }
}
    
@media (max-width: 1024px) {
    .founder-content {
        grid-template-columns: 1fr;
        gap: var(--space-8);
        /* text-align: center; */
    }
    
    .founder-title {
        font-size: 2rem;
    }
    
    .founder-name {
        font-size: 1.8rem;
        justify-content: center;
    }
    
    .founder-image {
        height: 300px;
        order: -1;
    }
    
    .image-container {
        transform: perspective(1000px) rotateY(0deg);
    }
    
    .image-container:hover {
        transform: perspective(1000px) rotateY(0deg) translateY(-5px);
    }
}

@media (max-width: 853px) {
    body {
        padding-top: 60px; /* Reduced padding for mobile */
    }

    .breaking-news-section {
        display: none;
    }

    .articles-sidebar {
        display: none;
    }

    .cta-visual {
        display: none;
    }

    .cta-actions{
        justify-content: center;
    }

    .hero-actions{
        justify-content: center;
    }
}

@media (max-width: 820px) {
    body {
        padding-top: 60px; /* Reduced padding for mobile */
    }

    .breaking-news-section {
        display: none;
    }

    .articles-sidebar {
        display: none;
    }

    .cta-visual {
        display: none;
    }

    .cta-actions{
        justify-content: center;
    }

    .hero-actions{
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .breaking-news-section {
        display: none;
    }

    .articles-sidebar {
        display: none;
    }

    .cta-visual {
        display: none;
    }
    
    .breaking-news-content {
        padding: var(--space-3);
        gap: var(--space-2);
    }
    
    .breaking-label {
        font-size: 0.8rem;
        padding: var(--space-2) var(--space-3);
    }
    
    .news-link {
        font-size: 0.9rem;
    }
    
    .breaking-news-controls {
        gap: var(--space-1);
    }
    
    .ticker-control {
        width: 30px;
        height: 30px;
        font-size: 0.7rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-actions {
        align-items: center;
    }
    
    .hero-stats {
        flex-wrap: wrap;
        gap: var(--space-4);
    }
    
    .cta-card {
        padding: var(--space-6);
    }
    
    .cta-title {
        font-size: 1.8rem;
    }
    
    .cta-benefits {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }
    
    .benefit-item {
        padding: var(--space-3);
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
        gap: var(--space-3);
    }
    
    .hero-slider {
        height: 350px;
    }
    
    .hero-slider-nav {
        bottom: var(--space-3);
        gap: var(--space-2);
    }
    
    .slider-nav-btn {
        width: 35px;
        height: 35px;
    }
    
    .slider-dots {
        gap: var(--space-1);
    }
    
    .dot {
        width: 8px;
        height: 8px;
    }
    
    .hero-card-overlay {
        padding: var(--space-4);
    }
    
    .hero-overlay-header {
        margin-bottom: var(--space-3);
    }
    
    .article-category-badge,
    .hero-premium-badge {
        padding: var(--space-1) var(--space-3);
        font-size: 0.7rem;
    }
    
    .hero-article-title h3 {
        font-size: 1.4rem;
        margin-bottom: var(--space-3);
    }
    
    .hero-article-excerpt p {
        font-size: 0.9rem;
        margin-bottom: var(--space-3);
    }
    
    .hero-article-stats {
        gap: var(--space-3);
        margin-bottom: var(--space-3);
    }
    
    .hero-article-stats .stat-item {
        padding: var(--space-1) var(--space-2);
        font-size: 0.7rem;
    }
    
    .hero-overlay-footer {
        flex-direction: column;
        gap: var(--space-3);
        align-items: stretch;
        position: relative;
    }
    
    .meta-author {
        justify-content: center;
        margin-bottom: var(--space-2);
    }
    
    .hero-read-more {
        position: absolute;
        bottom: 58px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--accent-color);
        color: white;
        padding: var(--space-2) var(--space-5);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid white;
        z-index: 5;
        min-width: 120px;
        text-align: center;
        transition: var(--transition-normal);
        font-size: 0.85rem;
    }

    .hero-article-meta {
        display: none;
    }

    .all-blogs {
        display: none;
    }
    
    .hero-read-more:hover {
        background: var(--accent-secondary);
        transform: translateX(-50%) translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }
    
    .hero-read-more .read-more-icon {
        display: none;
    }
    
    /* Ajuster la hauteur du slider pour accommoder le bouton */
    .hero-slider {
        height: 380px;
    }
    
    .top-news-grid {
        grid-template-columns: 1fr;
    }
    
    .news-card.featured .news-image {
        height: 250px;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .latest-articles-section .section-header {
        flex-direction: column;
        gap: var(--space-4);
        text-align: center;
    }
    
    .articles-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .cta-features {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-card {
        padding: var(--space-8);
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .cta-benefits {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .benefit-item {
        padding: var(--space-4);
    }
    
    .cta-card {
        padding: var(--space-8);
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .cta-benefits {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .benefit-item {
        padding: var(--space-4);
    }

    .founder-content {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .founder-image {
        margin-top: var(--space-12);
    }

    .image-decorations {
        display: none; /* Hide decorations on smaller screens */
    }
}

@media (max-width: 480px) {
    .breaking-news-section {
        display: none;
    }

    .articles-sidebar {
        display: none;
    }

    .cta-visual {
        display: none;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1.1rem;
    }
    
    .hero-card-overlay {
        padding: var(--space-3);
    }
    
    .hero-article-title h3 {
        font-size: 1.2rem;
        margin-bottom: var(--space-2);
    }
    
    .hero-article-excerpt p {
        font-size: 0.8rem;
        margin-bottom: var(--space-2);
    }
    
    .hero-article-stats {
        gap: var(--space-2);
        margin-bottom: var(--space-2);
    }
    
    .hero-article-stats .stat-item {
        padding: var(--space-1);
        font-size: 0.65rem;
    }
    
    .author-avatar {
        width: 35px;
        height: 35px;
    }
    
    .author-name {
        font-size: 0.8rem;
    }
    
    .publish-date {
        font-size: 0.7rem;
    }
    
    .hero-read-more {
        position: absolute;
        bottom: 50px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--accent-color);
        color: white;
        padding: var(--space-2) var(--space-4);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid white;
        z-index: 5;
        min-width: 110px;
        text-align: center;
        transition: var(--transition-normal);
        font-size: 0.8rem;
    }

    .hero-article-meta {
        display: none;
    }

    .all-blogs {
        display: none;
    }
    
    .hero-read-more:hover {
        background: var(--accent-secondary);
        transform: translateX(-50%) translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }
    
    .hero-read-more .read-more-icon {
        display: none;
    }
    
    /* Ajuster la hauteur du slider pour accommoder le bouton */
    .hero-slider {
        height: 360px;
    }
    
    .read-more-icon {
        width: 25px;
        height: 25px;
    }
    
    .section-title {
        font-size: 2rem;
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .news-content,
    .article-content {
        padding: var(--space-4);
    }
    
    .category-link {
        padding: var(--space-4);
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
    }

    .founder-name {
        font-size: 1.5rem;
    }

    .founder-description {
        font-size: 1rem;
    }
    
    .founder-stats {
        flex-direction: column;
        gap: var(--space-4);
    }

    .achievement-item {
        flex-direction: column;
        align-items: center;
        gap: var(--space-2);
    }

    .achievement-item i {
        font-size: 1.2rem;
    }

    .overlay-content h4 {
        font-size: 1.5rem;
    }

    .overlay-content p {
        font-size: 0.9rem;
    }

    .social-links {
        justify-content: center;
    }

    .social-link {
        width: 35px;
        height: 35px;
    }
}
</style>

@php $show_pagination = 1; @endphp

<script>
// Hero Slider functionality
let currentSlideIndex = 0;
let slideInterval;
const slideDuration = 5000; // 5 seconds per slide

// Get all slides and dots
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.dot');
const progressBar = document.querySelector('.autoplay-progress');

// Initialize slider
function initSlider() {
    if (slides.length === 0) return;
    
    showSlide(currentSlideIndex);
    startAutoPlay();
    
    // Pause autoplay on hover
    const slider = document.querySelector('.hero-slider');
    slider.addEventListener('mouseenter', pauseAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);
}

// Show specific slide
function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => {
        slide.classList.remove('active');
        slide.classList.remove('sliding-in');
        slide.classList.remove('sliding-out');
    });
    
    // Remove active class from all dots
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Show current slide with animation
    if (slides[index]) {
        slides[index].classList.add('active');
        slides[index].classList.add('sliding-in');
        
        // Remove animation class after animation completes
        setTimeout(() => {
            slides[index].classList.remove('sliding-in');
        }, 800);
    }
    
    // Activate corresponding dot
    if (dots[index]) {
        dots[index].classList.add('active');
    }
    
    // Reset progress bar
    if (progressBar) {
        progressBar.style.width = '0%';
    }
}

// Change slide (next/previous)
function changeSlide(direction) {
    const totalSlides = slides.length;
    
    if (direction === 1) {
        // Next slide
        currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
    } else {
        // Previous slide
        currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
    }
    
    showSlide(currentSlideIndex);
    resetAutoPlay();
}

// Go to specific slide
function currentSlide(index) {
    currentSlideIndex = index;
    showSlide(currentSlideIndex);
    resetAutoPlay();
}

// Auto-play functionality
function startAutoPlay() {
    if (slideInterval) clearInterval(slideInterval);
    
    slideInterval = setInterval(() => {
        changeSlide(1);
    }, slideDuration);
    
    // Animate progress bar
    if (progressBar) {
        progressBar.style.transition = `width ${slideDuration}ms linear`;
        progressBar.style.width = '100%';
    }
}

function pauseAutoPlay() {
    if (slideInterval) {
        clearInterval(slideInterval);
        slideInterval = null;
    }
    
    if (progressBar) {
        progressBar.style.transition = 'none';
    }
}

function resetAutoPlay() {
    pauseAutoPlay();
    startAutoPlay();
}

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

function handleTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX;
}

function handleTouchEnd(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next slide
            changeSlide(1);
        } else {
            // Swipe right - previous slide
            changeSlide(-1);
        }
    }
}

// Add touch event listeners
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.hero-slider');
    if (slider) {
        slider.addEventListener('touchstart', handleTouchStart, false);
        slider.addEventListener('touchend', handleTouchEnd, false);
    }
    
    initSlider();
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (e.key === 'ArrowRight') {
        changeSlide(1);
    }
});

// Pause autoplay when page is not visible
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        pauseAutoPlay();
    } else {
        startAutoPlay();
    }
});

// Breaking News Ticker functionality
let currentNewsIndex = 0;
let newsInterval;
let isNewsPaused = false;
const newsDuration = 5000; // 5 seconds per news

// Initialize breaking news ticker
function initBreakingNewsTicker() {
    const newsItems = document.querySelectorAll('.ticker-item');
    if (newsItems.length === 0) return;
    
    showNewsItem(currentNewsIndex);
    startNewsAutoplay();
}

// Show specific news item
function showNewsItem(index) {
    const newsItems = document.querySelectorAll('.ticker-item');
    if (newsItems.length === 0) return;
    
    // Hide all items
    newsItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Show current item
    if (newsItems[index]) {
        newsItems[index].classList.add('active');
    }
}

// Start auto-play for news ticker
function startNewsAutoplay() {
    if (newsInterval) clearInterval(newsInterval);
    
    newsInterval = setInterval(() => {
        if (!isNewsPaused) {
            nextNews();
        }
    }, newsDuration);
}

// Stop auto-play for news ticker
function stopNewsAutoplay() {
    if (newsInterval) {
        clearInterval(newsInterval);
        newsInterval = null;
    }
}

// Next news item
function nextNews() {
    const newsItems = document.querySelectorAll('.ticker-item');
    if (newsItems.length === 0) return;
    
    currentNewsIndex = (currentNewsIndex + 1) % newsItems.length;
    showNewsItem(currentNewsIndex);
}

// Previous news item
function previousNews() {
    const newsItems = document.querySelectorAll('.ticker-item');
    if (newsItems.length === 0) return;
    
    currentNewsIndex = (currentNewsIndex - 1 + newsItems.length) % newsItems.length;
    showNewsItem(currentNewsIndex);
}

// Toggle autoplay
function toggleAutoplay() {
    const pauseBtn = document.querySelector('.ticker-control.pause');
    const icon = pauseBtn.querySelector('i');
    
    if (isNewsPaused) {
        isNewsPaused = false;
        startNewsAutoplay();
        icon.className = 'fas fa-pause';
        pauseBtn.classList.remove('paused');
    } else {
        isNewsPaused = true;
        stopNewsAutoplay();
        icon.className = 'fas fa-play';
        pauseBtn.classList.add('paused');
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initSlider();
    initBreakingNewsTicker();
    
    // Pause news ticker on hover
    const newsSection = document.querySelector('.breaking-news-content');
    if (newsSection) {
        newsSection.addEventListener('mouseenter', () => {
            if (!isNewsPaused) {
                stopNewsAutoplay();
            }
        });
        
        newsSection.addEventListener('mouseleave', () => {
            if (!isNewsPaused) {
                startNewsAutoplay();
            }
        });
    }
});
</script>

@endsection