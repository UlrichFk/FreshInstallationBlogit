@extends('site/layout/site-app')
@section('content')

<style>
/* ==============================================
   BLOG DETAIL PAGE STYLES
   ============================================== */

.blog-detail-page {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Section */
.blog-hero {
    background: var(--gradient-hero);
    border-radius: var(--radius-xl);
    overflow: hidden;
    margin-bottom: 3rem;
    box-shadow: var(--shadow-xl);
    position: relative;
    border: 1px solid var(--border-color);
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="blogPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23blogPattern)"/></svg>');
    opacity: 0.3;
}

.hero-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: var(--transition-normal);
    position: relative;
    z-index: 2;
}

.blog-hero:hover .hero-image {
    transform: scale(1.02);
}

.hero-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(26, 26, 46, 0.9));
    padding: 3rem 2rem 2rem;
    z-index: 3;
}

.hero-content {
    position: relative;
    z-index: 4;
}

.hero-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.hero-category {
    display: inline-block;
    background: var(--gradient-accent);
    color: var(--text-primary);
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    text-decoration: none;
}

.hero-category.primary {
    background: var(--gradient-accent);
    color: var(--text-primary);
}

.hero-category.secondary {
    background: rgba(255, 255, 255, 0.2);
    color: var(--text-primary);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-category:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    font-family: var(--font-display);
}

.hero-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
    color: var(--text-secondary);
    flex-wrap: wrap;
}

.hero-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.hero-meta-item i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.hero-meta-item a {
    color: var(--text-secondary);
    transition: var(--transition-normal);
    text-decoration: none;
}

.hero-meta-item a:hover {
    color: var(--accent-color);
    transform: translateX(3px);
}

/* Premium Badge */
.premium-badge {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #000;
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-lg);
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.premium-badge::before {
    content: '👑';
    font-size: 1.1rem;
}

/* Main Content */
.blog-content {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: 3rem;
    box-shadow: var(--shadow-lg);
    margin-bottom: 3rem;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.blog-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.content-body {
    position: relative;
    z-index: 2;
}

.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-primary);
    margin-bottom: 2rem;
}

.content-text p {
    margin-bottom: 1.5rem;
}

.content-text h2, .content-text h3, .content-text h4 {
    color: var(--text-primary);
    margin: 2.5rem 0 1.5rem 0;
    font-weight: 700;
    font-family: var(--font-display);
}

.content-text h2 {
    font-size: 2.25rem;
    color: var(--accent-color);
}

.content-text h3 {
    font-size: 1.875rem;
}

.content-text h4 {
    font-size: 1.5rem;
}

.content-text blockquote {
    background: var(--card-bg-light);
    border-left: 4px solid var(--accent-color);
    padding: 2rem;
    margin: 2.5rem 0;
    border-radius: var(--radius-lg);
    font-style: italic;
    color: var(--text-secondary);
    position: relative;
}

.content-text blockquote::before {
    content: '"';
    font-size: 4rem;
    color: var(--accent-color);
    position: absolute;
    top: -1rem;
    left: 1rem;
    font-family: var(--font-display);
}

.content-text ul, .content-text ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.content-text li {
    margin-bottom: 0.75rem;
    color: var(--text-secondary);
}

/* Video Section */
.video-section {
    margin: 2.5rem 0;
    text-align: center;
}

.video-container {
    position: relative;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.video-container iframe {
    width: 100%;
    height: 450px;
    border: none;
    border-radius: var(--radius-lg);
}

/* Source Information */
.source-info {
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin: 2.5rem 0;
    border: 1px solid var(--border-color);
    position: relative;
}

.source-info::before {
    content: '📰';
    position: absolute;
    top: -15px;
    left: 2rem;
    background: var(--card-bg);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-lg);
    font-size: 1.2rem;
    border: 1px solid var(--border-color);
}

.source-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.source-link {
    color: var(--accent-color);
    text-decoration: underline;
    transition: var(--transition-normal);
}

.source-link:hover {
    color: var(--accent-secondary);
}

