@php 
    // Récupérer les blogs les plus populaires basés sur BlogAnalytic
    $popular_blog_ids = \App\Models\BlogAnalytic::where('type', 'view')
        ->select('blog_id', \DB::raw('COUNT(*) as view_count'))
        ->groupBy('blog_id')
        ->orderByDesc('view_count')
        ->limit(4)
        ->pluck('blog_id');
    
    if(count($popular_blog_ids) > 0) {
        $popular_blogs = \App\Models\Blog::whereIn('id', $popular_blog_ids)
            ->where('status', 1)
            ->with('blog_category')
            ->get()
            ->sortByDesc(function($blog) {
                return \App\Models\BlogAnalytic::where('type', 'view')->where('blog_id', $blog->id)->count();
            });
    } else {
        // Fallback: utiliser les blogs les plus récents si pas de données de vues
        $popular_blogs = \App\Models\Blog::where('status', 1)
            ->with('blog_category')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
    }
@endphp

@if(isset($popular_blogs) && count($popular_blogs))
<div class="sidebar-widget popular-widget">
    <div class="widget-header">
        <h3 class="widget-title">
            <i class="fas fa-thumbs-up"></i>
            Articles Populaires
        </h3>
    </div>
    
    <div class="widget-content">
        <div class="popular-list">
            @foreach($popular_blogs as $index => $blog)
                <article class="popular-item">
                    <div class="popular-image">
                        <a href="{{url('blog/'.$blog->slug)}}">
                            <img src="{{ url('uploads/blog/'.($blog->image ?? 'default.jpg')) }}" 
                                 alt="{{$blog->title}}" 
                                 onerror="this.src='{{ asset('uploads/image_preview.jpg') }}'">
                        </a>
                        
                        @if($blog->is_premium)
                            <div class="premium-badge-small">
                                <i class="fas fa-crown"></i>
                            </div>
                        @endif
                        
                        <div class="popular-rank">
                            <span>{{ $index + 1 }}</span>
                        </div>
                    </div>
                    
                    <div class="popular-content">
                        <div class="popular-category">
                            @if($blog->blog_category && count($blog->blog_category) > 0)
                                <a href="{{url('category/'.$blog->blog_category[0]->category->slug)}}">
                                    {{$blog->blog_category[0]->category->name}}
                                </a>
                            @else
                                <span>{{ __("lang.site_uncategorized") }}</span>
                            @endif
                        </div>
                        
                        <h4 class="popular-title">
                            <a href="{{url('blog/'.$blog->slug)}}">
                                {{Str::limit($blog->title, 70)}}
                            </a>
                        </h4>
                        
                        <div class="popular-meta">
                            <span class="popular-views">
                                <i class="fas fa-eye"></i>
                                {{number_format(\App\Models\BlogAnalytic::where('type', 'view')->where('blog_id', $blog->id)->count())}}
                            </span>
                            <span class="popular-date">
                                <i class="fas fa-clock"></i>
                                {{\Carbon\Carbon::parse($blog->created_at)->diffForHumans()}}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="widget-footer">
            <a href="{{url('all-blogs')}}" class="view-all-btn">
                <i class="fas fa-arrow-right"></i>
                {{ __("lang.site_see_all_articles") }}
            </a>
        </div>
    </div>
</div>
@endif

{{-- <!-- Newsletter Widget -->
<div class="sidebar-widget newsletter-widget">
    <div class="widget-header">
        <h3 class="widget-title">
            <i class="fas fa-envelope"></i>
            Newsletter
        </h3>
    </div>
    
    <div class="widget-content">
        <div class="newsletter-content">
            <div class="newsletter-icon">
                <i class="fas fa-bell"></i>
            </div>
            <h4>Restez Informé</h4>
            <p>{{ __("lang.site_receive_latest_news_email") }}.</p>
            
            <form class="newsletter-form" action="{{url('newsletter/subscribe')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="{{ __("lang.site_your_email_address") }}" class="newsletter-input" required>
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <p class="newsletter-disclaimer">
                    <i class="fas fa-lock"></i>
                    Nous respectons votre vie privée.
                </p>
            </form>
        </div>
    </div>
</div> --}}

{{-- Follow Us Widget - Supprimé pour éviter l'affichage automatique --}}

<style>
/* Popular Widget Styles */
.popular-widget .popular-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
}

.popular-item {
    display: flex;
    gap: var(--space-4);
    align-items: flex-start;
    padding: var(--space-4);
    border-radius: var(--radius-lg);
    transition: var(--transition-fast);
    position: relative;
}

.popular-item:hover {
    background: var(--card-bg-light);
    transform: translateX(5px);
}

.popular-image {
    width: 90px;
    height: 70px;
    border-radius: var(--radius-md);
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}

.popular-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-fast);
}

