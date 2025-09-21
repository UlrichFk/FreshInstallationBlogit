/**
 * Header Functions - Gestion des fonctionnalités du header
 * Compatible avec le système de profil et l'application Laravel
 */

// Toggle user dropdown
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdownMenu');
    const profileMini = document.querySelector('.user-profile-mini');
    
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        profileMini.classList.remove('active');
    } else {
        // Close any other open dropdowns
        document.querySelectorAll('.user-dropdown-menu.show').forEach(d => d.classList.remove('show'));
        document.querySelectorAll('.user-profile-mini.active').forEach(p => p.classList.remove('active'));
        
        dropdown.classList.add('show');
        profileMini.classList.add('active');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const profileMini = document.querySelector('.user-profile-mini');
    const dropdown = document.getElementById('userDropdownMenu');
    
    if (!profileMini.contains(event.target)) {
        dropdown.classList.remove('show');
        profileMini.classList.remove('active');
    }
});

// Toggle mobile menu
function toggleMobileMenu() {
    const mobileNav = document.getElementById('mobile-nav');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    mobileNav.classList.toggle('active');
    mobileToggle.classList.toggle('active');
    
    // Prevent body scroll when mobile menu is open
    if (mobileNav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Toggle mobile submenu
function toggleMobileSubmenu(button) {
    const submenu = button.parentElement.nextElementSibling;
    const icon = button.querySelector('i');
    
    submenu.classList.toggle('active');
    
    if (submenu.classList.contains('active')) {
        icon.style.transform = 'rotate(180deg)';
    } else {
        icon.style.transform = 'rotate(0deg)';
    }
}

// Header scroll behavior
let lastScrollTop = 0;
const header = document.querySelector('.site-header');

window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 60) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
    
    lastScrollTop = scrollTop;
});

// Search functionality
function openSearch() {
    // Implement search functionality
    console.log('Search opened');
    
    // Create search overlay
    const searchOverlay = document.createElement('div');
    searchOverlay.className = 'search-overlay';
    searchOverlay.innerHTML = `
        <div class="search-container">
            <div class="search-header">
                <h3>Rechercher</h3>
                <button onclick="closeSearch()" class="search-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="search-form">
                <input type="text" placeholder="Rechercher des articles..." class="search-input">
                <button class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="search-results">
                <!-- Results will be populated here -->
            </div>
        </div>
    `;
    
    document.body.appendChild(searchOverlay);
    
    // Focus on search input
    setTimeout(() => {
        searchOverlay.querySelector('.search-input').focus();
    }, 100);
}

// Close search
function closeSearch() {
    const searchOverlay = document.querySelector('.search-overlay');
    if (searchOverlay) {
        searchOverlay.remove();
    }
}

// Initialize header functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add keyboard navigation support
    document.addEventListener('keydown', function(event) {
        // ESC key closes dropdowns and mobile menu
        if (event.key === 'Escape') {
            const dropdown = document.querySelector('.user-dropdown-menu.show');
            const mobileNav = document.querySelector('.mobile-nav.active');
            
            if (dropdown) {
                dropdown.classList.remove('show');
                document.querySelector('.user-profile-mini').classList.remove('active');
            }
            
            if (mobileNav) {
                toggleMobileMenu();
            }
        }
    });
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Export functions for global use
window.toggleUserDropdown = toggleUserDropdown;
window.toggleMobileMenu = toggleMobileMenu;
window.toggleMobileSubmenu = toggleMobileSubmenu;
window.openSearch = openSearch;
window.closeSearch = closeSearch; 