@php 
    // Récupérer les blogs les plus vus basés sur BlogAnalytic
    $popular_blog_ids = \App\Models\BlogAnalytic::where('type', 'view')
        ->select('blog_id', \DB::raw('COUNT(*) as view_count'))
        ->groupBy('blog_id')
        ->orderByDesc('view_count')
        ->limit(5)
        ->pluck('blog_id');
    
    if(count($popular_blog_ids) > 0) {
        $trending_blogs = \App\Models\Blog::whereIn('id', $popular_blog_ids)
            ->where('status', 1)
            ->with('blog_category')
            ->get()
            ->sortByDesc(function($blog) {
                return \App\Models\BlogAnalytic::where('type', 'view')->where('blog_id', $blog->id)->count();
            });
    } else {
        // Fallback: utiliser les blogs les plus récents si pas de données de {{ __("lang.site_views") }}
        $trending_blogs = \App\Models\Blog::where('status', 1)
            ->with('blog_category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
@endphp

@if(isset($trending_blogs) && count($trending_blogs))
<div class="sidebar-widget trending-widget">
    <div class="widget-header">
        <h3 class="widget-title">
            <i class="fas fa-fire"></i>
            Tendances
        </h3>
    </div>
    
    <div class="widget-content">
        <div class="trending-list">
            @foreach($trending_blogs as $index => $blog)
                <article class="trending-item">
                    <div class="trending-number">
                        <span>{{ $index + 1 }}</span>
                    </div>
                    
                    <div class="trending-image">
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
                    </div>
                    
                    <div class="trending-content">
                        <div class="trending-category">
                            @if($blog->blog_category && count($blog->blog_category) > 0)
                                <a href="{{url('category/'.$blog->blog_category[0]->category->slug)}}">
                                    {{$blog->blog_category[0]->category->name}}
                                </a>
                            @else
                                <span>{{ __("lang.site_uncategorized") }}</span>
                            @endif
                        </div>
                        
                        <h4 class="trending-title">
                            <a href="{{url('blog/'.$blog->slug)}}">
                                {{Str::limit($blog->title, 60)}}
                            </a>
                        </h4>
                        
                        <div class="trending-meta">
                            <span class="trending-views">
                                <i class="fas fa-eye"></i>
                                {{number_format(\App\Models\BlogAnalytic::where('type', 'view')->where('blog_id', $blog->id)->count())}} {{ __("lang.site_views") }}
                            </span>
                            <span class="trending-date">
                                <i class="fas fa-calendar"></i>
                                {{\Carbon\Carbon::parse($blog->created_at)->diffForHumans()}}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</div>
@endif

<style>
/* Trending Widget Styles */
.sidebar-widget {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: var(--transition-normal);
    overflow: hidden;
    margin-bottom: var(--space-8);
}

.sidebar-widget:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.widget-header {
    padding: var(--space-5) var(--space-6);
    background: var(--card-bg-light);
    border-bottom: 1px solid var(--border-color);
}

.widget-title {
    color: var(--text-primary);
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--space-3);
    font-family: var(--font-display);
}

.widget-title i {
    color: var(--accent-color);
    font-size: 1.2rem;
}

.widget-content {
    padding: var(--space-6);
}

.trending-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
}

.trending-item {
    display: flex;
    gap: var(--space-4);
    align-items: flex-start;
    padding: var(--space-4);
    border-radius: var(--radius-lg);
    transition: var(--transition-fast);
    position: relative;
}

.trending-item:hover {
    background: var(--card-bg-light);
    transform: translateX(5px);
}

.trending-number {
    width: 30px;
    height: 30px;
    background: var(--gradient-accent);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.trending-item:nth-child(1) .trending-number {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.trending-item:nth-child(2) .trending-number {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
}

.trending-item:nth-child(3) .trending-number {
    background: linear-gradient(135deg, #cd7f32, #b8860b);
}

.trending-image {
    width: 80px;
    height: 60px;
    border-radius: var(--radius-md);
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}

.trending-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-fast);
}

.trending-item:hover .trending-image img {
    transform: scale(1.1);
}

.premium-badge-small {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    width: 16px;
    height: 16px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
}

.trending-content {
    flex: 1;
    min-width: 0;
}

.trending-category {
    margin-bottom: var(--space-2);
}

.trending-category a {
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

.trending-title {
    margin-bottom: var(--space-3);
    line-height: 1.3;
    font-size: 0.95rem;
    font-weight: 600;
}

.trending-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-fast);
}

.trending-title a:hover {
    color: var(--accent-color);
}

.trending-meta {
    display: flex;
    flex-direction: column;
    gap: var(--space-1);
    font-size: 0.75rem;
    color: var(--text-muted);
}

.trending-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.trending-meta i {
    font-size: 0.7rem;
    opacity: 0.8;
}

.trending-views {
    color: var(--accent-color);
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .trending-image {
        width: 60px;
        height: 45px;
    }
    
    .trending-title {
        font-size: 0.9rem;
    }
    
    .trending-meta {
        font-size: 0.7rem;
    }
    
    .widget-header,
    .widget-content {
        padding: var(--space-4);
    }
}
</style>