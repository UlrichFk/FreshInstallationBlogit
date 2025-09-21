@extends('site/layout/site-app')
@section('content')

<style>
.search-container {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Header */
.search-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.05) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.search-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.05) 0%, rgba(83, 52, 131, 0.05) 100%);
    z-index: 1;
}

.search-header-content {
    position: relative;
    z-index: 2;
}

.search-header h3 {
    color: var(--text-primary);
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1.25rem;
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.search-header .search-description {
    color: var(--text-secondary);
    font-size: 1.2rem;
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
    font-weight: 400;
}

.search-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.search-stat {
    background: rgba(255, 255, 255, 0.08);
    padding: 1.25rem 1.75rem;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.search-stat::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1) 0%, rgba(83, 52, 131, 0.1) 100%);
    opacity: 0;
    transition: var(--transition);
}

.search-stat:hover::before {
    opacity: 1;
}

.search-stat:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.search-stat .stat-number {
    display: block;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--accent-color);
    margin-bottom: 0.375rem;
    position: relative;
    z-index: 2;
}

.search-stat .stat-label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 600;
    position: relative;
    z-index: 2;
}

/* Search Form */
.search-form-container {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    margin-bottom: 3rem;
    position: relative;
    overflow: hidden;
}

.search-form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    z-index: 1;
}

.search-form-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 2;
}

.search-form-title i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.search-form {
    position: relative;
    z-index: 2;
}

.search-input-group {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.search-input {
    flex: 1;
    min-width: 300px;
    padding: 1rem 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: 30px;
    background: var(--card-bg);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

.search-btn {
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    padding: 1rem 2rem;
    border: 1px solid rgba(15, 52, 96, 0.1);
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.search-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--accent-color) 0%, rgba(83, 52, 131, 0.8) 100%);
    opacity: 0;
    transition: var(--transition);
}

.search-btn:hover::before {
    opacity: 1;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
}

.search-btn span {
    position: relative;
    z-index: 2;
}

/* Results Header */
.results-header {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.results-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    z-index: 1;
}

.results-header > * {
    position: relative;
    z-index: 2;
}

.results-count {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
}

.results-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.sort-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 600;
}

.sort-select {
    padding: 0.5rem 0.875rem;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    background: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.9rem;
}

.sort-select:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

/* Enhanced article cards */
.article-card {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}

.article-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    opacity: 0;
    transition: var(--transition);
}

.article-card:hover::before {
    opacity: 1;
}

.article-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.article-image {
    position: relative;
    overflow: hidden;
    height: 220px;
    flex-shrink: 0;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.article-card:hover .article-image img {
    transform: scale(1.08);
}

.article-meta {
    position: absolute;
    top: 1rem;
    left: 1rem;
    z-index: 3;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.article-meta .bookmark-btn {
    color: var(--text-primary);
    background: rgba(0, 0, 0, 0.8);
    padding: 0.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    transition: var(--transition);
    backdrop-filter: blur(10px);
    border: none;
    cursor: pointer;
}

.article-meta .bookmark-btn:hover {
    background: var(--accent-color);
    transform: scale(1.1);
}

.article-meta .publish-date {
    background: rgba(0, 0, 0, 0.8);
    color: var(--text-primary);
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.article-meta .publish-date a {
    color: var(--text-primary);
    text-decoration: none;
}

.article-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 2;
}

.category-tag {
    display: inline-block;
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 1.2rem;
    box-shadow: var(--shadow-md);
    align-self: flex-start;
    border: 1px solid rgba(15, 52, 96, 0.1);
}

.category-tag a {
    color: var(--text-primary);
    text-decoration: none;
}

.article-title h3 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.4;
    flex-grow: 1;
}

.article-title h3 a {
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
}

.article-title h3 a:hover {
    color: var(--accent-color);
}

.article-card p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex-grow: 1;
    font-size: 0.9rem;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    font-size: 0.85rem;
    align-self: flex-start;
    margin-top: auto;
    border: 1px solid rgba(15, 52, 96, 0.1);
    position: relative;
    overflow: hidden;
}

.read-more-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--accent-color) 0%, rgba(83, 52, 131, 0.8) 100%);
    opacity: 0;
    transition: var(--transition);
}

.read-more-btn:hover::before {
    opacity: 1;
}

.read-more-btn::after {
    content: '→';
    font-size: 1.2rem;
    transition: var(--transition);
    position: relative;
    z-index: 2;
}

.read-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
}

.read-more-btn:hover::after {
    transform: translateX(8px);
}

.read-more-btn span {
    position: relative;
    z-index: 2;
}

.premium-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: var(--text-primary);
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 700;
    z-index: 3;
    box-shadow: var(--shadow-md);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 215, 0, 0.3);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--card-bg);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
}

