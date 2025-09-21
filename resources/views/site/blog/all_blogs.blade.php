@extends('site/layout/site-app')
@section('content')

<style>
.all-blogs-container {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Header */
.hero-header {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.05) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    padding: 3rem 2rem;
}

.hero-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.05) 0%, rgba(83, 52, 131, 0.05) 100%);
    z-index: 1;
}

.hero-header-content {
    position: relative;
    z-index: 2;
}

.hero-header h1 {
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
    text-align: center;
}

.hero-header .hero-description {
    color: var(--text-secondary);
    font-size: 1.2rem;
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
    text-align: center;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.hero-stat {
    background: rgba(255, 255, 255, 0.08);
    padding: 1.25rem 1.75rem;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    position: relative;
    overflow: hidden;
}

.hero-stat::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1) 0%, rgba(83, 52, 131, 0.1) 100%);
    opacity: 0;
}

.hero-stat:hover::before {
    opacity: 1;
}

.hero-stat:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.hero-stat .stat-number {
    display: block;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--accent-color);
    margin-bottom: 0.375rem;
    position: relative;
    z-index: 2;
}

.hero-stat .stat-label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 600;
    position: relative;
    z-index: 2;
}

/* Advanced Filters */
.filters-container {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.filters-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    z-index: 1;
}

.filters-content {
    position: relative;
    z-index: 2;
}

.filters-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filters-title i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}

.filter-group {
    position: relative;
}

.filter-label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 25px;
    background: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.9rem;
}

.filter-select:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.apply-filters-btn {
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    border: 1px solid rgba(15, 52, 96, 0.1);
    padding: 0.875rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.apply-filters-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--accent-color) 0%, rgba(83, 52, 131, 0.8) 100%);
    opacity: 0;
}

.apply-filters-btn:hover::before {
    opacity: 1;
}

.apply-filters-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
}

.apply-filters-btn span {
    position: relative;
    z-index: 2;
}

.clear-filters-btn {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
    padding: 0.875rem 1.75rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
}

.clear-filters-btn:hover {
    background: var(--border-color);
    color: var(--text-primary);
    transform: translateY(-2px);
}

/* Category Navigation */
.category-navigation {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.category-navigation::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    z-index: 1;
}

.category-nav-content {
    position: relative;
    z-index: 2;
}

.category-nav-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-nav-title i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.category-list {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    justify-content: center;
    margin: 0;
    padding: 0;
    row-gap: 1rem;
}

.category-item {
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    border: 1px solid transparent;
    position: relative;
    overflow: hidden;
    margin: 0.25rem;
}

.category-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--accent-color) 0%, rgba(83, 52, 131, 0.8) 100%);
    opacity: 0;
}

.category-item:hover::before {
    opacity: 1;
}

.category-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
    color: var(--text-primary);
}

.category-item span {
    position: relative;
    z-index: 2;
}

.category-item.active {
    background: linear-gradient(135deg, var(--accent-color) 0%, rgba(83, 52, 131, 0.8) 100%);
    color: var(--text-primary);
    box-shadow: var(--shadow-lg);
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

.results-sort {
    display: flex;
    align-items: center;
    gap: 0.875rem;
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

/* Enhanced Article Cards */
.article-card {
    background: var(--card-bg);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.article-card:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

/* Article Image */
.article-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Premium Tag */
.premium-tag {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-md);
}

/* Category Tag */
.category-tag {
    position: absolute;
    top: 1rem;
    left: 1rem;
}

.category-tag a {
    background: var(--accent-color);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-md);
}

.category-tag a:hover {
    background: var(--accent-secondary);
}

/* Article Content */
.article-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Article Meta */
.article-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0;
    font-size: 0.9rem;
    padding-bottom: 0.5rem;
}

.publish-date {
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
}

.publish-date i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

.bookmark-btn {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s ease;
}

.bookmark-btn:hover {
    background: rgba(52, 152, 219, 0.1);
    color: var(--accent-color);
}

.bookmark-btn .text-primary {
    color: var(--accent-color) !important;
}

/* Article Title */
.article-title {
    margin: 0;
    line-height: 1.3;
}

.article-title a {
    color: var(--text-primary);
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.3;
    display: block;
}

.article-title a:hover {
    color: var(--accent-color);
}

/* Article Excerpt */
.article-excerpt {
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0;
    flex-grow: 1;
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Article Footer */
.article-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.5rem 0;
}

.read-more:hover {
    color: var(--accent-secondary);
}

.read-more i {
    font-size: 0.75rem;
}

/* Pagination Wrapper */
.pagination-wrapper {
    text-align: center;
    margin-top: 3rem;
}

/* Empty State */
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

