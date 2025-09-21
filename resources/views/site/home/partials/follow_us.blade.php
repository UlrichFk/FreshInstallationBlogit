@php $social = \Helpers::getSocialMedias(6); @endphp
@if(isset($social) && count($social))
<div class="sidebar-widget social-widget">
    <div class="widget-header">
        <h3 class="widget-title">
            <i class="fas fa-share-alt"></i>
            Suivez-nous
        </h3>
    </div>
    
    <div class="widget-content">
        <div class="social-list">
            @foreach($social as $index => $social_data)
                <a href="{{$social_data->url}}" target="_blank" class="social-item" title="{{$social_data->name}}">
                    <div class="social-icon">
                        <i class="fa {{$social_data->icon}}"></i>
                    </div>
                    <div class="social-content">
                        <span class="social-name">{{$social_data->name}}</span>
                        <span class="social-arrow">
                            <i class="fas fa-external-link-alt"></i>
                        </span>
                    </div>
                </a>
            @endforeach            
        </div>
        
    </div>
</div>

<style>
/* Social Widget Styles - Cohérent avec le style des autres widgets */
.social-widget .social-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.social-item {
    display: flex;
    gap: var(--space-3);
    align-items: center;
    padding: var(--space-3);
    border-radius: var(--radius-lg);
    transition: var(--transition-fast);
    position: relative;
    text-decoration: none;
    background: transparent;
    border: 1px solid transparent;
}

.social-item:hover {
    background: var(--card-bg-light);
    transform: translateX(5px);
    border-color: var(--accent-color);
}

.social-icon {
    width: 45px;
    height: 45px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--transition-fast);
    position: relative;
    overflow: hidden;
}

.social-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: var(--gradient-accent); */
    opacity: 0.9;
    transition: var(--transition-fast);
}

.social-icon i {
    color: white;
    font-size: 1.1rem;
    position: relative;
    z-index: 2;
    transition: var(--transition-fast);
}

.social-item:hover .social-icon::before {
    opacity: 1;
    transform: scale(1.1);
}

.social-item:hover .social-icon i {
    transform: scale(1.1);
}

.social-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-width: 0;
}

.social-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition-fast);
    text-transform: capitalize;
}

.social-item:hover .social-name {
    color: var(--accent-color);
}

.social-arrow {
    color: var(--text-muted);
    font-size: 0.8rem;
    opacity: 0.7;
    transition: var(--transition-fast);
}

.social-item:hover .social-arrow {
    opacity: 1;
    color: var(--accent-color);
    transform: translateX(3px);
}

/* Styles spécifiques pour les réseaux sociaux populaires */
.social-item[title*="Facebook"] .social-icon::before {
    background: linear-gradient(135deg, #1877f2, #0d6efd);
}

.social-item[title*="Twitter"] .social-icon::before,
.social-item[title*="X"] .social-icon::before {
    background: linear-gradient(135deg, #1da1f2, #0ea5e9);
}

.social-item[title*="Instagram"] .social-icon::before {
    background: linear-gradient(135deg, #e4405f, #f77737);
}

.social-item[title*="YouTube"] .social-icon::before {
    background: linear-gradient(135deg, #ff0000, #dc2626);
}

.social-item[title*="LinkedIn"] .social-icon::before {
    background: linear-gradient(135deg, #0077b5, #0ea5e9);
}

.social-item[title*="TikTok"] .social-icon::before {
    background: linear-gradient(135deg, #000000, #333333);
}

.social-item[title*="Telegram"] .social-icon::before {
    background: linear-gradient(135deg, #0088cc, #0ea5e9);
}

.social-item[title*="WhatsApp"] .social-icon::before {
    background: linear-gradient(135deg, #25d366, #16a34a);
}

.social-item[title*="Discord"] .social-icon::before {
    background: linear-gradient(135deg, #5865f2, #7289da);
}

.social-item[title*="Reddit"] .social-icon::before {
    background: linear-gradient(135deg, #ff4500, #ff6b35);
}

.social-item[title*="Snapchat"] .social-icon::before {
    background: linear-gradient(135deg, #fffc00, #ffd700);
}

.social-item[title*="Pinterest"] .social-icon::before {
    background: linear-gradient(135deg, #bd081c, #dc2626);
}

/* Responsive */
@media (max-width: 768px) {
    .social-item {
        padding: var(--space-2);
    }
    
    .social-icon {
        width: 40px;
        height: 40px;
    }
    
    .social-name {
        font-size: 0.85rem;
    }
}
</style>@endif