.empty-icon {
    margin-bottom: 1.5rem;
}

.empty-icon i {
    font-size: 4rem;
    color: var(--text-muted);
    opacity: 0.7;
}

.empty-state h4 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1rem;
    line-height: 1.6;
}

.btn-primary {
    background: var(--accent-color);
    color: var(--text-primary);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
}

.btn-primary:hover {
    background: var(--accent-secondary);
    color: var(--text-primary);
}

/* Enhanced sidebar */
.widget-area {
    position: sticky;
    top: 120px;
}

.widget-area .widget {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.widget-area .widget::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    opacity: 0;
}

.widget-area .widget:hover::before {
    opacity: 1;
}

.widget-area .widget > * {
    position: relative;
    z-index: 2;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-container {
        margin-top: 80px;
        padding: 1rem 0;
    }

    .search-header {
        padding: 2.5rem 1.5rem;
        margin-bottom: 2rem;
    }

    .search-header h3 {
        font-size: 2.25rem;
        margin-bottom: 1rem;
    }

    .search-header .search-description {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .search-stats {
        gap: 1.25rem;
        margin-top: 1.5rem;
    }

    .search-stat {
        padding: 1rem 1.25rem;
    }

    .search-stat .stat-number {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .search-stat .stat-label {
        font-size: 0.8rem;
    }

    .search-form-container {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .search-form-title {
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .search-input-group {
        flex-direction: column;
        align-items: stretch;
    }

    .search-input {
        min-width: auto;
        width: 100%;
    }

    .search-btn {
        width: 100%;
        text-align: center;
    }

    .results-header {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        gap: 0.75rem;
    }

    .results-count {
        font-size: 1rem;
    }

    .results-actions {
        gap: 0.75rem;
    }

    .article-image {
        height: 220px;
    }

    .article-content {
        padding: 1.5rem;
    }

    .article-title h3 {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .search-header h3 {
        font-size: 1.875rem;
        margin-bottom: 0.875rem;
    }
    
    .search-header .search-description {
        font-size: 1rem;
        margin-bottom: 1.25rem;
    }
    
    .search-stats {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        margin-top: 1.25rem;
    }
    
    .search-stat {
        padding: 0.875rem 1rem;
    }
    
    .search-stat .stat-number {
        font-size: 1.25rem;
    }
    
    .search-stat .stat-label {
        font-size: 0.75rem;
    }
    
    .search-form-container {
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .search-form-title {
        font-size: 1.1rem;
        margin-bottom: 0.875rem;
    }
    
    .search-input {
        padding: 0.875rem 1.25rem;
        font-size: 0.95rem;
    }
    
    .search-btn {
        padding: 0.875rem 1.5rem;
        font-size: 0.95rem;
    }
    
    .results-header {
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    .results-count {
        font-size: 0.95rem;
    }

    .sort-select {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    .article-image {
        height: 180px;
    }
    
    .article-content {
        padding: 1rem;
    }
    
    .article-title h3 {
        font-size: 1.1rem;
    }
    
    .premium-badge,
    .category-tag {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }
    
    .read-more-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }
}
</style>

<div class="search-container">
    <div class="container">
        <!-- Search Header -->
        <div class="search-header">
            <div class="search-header-content">
                <h3>{{__('messages.search_articles')}}</h3>
                <p class="search-description">
                    {{__('messages.search_description')}}
                </p>
                
                <div class="search-stats">
                    <div class="search-stat">
                        <span class="stat-number">{{ count($result) }}</span>
                        <span class="stat-label">{{__('messages.results')}}</span>
                    </div>
                    <div class="search-stat">
                        <span class="stat-number">{{ \App\Models\Blog::where('status', 1)->count() }}</span>
                        <span class="stat-label">{{__('messages.total_articles')}}</span>
                    </div>
                    <div class="search-stat">
                        <span class="stat-number">{{ \App\Models\Category::where('status', 1)->count() }}</span>
                        <span class="stat-label">{{__('messages.categories')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-form-container">
            <div class="search-form-title">
                <i class="fas fa-search"></i>
                {{__('messages.search_articles_label')}}
            </div>
            <form class="search-form" method="GET" action="{{ url('search-blogs') }}">
                <div class="search-input-group">
                    <input type="text" 
                           name="keyword" 
                           class="search-input" 
                           placeholder="{{__('messages.search_placeholder')}}" 
                           value="{{ request('keyword') }}"
                           required>
                    <button type="submit" class="search-btn">
                        <span>{{__('messages.search')}}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Header -->
        @if(request('keyword'))
            <div class="results-header">
                <div class="results-count">
                    @if(isset($result) && count($result))
                        {{ count($result) }} {{__('messages.results_found')}} "{{ request('keyword') }}"
                    @else
                        {{__('messages.no_results')}} "{{ request('keyword') }}"
                    @endif
                </div>
                <div class="results-actions">
                    <span class="sort-label">{{__('messages.sort_by')}}</span>
                    <select class="sort-select" onchange="sortSearchResults(this.value)">
                        <option value="relevance">{{__('messages.sort_relevance')}}</option>
                        <option value="latest">{{__('messages.sort_latest')}}</option>
                        <option value="oldest">{{__('messages.sort_oldest')}}</option>
                        <option value="popular">{{__('messages.sort_popular')}}</option>
                        <option value="title">{{__('messages.sort_alphabetical')}}</option>
                    </select>
                </div>
            </div>
        @endif

        <!-- Articles Grid -->
        <div class="row">
            <div class="col-lg-8 col-md-6 content-area">
                @if(isset($result) && count($result))
                    <div class="row">
                        @foreach($result as $row)
                            <div class="col-lg-6 col-md-12 col-sm-6 mb-3">
                                <article class="article-card">
                                    <div class="article-image">
                                        <div class="article-meta">
                                            <span class="bookmark-btn">
                                                @if(Auth::user()!='')
                                                    <a href="javascript:;" onclick="addRemoveBookMarks('{{$row->id}}','search');" title="{{__('lang.website_save_post')}}">
                                                        @if($row->blog_bookmark==1)
                                                            <i class="fa fa-bookmark marked_{{$row->id}}"></i>
                                                        @else
                                                            <i class="fa fa-bookmark-o notmarked_{{$row->id}}"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                            </span>
                                            <span class="publish-date">
                                                <a href="#"><?php echo \Helpers::showSiteDateFormat($row->schedule_date);?></a>
                                            </span>
                                        </div>
                                        
                                        <a href="{{url('blog/'.$row->slug)}}">
                                            @if($row->image!='')
                                                <img src="{{ url('uploads/blog/327x250/'.$row->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
                                            @else
                                                <img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
                                            @endif
                                        </a>
                                        
                                        @if($row->is_premium)
                                            <div class="premium-badge">Premium</div>
                                        @endif
                                    </div>
                                    
                                    <div class="article-content">
                                        <div class="entry-header">
                                            <span class="category-tag">
                                                @if(isset($row->blog_categories) && $row->blog_categories!='')
                                                    @if(isset($row->blog_categories->category) && $row->blog_categories->category!='')
                                                        <a href="{{url('category/'.$row->blog_categories->category->slug)}}" title="{{$row->blog_categories->category->name}}">{{$row->blog_categories->category->name}}</a>
                                                    @endif
                                                @endif
                                            </span>
                                            <h3 class="article-title">
                                                <a href="{{url('blog/'.$row->slug)}}" title="{{$row->title}}">{{\Helpers::getLimitedTitle($row->title)}}</a>
                                            </h3>
                                        </div>
                                        
                                        <p><?php echo \Helpers::getLimitedDescription($row->description);?></p>
                                        
                                        <a href="{{url('blog/'.$row->slug)}}" class="read-more-btn" title="{{__('lang.website_read_more')}}">
                                            <span>{{__('lang.website_read_more')}}</span>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @elseif(request('keyword'))
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <h4>{{ __("lang.site_no_results_found") }}</h4>
                        <p>Nous n'avons trouvé aucun article correspondant à votre recherche "{{ request('keyword') }}". {{ __("lang.site_try_other_keywords") }}</p>
                        <a href="{{ url('/') }}" class="btn-primary">
                            Retour à l'accueil
                        </a>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <h4>Commencez votre recherche</h4>
                        <p>{{ __("lang.site_search_form_description") }}</p>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4 col-md-6 widget-area">
                @include('site/home/partials/popular') 
                @include('site/home/partials/category_sidebar') 
                @include('site/home/partials/trending_sidebar') 
                @include('site/home/partials/follow_us') 
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sort functionality for search results
    window.sortSearchResults = function(sortType) {
        // You can implement AJAX sorting here or redirect with sort parameter
        console.log('Sorting by:', sortType);
        // For now, just show a message
        alert('Fonctionnalité de tri en cours de développement');
    };
    
    // Enhanced bookmark functionality
    const bookmarkButtons = document.querySelectorAll('.bookmark-btn a');
    bookmarkButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add visual feedback
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
    
    // Enhanced search form
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');
    
    searchForm.addEventListener('submit', function(e) {
        if (!searchInput.value.trim()) {
            e.preventDefault();
            searchInput.focus();
            searchInput.style.borderColor = '#e74c3c';
            setTimeout(() => {
                searchInput.style.borderColor = '';
            }, 2000);
        }
    });
    
    // Auto-focus search input
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>

@endsection