.empty-state h3 {
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
    .all-blogs-container {
        margin-top: 80px;
        padding: 1rem 0;
    }

    .hero-header {
        padding: 2rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .hero-header h1 {
        font-size: 2.25rem;
        margin-bottom: 1rem;
    }

    .hero-header .hero-description {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .hero-stats {
        gap: 1.25rem;
        margin-top: 1.5rem;
    }

    .hero-stat {
        padding: 1rem 1.25rem;
    }

    .hero-stat .stat-number {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .hero-stat .stat-label {
        font-size: 0.8rem;
    }

    .filters-container,
    .category-navigation {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filters-title,
    .category-nav-title {
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .filters-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-actions {
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .category-list {
        justify-content: center;
        gap: 0.75rem;
    }

    .category-item {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
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

    .results-sort {
        gap: 0.75rem;
    }

    .article-image {
        height: 200px;
    }
    
    .article-content {
        padding: 1.25rem;
        gap: 0.875rem;
    }
    
    .article-title a {
        font-size: 1.2rem;
    }
    
    .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .article-footer {
        padding-top: 0.875rem;
    }
}

@media (max-width: 576px) {
    .hero-header {
        padding: 1.5rem 1rem;
        margin-bottom: 1.25rem;
    }

    .hero-header h1 {
        font-size: 1.875rem;
        margin-bottom: 0.875rem;
    }

    .hero-header .hero-description {
        font-size: 1rem;
        margin-bottom: 1.25rem;
    }

    .hero-stats {
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .hero-stat {
        padding: 0.875rem 1rem;
    }

    .hero-stat .stat-number {
        font-size: 1.25rem;
    }

    .hero-stat .stat-label {
        font-size: 0.75rem;
    }

    .filters-container,
    .category-navigation {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .filters-title,
    .category-nav-title {
        font-size: 1.1rem;
        margin-bottom: 0.875rem;
    }

    .filters-grid {
        gap: 0.875rem;
        margin-bottom: 0.875rem;
    }

    .filter-select {
        padding: 0.625rem 0.875rem;
        font-size: 0.85rem;
    }

    .apply-filters-btn,
    .clear-filters-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }

    .category-item {
        padding: 0.5rem 0.875rem;
        font-size: 0.8rem;
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
        gap: 0.75rem;
    }
    
    .article-title a {
        font-size: 1.1rem;
    }
    
    .premium-tag,
    .category-tag a {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }
    
    .article-footer {
        padding-top: 0.75rem;
    }

    .publish-date {
        font-size: 0.8rem;
    }

    .publish-date i {
        font-size: 0.8rem;
    }

    .article-excerpt {
        font-size: 0.85rem;
    }

    .read-more {
        font-size: 0.8rem;
    }
}
</style>

<div class="all-blogs-container">
    <div class="container">
        <!-- Hero Header -->
        <div class="hero-header">
            <div class="hero-header-content">
                <h1>Bibliothèque d'{{ __("lang.site_articles") }}</h1>
                <p class="hero-description">
                    {{ __("lang.site_explore_collection") }} 
                    la démocratie et les droits de l'homme. Découvrez des perspectives uniques et des informations fiables.
                </p>
                
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number">{{ \App\Models\Blog::where('status', 1)->count() }}</span>
                        <span class="stat-label">{{ __("lang.site_articles") }} Total</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number">{{ \App\Models\Category::where('parent_id', 0)->where('status', 1)->count() }}</span>
                        <span class="stat-label">Catégories</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number">{{ \App\Models\User::count() }}</span>
                        <span class="stat-label">Lecteurs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="filters-container">
            <div class="filters-content">
                <div class="filters-title">
                    <i class="fas fa-filter"></i>
                    Filtres Avancés
                </div>
                
                <form id="filtersForm" method="GET" action="{{ url('all-blogs') }}">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Catégorie</label>
                            <select name="category_id" class="filter-select">
                                <option value="">Toutes les catégories</option>
                                @foreach(\App\Models\Category::where('parent_id', 0)->where('status', 1)->get() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">{{ __("lang.site_content_type") }}</label>
                            <select name="type" class="filter-select">
                                <option value="">{{ __("lang.site_all_types") }}</option>
                                <option value="post" {{ request('type') == 'post' ? 'selected' : '' }}>{{ __("lang.site_articles") }}</option>
                                <option value="quote" {{ request('type') == 'quote' ? 'selected' : '' }}>{{ __("lang.site_quotes") }}</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">Tri par</label>
                            <select name="sort" class="filter-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Ordre alphabétique</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">Par page</label>
                            <select name="perpage" class="filter-select">
                                <option value="12" {{ request('perpage') == '12' ? 'selected' : '' }}>12 articles</option>
                                <option value="24" {{ request('perpage') == '24' ? 'selected' : '' }}>24 articles</option>
                                <option value="48" {{ request('perpage') == '48' ? 'selected' : '' }}>48 articles</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="apply-filters-btn">
                            <span><i class="fas fa-search"></i> Appliquer les filtres</span>
                        </button>
                        <a href="{{ url('all-blogs') }}" class="clear-filters-btn">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Navigation -->
        {{-- <div class="category-navigation">
            <div class="category-nav-content">
                <div class="category-nav-title">
                    <i class="fas fa-sitemap"></i>
                    Navigation par Catégorie
                </div>
                <div class="category-list">
                    <a href="{{ url('all-blogs') }}" class="category-item {{ !request('category_id') ? 'active' : '' }}">
                        <span>Toutes</span>
                    </a>
                    @foreach(\App\Models\Category::where('parent_id', 0)->where('status', 1)->limit(8)->get() as $cat)
                        <a href="{{ url('all-blogs?category_id='.$cat->id) }}" 
                           class="category-item {{ request('category_id') == $cat->id ? 'active' : '' }}">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div> --}}

        <!-- Results Header -->
        <div class="results-header">
            <div class="results-count">
                @if(isset($result) && count($result))
                    {{ $result->total() }} article(s) trouvé(s)
                @else
                    {{ __("lang.site_no_articles_available") }}
                @endif
            </div>
            <div class="results-sort">
                <span class="sort-label">{{ __("lang.site_sort_by") }}:</span>
                <select class="sort-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Ordre alphabétique</option>
                </select>
            </div>
        </div>

        <!-- {{ __("lang.site_articles") }} Grid -->
        <div class="row">
            <div class="col-lg-8 col-md-6 content-area">
                @if(isset($result) && count($result))
                    <div class="row">
                        @foreach($result as $row)
                            <div class="col-lg-6 col-md-12 col-sm-6 mb-3">
                                <article class="article-card">
                                    <!-- Article Image -->
                                    <div class="article-image">
                                        <a href="{{url('blog/'.$row->slug)}}">
                                            @if($row->image!='')
                                                <img src="{{ url('uploads/blog/327x250/'.$row->image->image)}}" 
                                                     onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" 
                                                     alt="{{$row->title}}" />
                                            @else
                                                <img src="{{ asset('site-assets/img/1920x982.png')}}"  
                                                     onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" 
                                                     alt="{{$row->title}}" />
                                            @endif
                                        </a>
                                        
                                        <!-- Premium Badge -->
                                        @if($row->is_premium)
                                            <div class="premium-tag">Premium</div>
                                        @endif
                                        
                                        <!-- Category Tag -->
                                        @if(isset($row->blog_categories) && $row->blog_categories!='')
                                            @if(isset($row->blog_categories->category) && $row->blog_categories->category!='')
                                                <div class="category-tag">
                                                    <a href="{{url('category/'.$row->blog_categories->category->slug)}}" 
                                                       title="{{$row->blog_categories->category->name}}">
                                                        {{$row->blog_categories->category->name}}
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- Article Content -->
                                    <div class="article-content">
                                        <!-- Article Meta -->
                                        <div class="article-meta">
                                            <span class="publish-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo \Helpers::showSiteDateFormat($row->schedule_date);?>
                                            </span>
                                            
                                            @if(Auth::user()!='')
                                                <button class="bookmark-btn" 
                                                        onclick="addRemoveBookMarks('{{$row->id}}','allblogs');" 
                                                        title="{{__('lang.website_save_post')}}">
                                                    @if($row->blog_bookmark==0)
                                                        <i class="fas fa-bookmark"></i>
                                                    @else
                                                        <i class="fas fa-bookmark text-primary"></i>
                                                    @endif
                                                </button>
                                            @endif
                                        </div>
                                        
                                        <!-- Article Title -->
                                        <h3 class="article-title">
                                            <a href="{{url('blog/'.$row->slug)}}" title="{{$row->title}}">
                                                {{$row->title}}
                                            </a>
                                        </h3>
                                        
                                        <!-- Article Excerpt -->
                                        <p class="article-excerpt">
                                            <?php echo \Helpers::getLimitedDescription($row->description);?>
                                        </p>
                                        
                                        <!-- Article Footer -->
                                        <div class="article-footer">
                                            <a href="{{url('blog/'.$row->slug)}}" class="read-more">
                                                {{__('lang.website_read_more')}}
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($result->hasPages())
                        <div class="pagination-wrapper">
                            {{ $result->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3>{{ __("lang.site_no_articles_available") }}</h3>
                        <p>Il n'y a actuellement aucun article correspondant à vos critères.</p>
                        <a href="{{ url('/') }}" class="btn-primary">
                            Retour à l'accueil
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
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
    // Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filtersForm').submit();
        });
    });

    // Auto-submit form when sort changes
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ url("all-blogs") }}';
            
            // Add current filters
            const currentFilters = new URLSearchParams(window.location.search);
            currentFilters.set('sort', this.value);
            
            // Remove sort from URL and add to form
            currentFilters.delete('sort');
            for (let [key, value] of currentFilters) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }
            
            // Add sort value
            const sortInput = document.createElement('input');
            sortInput.type = 'hidden';
            sortInput.name = 'sort';
            sortInput.value = this.value;
            form.appendChild(sortInput);
            
            document.body.appendChild(form);
            form.submit();
        });
    }
    
    // Category navigation enhancement
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            categoryItems.forEach(cat => cat.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>

@endsection