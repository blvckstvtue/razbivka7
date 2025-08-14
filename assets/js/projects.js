// ===== PROJECTS PAGE SCRIPT =====

document.addEventListener('DOMContentLoaded', function() {
    initializeProjectModals();
    initializeProjectFilters();
    initializeProjectAnimations();
});

// ===== PROJECT MODALS =====
function initializeProjectModals() {
    const modals = document.querySelectorAll('.project-modal');
    
    // Close modal when clicking overlay
    modals.forEach(modal => {
        const overlay = modal.querySelector('.modal-overlay');
        const closeBtn = modal.querySelector('.modal-close');
        
        if (overlay) {
            overlay.addEventListener('click', () => {
                closeProjectModal(modal.id.replace('modal-', ''));
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                closeProjectModal(modal.id.replace('modal-', ''));
            });
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.project-modal.active');
            if (activeModal) {
                closeProjectModal(activeModal.id.replace('modal-', ''));
            }
        }
    });
    
    // Prevent body scroll when modal is open
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                const modal = mutation.target;
                if (modal.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    // Check if any modal is still active
                    const anyActiveModal = document.querySelector('.project-modal.active');
                    if (!anyActiveModal) {
                        document.body.style.overflow = '';
                    }
                }
            }
        });
    });
    
    modals.forEach(modal => {
        observer.observe(modal, { attributes: true });
    });
}

// Open project modal
function openProjectModal(projectId) {
    const modal = document.getElementById(`modal-${projectId}`);
    if (modal) {
        modal.classList.add('active');
        
        // Animate modal content
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.animation = 'modalSlideIn 0.3s ease';
        }
        
        // Focus management for accessibility
        const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (firstFocusable) {
            firstFocusable.focus();
        }
    }
}

// Close project modal
function closeProjectModal(projectId) {
    const modal = document.getElementById(`modal-${projectId}`);
    if (modal) {
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.animation = 'modalSlideOut 0.3s ease';
            setTimeout(() => {
                modal.classList.remove('active');
                modalContent.style.animation = '';
            }, 300);
        } else {
            modal.classList.remove('active');
        }
    }
}

// ===== PROJECT FILTERS =====
function initializeProjectFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    
    // Add click animation to filter buttons
    filterButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Remove active class from all buttons
            filterButtons.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            btn.classList.add('active');
            
            // Add click ripple effect
            createRippleEffect(e, btn);
        });
    });
}

// Create ripple effect
function createRippleEffect(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    `;
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    // Remove ripple after animation
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// ===== PROJECT ANIMATIONS =====
function initializeProjectAnimations() {
    // Animate project cards on scroll
    const projectCards = document.querySelectorAll('.project-card');
    
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                }, index * 100); // Stagger animation
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });
    
    projectCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        cardObserver.observe(card);
    });
    
    // Animate tech tags
    const techTags = document.querySelectorAll('.tech-tag');
    techTags.forEach((tag, index) => {
        tag.addEventListener('mouseenter', () => {
            tag.style.animation = 'techTagPulse 0.3s ease';
        });
        
        tag.addEventListener('animationend', () => {
            tag.style.animation = '';
        });
    });
    
    // Animate project images on hover
    const projectImages = document.querySelectorAll('.project-image');
    projectImages.forEach(image => {
        image.addEventListener('mouseenter', () => {
            const img = image.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.1) rotate(2deg)';
            }
        });
        
        image.addEventListener('mouseleave', () => {
            const img = image.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });
}

// ===== SEARCH FUNCTIONALITY =====
function initializeProjectSearch() {
    const searchInput = document.getElementById('project-search');
    if (!searchInput) return;
    
    const projectCards = document.querySelectorAll('.project-card');
    
    searchInput.addEventListener('input', debounce((e) => {
        const searchTerm = e.target.value.toLowerCase();
        
        projectCards.forEach(card => {
            const title = card.querySelector('.project-title').textContent.toLowerCase();
            const description = card.querySelector('.project-description').textContent.toLowerCase();
            const category = card.querySelector('.project-category').textContent.toLowerCase();
            const techTags = Array.from(card.querySelectorAll('.tech-tag')).map(tag => tag.textContent.toLowerCase());
            
            const matches = title.includes(searchTerm) || 
                          description.includes(searchTerm) || 
                          category.includes(searchTerm) ||
                          techTags.some(tech => tech.includes(searchTerm));
            
            if (matches) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.3s ease';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        const visibleCards = Array.from(projectCards).filter(card => card.style.display !== 'none');
        let noResultsMsg = document.querySelector('.no-search-results');
        
        if (visibleCards.length === 0 && searchTerm.trim() !== '') {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-search-results';
                noResultsMsg.innerHTML = `
                    <div class="no-projects">
                        <div class="no-projects-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Няма намерени резултати</h3>
                        <p>Не са намерени проекти за "${searchTerm}"</p>
                    </div>
                `;
                document.querySelector('.projects-grid').appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }, 300));
}

// ===== LAZY LOADING FOR IMAGES =====
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => {
        imageObserver.observe(img);
    });
}

// ===== PROJECT SHARING =====
function shareProject(projectId, projectTitle) {
    if (navigator.share) {
        navigator.share({
            title: projectTitle,
            text: `Разгледайте този проект от LionDevs: ${projectTitle}`,
            url: `${window.location.origin}${window.location.pathname}#project-${projectId}`
        });
    } else {
        // Fallback to copying URL
        const url = `${window.location.origin}${window.location.pathname}#project-${projectId}`;
        navigator.clipboard.writeText(url).then(() => {
            showNotification('Линкът е копиран в клипборда!', 'success');
        });
    }
}

// ===== UTILITY FUNCTIONS =====

// Debounce function (if not already defined in main script)
if (typeof debounce === 'undefined') {
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Show notification (if not already defined in main script)
if (typeof showNotification === 'undefined') {
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}"></i>
            <span>${message}</span>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: var(--background-light);
            color: var(--text-primary);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            border-left: 4px solid var(--${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'}-color);
            box-shadow: var(--shadow-lg);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Add additional CSS animations
const projectStyle = document.createElement('style');
projectStyle.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes techTagPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes modalSlideOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
    }
    
    .project-image img {
        transition: transform 0.4s ease;
    }
    
    .loaded {
        opacity: 1 !important;
    }
    
    img[data-src] {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .no-search-results {
        grid-column: 1 / -1;
        margin: 2rem 0;
    }
`;
document.head.appendChild(projectStyle);

// Initialize additional features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeProjectSearch();
    initializeLazyLoading();
    
    // Add keyboard navigation for project cards
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach((card, index) => {
        card.setAttribute('tabindex', '0');
        
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const detailsBtn = card.querySelector('.action-btn');
                if (detailsBtn) {
                    detailsBtn.click();
                }
            }
        });
    });
    
    // Add smooth scroll to top after filter change
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            setTimeout(() => {
                document.querySelector('.projects-section').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        });
    });
});