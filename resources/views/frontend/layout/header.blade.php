<!-- ================= COMMON SITE HEADER ================= -->
<header class="site-header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center brand-container">
            <a href="{{ url('/') }}" class="brand-link" aria-label="National Public School Home">
                <img src="{{ asset('images/National Public School Emblem.png') }}" alt="NPS Logo" class="brand-logo" onerror="this.src='{{ asset('website/images/NPS_logo.png') }}'">
                <span class="brand-text-group">
                    <span class="brand-name">National Public School</span>
                    <span class="brand-subtitle">Kempegowda Layout 7th Block</span>
                </span>
            </a>
            <span class="brand-divider"></span>
        </div>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav d-none d-md-flex" aria-label="Main navigation">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'nav-current' : '' }}">Home</a>

            <a href="{{ route('life_at_npskgl') }}" class="{{ request()->routeIs('life_at_npskgl') ? 'nav-current' : '' }}">Life at NPS KGL</a>
            <a href="{{ route('activities') }}" class="{{ request()->routeIs('activities') ? 'nav-current' : '' }}">Activities</a>

            <a href="{{ request()->is('/') ? '#admission-enquiry-box' : url('/#admission-enquiry-box') }}" class="nav-admissions">Admissions</a>
            <a href="#footer-section">Contact</a>
        </nav>

        <!-- Mobile Action Toggle -->
        <div class="mobile-actions d-md-none">
            <a href="{{ request()->is('/') ? '#admission-enquiry-box' : url('/#admission-enquiry-box') }}" class="mobile-admissions">Admissions</a>
            <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobileNav">
                <svg class="menu-icon-bars" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg class="menu-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Nav Dropdown -->
    <nav class="mobile-nav d-md-none" id="mobileNav" aria-label="Mobile navigation">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'nav-current' : '' }}">
            <span>Home</span>
            <span class="nav-arrow">&rsaquo;</span>
        </a>

        <a href="{{ route('life_at_npskgl') }}" class="{{ request()->routeIs('life_at_npskgl') ? 'nav-current' : '' }}">
            <span>Life at NPS KGL</span>
            <span class="nav-arrow">&rsaquo;</span>
        </a>

        <a href="{{ route('activities') }}" class="{{ request()->routeIs('activities') ? 'nav-current' : '' }}">
            <span>Activities</span>
            <span class="nav-arrow">&rsaquo;</span>
        </a>

        <a href="{{ request()->is('/') ? '#admission-enquiry-box' : url('/#admission-enquiry-box') }}" class="mobile-nav-admissions">
            <span>Admissions 2027-28</span>
            <span class="nav-arrow">&rsaquo;</span>
        </a>

        <a href="#footer-section">
            <span>Contact &amp; Campus Location</span>
            <span class="nav-arrow">&rsaquo;</span>
        </a>
    </nav>
</header>

<script>
    (function() {
        function initMobileNav() {
            const menuToggle = document.getElementById('menuToggle');
            const mobileNav = document.getElementById('mobileNav');
            if (!menuToggle || !mobileNav || menuToggle.dataset.npsBound === 'true') {
                return;
            }
            menuToggle.dataset.npsBound = 'true';

            function setMenuState(open) {
                mobileNav.classList.toggle('is-open', open);
                menuToggle.classList.toggle('is-active', open);
                menuToggle.setAttribute('aria-expanded', String(open));
            }

            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const willOpen = !mobileNav.classList.contains('is-open');
                setMenuState(willOpen);
            });

            mobileNav.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    setMenuState(false);
                });
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileNav.contains(e.target) && !menuToggle.contains(e.target)) {
                    if (mobileNav.classList.contains('is-open')) {
                        setMenuState(false);
                    }
                }
            });

            // Close on resize to tablet/desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768 && mobileNav.classList.contains('is-open')) {
                    setMenuState(false);
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMobileNav);
        } else {
            initMobileNav();
        }
    })();
</script>
