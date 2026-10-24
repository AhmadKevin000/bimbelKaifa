/* ==========================================================================
   KAIFA Tutoring Center — landing page behaviour
   Single consolidated entry point for the public landing page.

   Everything here is progressive enhancement: the page is fully readable and
   navigable without JavaScript (see the <noscript> fallback in the navbar).
   ========================================================================== */

(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    /* ---------------------------------------------------------------------
       Sticky header shadow
       --------------------------------------------------------------------- */
    var header = document.querySelector('[data-header]');

    function syncHeader() {
        if (!header) return;
        header.dataset.scrolled = window.scrollY > 8 ? 'true' : 'false';
    }

    /* ---------------------------------------------------------------------
       Floating WhatsApp button (appears after the hero)
       --------------------------------------------------------------------- */
    var floatButton = document.querySelector('[data-float-wa]');

    function syncFloat() {
        if (!floatButton) return;
        floatButton.dataset.visible = window.scrollY > 420 ? 'true' : 'false';
    }

    /* ---------------------------------------------------------------------
       Mobile navigation drawer
       --------------------------------------------------------------------- */
    var navToggle = document.querySelector('[data-nav-toggle]');
    var navDrawer = document.querySelector('[data-nav-drawer]');
    var iconOpen = navToggle ? navToggle.querySelector('[data-nav-icon="open"]') : null;
    var iconClose = navToggle ? navToggle.querySelector('[data-nav-icon="close"]') : null;

    function isDrawerOpen() {
        return !!navDrawer && !navDrawer.hasAttribute('hidden');
    }

    function setDrawer(open) {
        if (!navToggle || !navDrawer) return;

        navDrawer.toggleAttribute('hidden', !open);
        navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        navToggle.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
        document.documentElement.classList.toggle('overflow-hidden', open);

        if (iconOpen) iconOpen.toggleAttribute('hidden', open);
        if (iconClose) iconClose.toggleAttribute('hidden', !open);
    }

    if (navToggle && navDrawer) {
        navToggle.addEventListener('click', function () {
            setDrawer(!isDrawerOpen());
        });

        // Close after choosing a destination
        navDrawer.querySelectorAll('[data-nav-link], a').forEach(function (link) {
            link.addEventListener('click', function () {
                setDrawer(false);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isDrawerOpen()) {
                setDrawer(false);
                navToggle.focus();
            }
        });

        // Clicking outside the drawer closes it
        document.addEventListener('click', function (event) {
            if (!isDrawerOpen()) return;
            if (navDrawer.contains(event.target) || navToggle.contains(event.target)) return;
            setDrawer(false);
        });

        // The drawer only exists below the lg breakpoint
        var desktop = window.matchMedia('(min-width: 1024px)');
        var onBreakpoint = function (event) {
            if (event.matches && isDrawerOpen()) setDrawer(false);
        };

        if (typeof desktop.addEventListener === 'function') {
            desktop.addEventListener('change', onBreakpoint);
        } else if (typeof desktop.addListener === 'function') {
            desktop.addListener(onBreakpoint);
        }
    }

    /* ---------------------------------------------------------------------
       Scroll listener (single rAF-throttled handler for both effects)
       --------------------------------------------------------------------- */
    var ticking = false;

    function onScroll() {
        if (ticking) return;
        ticking = true;

        window.requestAnimationFrame(function () {
            syncHeader();
            syncFloat();
            ticking = false;
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    syncHeader();
    syncFloat();

    /* ---------------------------------------------------------------------
       Reveal on scroll
       Only elements marked with [data-reveal] are affected, and the class is
       added to <html> so content stays visible when JS is unavailable.
       --------------------------------------------------------------------- */
    var revealTargets = document.querySelectorAll('[data-reveal]');

    if (revealTargets.length && 'IntersectionObserver' in window && !reduceMotion.matches) {
        document.documentElement.classList.add('js-reveal');

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                });
            },
            { rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
        );

        revealTargets.forEach(function (target) {
            observer.observe(target);
        });
    }
})();
