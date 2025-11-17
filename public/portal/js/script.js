// Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initSidebar();
    initUserDropdown();
    initMobileResponsive();
    
    // Add smooth scrolling
    document.documentElement.style.scrollBehavior = 'smooth';
});

// Sidebar functionality
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const mainContent = document.querySelector('.main-content');
    
    // Mobile sidebar toggle
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
        });
    }
    
    // Desktop sidebar toggle (if needed)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 991.98) {
            if (!sidebar.contains(e.target) && !mobileSidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991.98) {
            sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
        }
    });
}



// User dropdown functionality
function initUserDropdown() {
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userDropdownToggle && userDropdown) {
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdownToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    }
}

// Mobile responsive functionality
function initMobileResponsive() {
    // Handle touch events for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const sidebar = document.getElementById('sidebar');
        const swipeThreshold = 50;
        
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swipe left - close sidebar
            if (window.innerWidth <= 991.98) {
                sidebar.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        } else if (touchEndX > touchStartX + swipeThreshold) {
            // Swipe right - open sidebar
            if (window.innerWidth <= 991.98) {
                sidebar.classList.add('show');
                document.body.classList.add('sidebar-open');
            }
        }
    }
}

$(document).on('click','.sidebar-header',function(){
    window.location.href = '/';
});