/* Tags Section */
.tags-section {
    margin: 2.5rem 0;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.tags-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.tag-item {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    transition: var(--transition-normal);
    text-decoration: none;
    border: 1px solid var(--border-color);
}

.tag-item:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Premium Content Banner */
.premium-content-banner {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    border-radius: var(--radius-xl);
    padding: 3rem;
    margin: 2.5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.premium-content-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(0,0,0,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(0,0,0,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(0,0,0,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(0,0,0,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(0,0,0,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.premium-content-banner h3 {
    color: #000;
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
    font-family: var(--font-display);
}

.premium-content-banner p {
    color: #333;
    font-size: 1.2rem;
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
    line-height: 1.6;
}

.premium-content-banner .btn {
    background: #000;
    color: #fff;
    border: none;
    padding: 1.25rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    transition: var(--transition-normal);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 2;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.premium-content-banner .btn::before {
    content: '👑';
    font-size: 1.3rem;
}

.premium-content-banner .btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-2xl);
    background: #333;
}

/* Content Preview */
.content-preview {
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin: 2.5rem 0;
    border: 2px dashed var(--border-color);
    position: relative;
    text-align: center;
    overflow: visible;
}

/* .content-preview::before {
    content: '🔒';
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--card-bg);
    padding: 0.5rem;
    border-radius: 50%;
    font-size: 1.2rem;
    border: 2px solid var(--border-color);
    z-index: 10;
    box-shadow: var(--shadow-sm);
} */

.content-preview p {
    color: var(--text-secondary);
    font-style: italic;
    margin: 0;
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Social Share Section */
.social-share-section {
    margin: 2.5rem 0;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.share-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-normal);
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    min-width: 120px;
    justify-content: center;
}

.share-btn.facebook {
    background: #1877f2;
    color: white;
}

.share-btn.twitter {
    background: #1da1f2;
    color: white;
}

.share-btn.linkedin {
    background: #0077b5;
    color: white;
}

.share-btn.whatsapp {
    background: #25d366;
    color: white;
}

.share-btn.copy {
    background: var(--accent-color);
    color: var(--text-primary);
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Author Info */
.author-info {
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    margin: 2.5rem 0;
    border: 1px solid var(--border-color);
}

.author-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.author-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    border: 3px solid var(--gradient-accent);
    box-shadow: var(--shadow-md);
}

.author-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: var(--transition-normal);
}

.author-avatar:hover .author-image {
    transform: scale(1.1);
}

.author-details h5 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    font-family: var(--font-display);
}

.author-name {
    color: var(--accent-color);
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
}

.author-bio {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.6;
}

.author-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.stat-item i {
    color: var(--accent-color);
    font-size: 1rem;
}

.stat-item.premium {
    color: #ffd700;
    font-weight: 600;
}

.stat-item.premium i {
    color: #ffd700;
}

/* Premium Content Info */
.premium-content-info {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin: 2.5rem 0;
    text-align: center;
    border: 1px solid var(--border-color);
}

.premium-content-info h5 {
    color: #000;
    font-size: 1.3rem;
    margin-bottom: 0.75rem;
    font-family: var(--font-display);
}

.premium-content-info p {
    color: #333;
    margin: 0;
    line-height: 1.6;
}

/* Related Articles */
.related-articles {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: 3rem;
    margin-top: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
}

.section-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.section-header h3 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    font-family: var(--font-display);
}

.section-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin: 0;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.related-item {
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
    text-decoration: none;
}

.related-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.related-image {
    position: relative;
    overflow: hidden;
}

.related-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: var(--transition-normal);
}

.related-item:hover img {
    transform: scale(1.05);
}

.related-premium-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-md);
}

.related-content {
    padding: 1.5rem;
}

.related-content h4 {
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    font-family: var(--font-display);
}

.related-content h4 a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-normal);
}

.related-content h4 a:hover {
    color: var(--accent-color);
}