.popular-item:hover .popular-image img {
    transform: scale(1.1);
}

.popular-rank {
    position: absolute;
    top: -0.5rem;
    left: -0.5rem;
    width: 25px;
    height: 25px;
    background: var(--gradient-accent);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 0.8rem;
    border: 3px solid var(--card-bg);
    z-index: 2;
}

.popular-content {
    flex: 1;
    min-width: 0;
}

.popular-category {
    margin-bottom: var(--space-2);
}

.popular-category a {
    background: var(--gradient-accent);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 600;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.popular-title {
    margin-bottom: var(--space-3);
    line-height: 1.3;
    font-size: 0.95rem;
    font-weight: 600;
}

.popular-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-fast);
}

.popular-title a:hover {
    color: var(--accent-color);
}

.popular-meta {
    display: flex;
    gap: var(--space-3);
    font-size: 0.75rem;
    color: var(--text-muted);
}

.popular-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.popular-meta i {
    font-size: 0.7rem;
    opacity: 0.8;
}

.popular-views {
    color: var(--accent-color);
    font-weight: 600;
}

.widget-footer {
    padding-top: var(--space-5);
    border-top: 1px solid var(--border-color);
    margin-top: var(--space-5);
}

.view-all-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-4);
    background: var(--gradient-accent);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition-fast);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.view-all-btn:hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
    transform: translateY(-2px);
    color: white;
}

/* Newsletter Widget Styles */
.newsletter-widget {
    background: var(--gradient-accent);
    border: none;
    color: white;
}

.newsletter-widget .widget-header {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
}

.newsletter-widget .widget-title {
    color: white;
}

.newsletter-widget .widget-title i {
    color: rgba(255, 255, 255, 0.9);
}

.newsletter-content {
    text-align: center;
}

.newsletter-icon {
    margin-bottom: var(--space-4);
}

.newsletter-icon i {
    font-size: 3rem;
    color: rgba(255, 255, 255, 0.9);
}

.newsletter-content h4 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: var(--space-3);
    color: white;
}

.newsletter-content p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: var(--space-6);
    line-height: 1.6;
}

.newsletter-form {
    margin-bottom: var(--space-4);
}

.form-group {
    position: relative;
    display: flex;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: white;
}

.newsletter-input {
    flex: 1;
    padding: var(--space-4) var(--space-5);
    border: none;
    background: transparent;
    color: var(--primary-color);
    font-size: 1rem;
    outline: none;
}

.newsletter-input::placeholder {
    color: rgba(26, 26, 46, 0.6);
}

.newsletter-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: var(--space-4) var(--space-5);
    cursor: pointer;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
}

.newsletter-btn:hover {
    background: var(--secondary-color);
}

.newsletter-disclaimer {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    margin: 0;
}

/* Social Widget Styles */
.social-links {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.social-link {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    text-decoration: none;
    color: var(--text-primary);
    transition: var(--transition-fast);
    border: 1px solid var(--border-color);
}

.social-link:hover {
    background: var(--accent-color);
    color: white;
    transform: translateX(5px);
    border-color: var(--accent-color);
}

.social-link i {
    width: 20px;
    text-align: center;
    font-size: 1.2rem;
}

.social-name {
    flex: 1;
    font-weight: 600;
}

.social-arrow {
    opacity: 0.6;
    transition: var(--transition-fast);
}

.social-link:hover .social-arrow {
    opacity: 1;
    transform: translateX(3px);
}

/* Platform specific colors */
.social-link[href*="facebook"]:hover {
    background: #1877f2;
    border-color: #1877f2;
}

.social-link[href*="twitter"]:hover {
    background: #1da1f2;
    border-color: #1da1f2;
}

.social-link[href*="instagram"]:hover {
    background: #e4405f;
    border-color: #e4405f;
}

.social-link[href*="linkedin"]:hover {
    background: #0077b5;
    border-color: #0077b5;
}

.social-link[href*="youtube"]:hover {
    background: #ff0000;
    border-color: #ff0000;
}

/* Responsive Design */
@media (max-width: 768px) {
    .popular-image {
        width: 70px;
        height: 55px;
    }
    
    .popular-title {
        font-size: 0.9rem;
    }
    
    .popular-meta {
        font-size: 0.7rem;
    }
    
    .newsletter-content h4 {
        font-size: 1.1rem;
    }
    
    .newsletter-input {
        padding: var(--space-3) var(--space-4);
        font-size: 0.9rem;
    }
    
    .newsletter-btn {
        padding: var(--space-3) var(--space-4);
    }
}
</style>