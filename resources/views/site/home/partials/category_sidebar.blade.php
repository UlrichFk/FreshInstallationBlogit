@php 
    $categories = \App\Models\Category::where('status', 1)
        ->take(6)
        ->get();
    
    // Ajouter le nombre de blogs pour chaque catégorie
    foreach($categories as $category) {
        $category->blogs_count = \App\Models\BlogCategory::where('category_id', $category->id)->count();
    }
    
    // Trier par nombre de blogs (décroissant)
    $categories = $categories->sortByDesc('blogs_count');
@endphp

@if(isset($categories) && count($categories))
<div class="sidebar-widget category-widget">
    <div class="widget-header">
        <h3 class="widget-title">
            <i class="fas fa-th-large"></i>
            Catégories
        </h3>
    </div>
    
    <div class="widget-content">
        <div class="categories-list">
            @foreach($categories as $index => $category)
                @if($category && $category->slug)
                    <a href="{{url('category/'.$category->slug)}}" class="category-item" title="{{$category->name}}">
                @else
                    <span class="category-item disabled">
                @endif
                    <div class="category-icon">
                        @php
                            $categoryIcons = [
                                'management' => 'fas fa-briefcase',
                                'loi' => 'fas fa-balance-scale',
                                'humanitaires' => 'fas fa-hands-helping',
                                'sécurité' => 'fas fa-shield-alt',
                                'travail' => 'fas fa-hammer',
                                'politique' => 'fas fa-landmark',
                                'économie' => 'fas fa-chart-line',
                                'société' => 'fas fa-users',
                                'international' => 'fas fa-globe',
                                'actualité' => 'fas fa-newspaper'
                            ];
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
                        <span class="category-name">{{$category->name}}</span>
                        <span class="category-count">{{$category->blogs_count}} articles</span>
                        <div class="category-progress">
                            <div class="progress-bar" style="width: {{min(($category->blogs_count / 50) * 100, 100)}}%"></div>
                        </div>
                    </div>
                    
                    <div class="category-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                @if($category && $category->slug)
                    </a>
                @else
                    </span>
                @endif
            @endforeach        
        </div>
        
        {{-- <div class="widget-footer">
            <a href="{{url('all-blogs')}}" class="explore-all-btn">
                <i class="fas fa-compass"></i>
                Explorer toutes les catégories
            </a>
        </div> --}}
    </div>
</div>

<style>
/* Category Widget Styles */
.category-widget .categories-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.category-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    text-decoration: none;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.category-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: var(--transition-normal);
}

.category-item:hover::before {
    left: 100%;
}

.category-item:hover {
    transform: translateX(8px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-lg);
    background: var(--card-bg);
}

.category-icon {
    width: 45px;
    height: 45px;
    background: var(--gradient-accent);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: white;
    flex-shrink: 0;
    transition: var(--transition-normal);
    position: relative;
}

.category-item:hover .category-icon {
    transform: scale(1.1);
    box-shadow: var(--shadow-md);
}

.category-icon::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-full);
    transform: translate(-50%, -50%);
    transition: var(--transition-fast);
}

.category-item:hover .category-icon::after {
    width: 100%;
    height: 100%;
}

.category-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    min-width: 0;
}

.category-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1rem;
    line-height: 1.2;
}

.category-count {
    color: var(--text-secondary);
    font-size: 0.85rem;
    opacity: 0.8;
}

.category-progress {
    width: 100%;
    height: 3px;
    background: var(--border-color);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-top: var(--space-1);
}

.progress-bar {
    height: 100%;
    background: var(--gradient-accent);
    border-radius: var(--radius-full);
    transition: var(--transition-normal);
    position: relative;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: progressShine 2s infinite;
}

@keyframes progressShine {
    0% { left: -100%; }
    100% { left: 100%; }
}

.category-arrow {
    color: var(--accent-color);
    font-size: 1rem;
    transition: var(--transition-fast);
    flex-shrink: 0;
    opacity: 0.7;
}

.category-item:hover .category-arrow {
    transform: translateX(5px);
    opacity: 1;
}

.explore-all-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-4) var(--space-5);
    background: transparent;
    color: var(--accent-color);
    text-decoration: none;
    border: 2px solid var(--accent-color);
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition-fast);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: var(--space-2);
}

.explore-all-btn:hover {
    background: var(--accent-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Category specific icon colors */
.category-item:nth-child(1) .category-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.category-item:nth-child(2) .category-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.category-item:nth-child(3) .category-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.category-item:nth-child(4) .category-icon {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.category-item:nth-child(5) .category-icon {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

.category-item:nth-child(6) .category-icon {
    background: linear-gradient(135deg, #34495e, #2c3e50);
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-item {
        padding: var(--space-3);
        gap: var(--space-3);
    }
    
    .category-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .category-name {
        font-size: 0.95rem;
    }
    
    .category-count {
        font-size: 0.8rem;
    }
    
    .explore-all-btn {
        padding: var(--space-3) var(--space-4);
        font-size: 0.85rem;
    }
}

/* Animation for category loading */
.category-item {
    animation: categorySlideIn 0.6s ease-out;
    animation-fill-mode: both;
}

.category-item:nth-child(1) { animation-delay: 0.1s; }
.category-item:nth-child(2) { animation-delay: 0.2s; }
.category-item:nth-child(3) { animation-delay: 0.3s; }
.category-item:nth-child(4) { animation-delay: 0.4s; }
.category-item:nth-child(5) { animation-delay: 0.5s; }
.category-item:nth-child(6) { animation-delay: 0.6s; }

@keyframes categorySlideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Subtle pulse animation for icons */
@keyframes iconPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.category-icon {
    animation: iconPulse 4s infinite;
}

.category-item:nth-child(even) .category-icon {
    animation-delay: 2s;
}
</style>
@endif