.related-excerpt {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.related-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.meta-item {
    color: var(--text-secondary);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-item i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-detail-page {
        margin-top: 80px;
        padding: 1rem 0;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .blog-content {
        padding: 2rem;
    }

    .hero-image {
        height: 300px;
    }

    .hero-overlay {
        padding: 2rem 1rem 1rem;
    }

    .hero-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .hero-categories {
        justify-content: center;
        gap: 0.5rem;
    }

    .hero-category {
        padding: 0.6rem 1.2rem;
        font-size: 0.8rem;
    }

    .premium-content-banner {
        padding: 2rem;
    }

    .premium-content-banner h3 {
        font-size: 2rem;
    }

    .related-grid {
        grid-template-columns: 1fr;
    }

    .premium-badge {
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .author-header {
        flex-direction: column;
        text-align: center;
    }

    .share-buttons {
        justify-content: center;
    }

    .share-btn {
        min-width: 100px;
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
    }

    .author-stats {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }

    .blog-content {
        padding: 1.5rem;
    }

    .content-text h2 {
        font-size: 1.75rem;
    }

    .content-text h3 {
        font-size: 1.5rem;
    }
}
</style>

<div class="blog-detail-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="blog-hero">
            @if($row->image!='')
                <img src="{{ url('uploads/blog/768x428/'.$row->image->image)}}" 
                     onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" 
                     alt="{{$row->title}}" 
                     class="hero-image" />
            @else
                <img src="{{ asset('site-assets/img/1920x982.png')}}"  
                     onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" 
                     alt="{{$row->title}}" 
                     class="hero-image" />
            @endif
            
            @if($row->is_premium)
                <div class="premium-badge">Premium</div>
            @endif
            
            <div class="hero-overlay">
                <div class="hero-content">
                    <div class="hero-categories">
                        @if(isset($row->blog_categories) && count($row->blog_categories) > 0)
                            @php
                                $categories = collect($row->blog_categories)->where('type', 'category');
                                $subcategories = collect($row->blog_categories)->where('type', 'subcategory');
                            @endphp
                            
                            @foreach($categories as $blogCategory)
                                @if(isset($blogCategory->category) && $blogCategory->category)
                                    <a href="{{url('category/'.$blogCategory->category->slug)}}" 
                                       class="hero-category primary" 
                                       title="{{$blogCategory->category->name}}">
                                        {{$blogCategory->category->name}}
                                    </a>
                                @endif
                            @endforeach
                            
                            @foreach($subcategories as $blogCategory)
                                @if(isset($blogCategory->category) && $blogCategory->category)
                                    <a href="{{url('category/'.$blogCategory->category->slug)}}" 
                                       class="hero-category secondary" 
                                       title="{{$blogCategory->category->name}}">
                                        {{$blogCategory->category->name}}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    
                    <h1 class="hero-title">{{$row->title}}</h1>
                    
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><?php echo \Helpers::showSiteDateFormat($row->schedule_date);?></span>
                        </div>
                        
                        @if(Auth::user()!='')
                            <div class="hero-meta-item">
                                <a href="javascript:;" onclick="addRemoveBookMarks('{{$row->id}}','detail');" title="{{{{ __('lang.website_save_post') }}}}">
                                    @if($row->blog_bookmark==0)
                                        <i class="fa fa-bookmark-o notmarked"></i>
                                    @else
                                        <i class="fa fa-bookmark marked"></i>
                                    @endif
                                    {{{{ __('lang.website_save_post') }}}}
                                </a>															
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                <!-- Main Content -->
                <div class="blog-content">
                    <div class="content-body">
                        @if($row->is_premium && (!Auth::user() || !Auth::user()->canAccessPremiumContent($row)))
                            <!-- Premium Content Banner -->
                            <div class="premium-content-banner">
                                <h3>🔒 {{ __("lang.site_premium_content") }}</h3>
                                <p>Cet article est exclusivement disponible pour nos membres premium. Abonnez-vous maintenant pour débloquer l'accès à ce contenu et à tout le contenu premium.</p>
                                <a href="{{url('membership/plans')}}" class="btn">Obtenir l{{ __('lang.site_premium_access') }}</a>
                            </div>
                            
                            <!-- Show limited content for non-subscribers -->
                            <div class="content-preview">
                                <p><?php echo \Helpers::getLimitedDescription($row->description, 300); ?></p>
                            </div>
                        @else
                            <!-- Full content for subscribers or non-premium content -->
                            <div class="content-text">
                                @if($row->video_url)
                                    <?php
                                        function convertToEmbedUrl($url) {
                                            $parsedUrl = parse_url($url);
                                            
                                            if (isset($parsedUrl['host']) && $parsedUrl['host'] === 'www.youtube.com' && isset($parsedUrl['query'])) {
                                                parse_str($parsedUrl['query'], $queryParams);
                                                
                                                if (isset($queryParams['v'])) {
                                                    return 'https://www.youtube.com/embed/' . $queryParams['v'];
                                                } else {
                                                    return false;
                                                }
                                            } else {
                                                return false;
                                            }
                                        }
                                    
                                        $youtubeUrl = $row->video_url;
                                        $embedUrl = convertToEmbedUrl($youtubeUrl);
                                    ?>
                                        
                                    @if($embedUrl)
                                        <div class="video-section">
                                            <div class="video-container">
                                                <iframe src="{{$embedUrl}}" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                
                                <div class="content-text">
                                    <?php echo $row->description; ?>
                                </div>
                                
                                @if($row->source_name !='')
                                    <div class="source-info">
                                        <div class="source-label">{{ __("lang.site_source") }}:</div>
                                        <a href="{{$row->source_link}}" target="_blank" class="source-link">{{$row->source_name}}</a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Tags Section -->
                        @if($row->tags!='')
                            <div class="tags-section">
                                <div class="tags-title">
                                    <i class="fas fa-tags"></i> {{ __("lang.site_tags") }}
                                </div>
                                <div class="tags-list">
                                    @foreach($row->tags as $tags)
                                        <a href="{{url('search-blog?keyword='.$tags)}}" title="{{$tags}}" class="tag-item">
                                            # {{$tags}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Social Share Section -->
                        <div class="social-share-section">
                            <div class="share-title">
                                <i class="fas fa-share-alt"></i> {{ __("lang.site_share_this_article") }}
                            </div>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" 
                                   class="share-btn facebook" 
                                   title="{{ __("lang.site_share_facebook") }}">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                                
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($row->title) }}" 
                                   target="_blank" 
                                   class="share-btn twitter" 
                                   title="{{ __("lang.site_share_twitter") }}">
                                    <i class="fab fa-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                                
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank" 
                                   class="share-btn linkedin" 
                                   title="{{ __("lang.site_share_linkedin") }}">
                                    <i class="fab fa-linkedin-in"></i>
                                    <span>LinkedIn</span>
                                </a>
                                
                                <a href="https://wa.me/?text={{ urlencode($row->title . ' - ' . url()->current()) }}" 
                                   target="_blank" 
                                   class="share-btn whatsapp" 
                                   title="{{ __("lang.site_share_whatsapp") }}">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>WhatsApp</span>
                                </a>
                                
                                <button onclick="copyToClipboard('{{ url()->current() }}')" 
                                        class="share-btn copy" 
                                        title="{{ __("lang.site_copy_link") }}">
                                    <i class="fas fa-link"></i>
                                    <span>Copier</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Author Info Section -->
                <div class="author-info">
                    <div class="author-header">
                        <div class="author-avatar">
                            <img src="https://friverdenmedia.com/wp-content/uploads/2022/12/Michel-Biem-250x333.jpeg" 
                                 alt="Michel Biem Tong" 
                                 onerror="this.src='{{ asset('site-assets/img/default-author.jpg') }}; this.onerror=null;"
                                 class="author-image">
                        </div>
                        <div class="author-details">
                            <h5>À propos de l'auteur</h5>
                            <p class="author-name">Michel Biem Tong</p>
                            <p class="author-bio">Journaliste et analyste expérimenté, Michel Biem Tong partage des analyses approfondies et des insights exclusifs pour vous tenir informé des dernières actualités et tendances. Sa passion pour l'information et son expertise dans le domaine font de lui une référence dans le monde du journalisme.</p>
                        </div>
                    </div>
                    <div class="author-stats">
                        <div class="stat-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ $row->view_count ?? 0 }} {{ __("lang.site_views") }}</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Publié le {{ \Helpers::showSiteDateFormat($row->schedule_date) }}</span>
                        </div>
                        @if($row->is_premium)
                            <div class="stat-item premium">
                                <i class="fas fa-crown"></i>
                                <span>Contenu Premium</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($row->is_premium && Auth::user() && Auth::user()->hasActiveSubscription())
                    <!-- Premium Content Info -->
                    <div class="premium-content-info">
                        <h5>👑 {{ __("lang.site_premium_content_unlocked") }}</h5>
                        <p>{{ __("lang.site_thank_you_premium_member") }}
                    </div>
                @endif

                <!-- Related Articles -->
                @if(isset($related_articles) && count($related_articles))
                    <div class="related-articles">
                        <div class="section-header">
                            <h3>📚 {{ __("lang.site_related_articles") }}</h3>
                            <p>{{ __("lang.site_discover_other_articles") }}</p>
                        </div>
                        <div class="related-grid">
                            @foreach($related_articles as $related)
                                <div class="related-item">
                                    <div class="related-image">
                                        @if($related->image && $related->image->image)
                                            <img src="{{ url('uploads/blog/327x250/'.$related->image->image)}}" 
                                                 alt="{{$related->title}}" 
                                                 onerror="this.src='{{ url('uploads/no-image-latest.png') }}">
                                        @else
                                            <img src="{{ url('uploads/no-image-latest.png') }}" 
                                                 alt="{{$related->title}}">
                                        @endif
                                        @if($related->is_premium)
                                            <div class="related-premium-badge">Premium</div>
                                        @endif
                                    </div>
                                    <div class="related-content">
                                        <h4><a href="{{url('blog/'.$related->slug)}}">{{$related->title}}</a></h4>
                                        <p class="related-excerpt">{{ \Helpers::getLimitedDescription($related->description ?? '', 80) }}</p>
                                        <div class="related-meta">
                                            <div class="meta-item">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span>{{ \Helpers::showSiteDateFormat($related->schedule_date) }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-eye"></i>
                                                <span>{{ $related->view_count ?? 0 }} {{ __("lang.site_views") }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                <div class="sidebar-widgets">
                    @include('site/home/partials/popular') 
                    @include('site/home/partials/category_sidebar') 
                    @include('site/home/partials/trending_sidebar') 
                    @include('site/home/partials/follow_us') 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to copy URL to clipboard
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        // Use the modern Clipboard API
        navigator.clipboard.writeText(text).then(function() {
            showCopySuccess();
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            fallbackCopyTextToClipboard(text);
        });
    } else {
        // Fallback for older browsers
        fallbackCopyTextToClipboard(text);
    }
}

// Fallback copy function for older browsers
function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        }
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }
    
    document.body.removeChild(textArea);
}

// Show success message
function showCopySuccess() {
    const copyBtn = document.querySelector('.share-btn.copy');
    const originalText = copyBtn.innerHTML;
    
    copyBtn.innerHTML = '<i class="fas fa-check"></i><span>Copié !</span>';
    copyBtn.style.background = '#28a745';
    
    setTimeout(() => {
        copyBtn.innerHTML = originalText;
        copyBtn.style.background = '';
    }, 2000);
}

// Add click tracking for social share buttons
document.addEventListener('DOMContentLoaded', function() {
    const shareButtons = document.querySelectorAll('.share-btn:not(.copy)');
    
    shareButtons.forEach(button => {
        button.addEventListener('click', function() {
            // You can add analytics tracking here
            console.log('Shared on:', this.classList.contains('facebook') ? 'Facebook' : 
                                   this.classList.contains('twitter') ? 'Twitter' : 
                                   this.classList.contains('linkedin') ? 'LinkedIn' : 'WhatsApp');
        });
    });
});
</script>

@endsection