/**
 * ============================================================
 * KAIFA Bimbel — Interactive System Tour (Driver.js)
 * ============================================================
 *
 * Provides:
 *  - startSystemTour()      → runs the 12-step guided tour
 *  - showOnboardingModal()  → first-login welcome modal
 *  - markTourCompleted()    → persists completion to backend
 *
 * Selector strategy:
 *  We resolve sidebar navigation items by their visible text
 *  label, then assign a temporary `id` for Driver.js to target.
 *  This avoids brittle CSS selectors that break on Filament
 *  version upgrades.
 * ============================================================
 */

(function () {
    'use strict';

    /* ----------------------------------------------------------
     * HELPERS
     * ---------------------------------------------------------- */

    /**
     * Find a sidebar navigation link by its visible label text
     * and assign it a stable `id` so Driver.js can target it.
     */
    function resolveSidebarItem(labelText, tempId) {
        // Filament sidebar: <a ...> <span>LabelText</span> </a>
        const links = document.querySelectorAll(
            'nav a, [class*="sidebar"] a, aside a, [class*="fi-sidebar"] a'
        );

        for (const link of links) {
            const span = link.querySelector('span');
            const text = (span ? span.textContent : link.textContent).trim();
            if (text === labelText) {
                link.id = tempId;
                return '#' + tempId;
            }
        }
        return null;
    }

    /**
     * Find a widget card on the dashboard by partial text content.
     */
    function resolveWidgetByText(text, tempId) {
        const widgets = document.querySelectorAll(
            '[class*="widget"], [class*="stat"], [class*="card"]'
        );
        for (const w of widgets) {
            if (w.textContent.includes(text)) {
                w.id = tempId;
                return '#' + tempId;
            }
        }
        return null;
    }

    /* ----------------------------------------------------------
     * TOUR STEPS
     * ---------------------------------------------------------- */

    function buildTourSteps() {
        const steps = [];

        const menuMap = [
            { label: 'Guru',           id: 'tour-menu-guru',      title: '👨‍🏫 Data Guru',        desc: 'Tambahkan data guru yang akan mengajar pada bimbingan belajar.' },
            { label: 'Kelas',          id: 'tour-menu-kelas',     title: '🏫 Data Kelas',        desc: 'Buat kelas yang akan digunakan untuk mengelompokkan siswa.' },
            { label: 'Mata Pelajaran', id: 'tour-menu-mapel',     title: '📖 Mata Pelajaran',    desc: 'Kelola daftar mata pelajaran yang tersedia pada bimbel.' },
            { label: 'Siswa',          id: 'tour-menu-siswa',     title: '🎓 Data Siswa',        desc: 'Tambahkan siswa dan tempatkan pada kelas yang sesuai.' },
            { label: 'Kelola Sesi',    id: 'tour-menu-sesi',      title: '📅 Kelola Sesi',       desc: 'Buat jadwal mengajar dan tentukan guru, kelas, serta mata pelajaran.' },
            { label: 'Kehadiran',      id: 'tour-menu-kehadiran', title: '✅ Kehadiran',          desc: 'Kelola kehadiran guru dan siswa dalam satu alur yang terintegrasi.' },
            { label: 'Rapor',          id: 'tour-menu-rapor',     title: '📝 Rapor',       desc: 'Input nilai dan hasil belajar siswa untuk setiap mata pelajaran.' },
            { label: 'Tarif SPP',      id: 'tour-menu-spp',       title: '💰 Tarif SPP',         desc: 'Tentukan tarif pembayaran siswa berdasarkan program dan jenjang.' },
            { label: 'Tarif Gaji',     id: 'tour-menu-gaji',      title: '💵 Tarif Gaji',        desc: 'Atur tarif honor guru yang digunakan untuk perhitungan gaji otomatis.' },
            { label: 'Arus Kas',       id: 'tour-menu-kas',       title: '🏦 Arus Kas',          desc: 'Semua pemasukan dan pengeluaran akan tercatat secara otomatis pada menu ini.' },
        ];

        for (const item of menuMap) {
            const selector = resolveSidebarItem(item.label, item.id);
            if (selector) {
                steps.push({
                    element: selector,
                    popover: {
                        title: item.title,
                        description: item.desc,
                        side: 'right',
                        align: 'start',
                    },
                });
            }
        }

        // Dashboard stats widget
        const statsSelector = resolveWidgetByText('Total Guru', 'tour-widget-stats');
        if (statsSelector) {
            steps.push({
                element: statsSelector,
                popover: {
                    title: '📊 Statistik Dashboard',
                    description: 'Dashboard menampilkan ringkasan data penting secara real-time.',
                    side: 'bottom',
                    align: 'center',
                },
            });
        }

        // Kelas Hari Ini widget
        const kelasSelector = resolveWidgetByText('Kelas Hari Ini', 'tour-widget-kelas');
        if (kelasSelector) {
            steps.push({
                element: kelasSelector,
                popover: {
                    title: '📋 Kelas Hari Ini',
                    description: 'Lihat seluruh jadwal kelas yang berlangsung pada hari ini.',
                    side: 'top',
                    align: 'center',
                },
            });
        }

        return steps;
    }

    /* ----------------------------------------------------------
     * MARK TOUR AS COMPLETED (AJAX)
     * ---------------------------------------------------------- */

    function markTourCompleted() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) return;

        fetch('/admin/tour/complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({}),
        }).catch(function () {
            // silently fail — not critical
        });
    }

    /* ----------------------------------------------------------
     * START SYSTEM TOUR
     * ---------------------------------------------------------- */

    function startSystemTour() {
        if (typeof window.driver === 'undefined' || !window.driver.js) {
            console.warn('[Tour] Driver.js is not loaded yet.');
            return;
        }

        const { driver } = window.driver.js;

        const steps = buildTourSteps();

        if (steps.length === 0) {
            alert('Tidak dapat menemukan menu navigasi. Pastikan sidebar terbuka.');
            return;
        }

        const tourDriver = driver({
            showProgress: true,
            animate: true,
            smoothScroll: true,
            allowClose: true,
            overlayColor: 'rgba(15, 23, 42, 0.75)',
            stagePadding: 8,
            stageRadius: 12,
            popoverClass: 'kaifa-tour-popover',
            nextBtnText: 'Lanjut →',
            prevBtnText: '← Kembali',
            doneBtnText: 'Selesai ✓',
            progressText: '{{current}} dari {{total}}',
            steps: steps,
            onDestroyStarted: function () {
                // Show final popup
                if (tourDriver.isLastStep() || !tourDriver.hasNextStep()) {
                    showCompletionModal();
                    markTourCompleted();
                }
                tourDriver.destroy();
            },
        });

        tourDriver.drive();
    }

    /* ----------------------------------------------------------
     * COMPLETION MODAL
     * ---------------------------------------------------------- */

    function showCompletionModal() {
        // Remove existing
        const existing = document.getElementById('tour-completion-overlay');
        if (existing) existing.remove();

        const overlay = document.createElement('div');
        overlay.id = 'tour-completion-overlay';
        overlay.style.cssText = 'position:fixed;inset:0;z-index:100000;display:flex;align-items:center;justify-content:center;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);animation:tourFadeIn .3s ease;';

        overlay.innerHTML = `
            <div style="background:#fff;border-radius:1.25rem;padding:2.5rem;max-width:420px;width:90%;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);animation:tourSlideUp .4s ease;">
                <div style="font-size:3.5rem;margin-bottom:0.75rem;">🎉</div>
                <h2 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0 0 0.5rem;">Panduan Selesai!</h2>
                <p style="font-size:0.9rem;color:#64748b;line-height:1.6;margin:0 0 1.75rem;">
                    Anda telah mempelajari alur dasar penggunaan sistem bimbel.
                    Anda siap untuk mulai mengelola data!
                </p>
                <button onclick="this.closest('#tour-completion-overlay').remove();"
                    style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 2rem;border-radius:0.75rem;background:linear-gradient(135deg,#4364F7 0%,#6FB1FC 100%);color:#fff;font-size:0.9rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(67,100,247,.35);transition:all .2s ease;">
                    🚀 Mulai Menggunakan Sistem
                </button>
            </div>
        `;

        document.body.appendChild(overlay);
    }

    /* ----------------------------------------------------------
     * ONBOARDING MODAL (First-Login)
     * ---------------------------------------------------------- */

    function showOnboardingModal() {
        const overlay = document.createElement('div');
        overlay.id = 'tour-onboarding-overlay';
        overlay.style.cssText = 'position:fixed;inset:0;z-index:100000;display:flex;align-items:center;justify-content:center;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);animation:tourFadeIn .3s ease;';

        overlay.innerHTML = `
            <div style="background:#fff;border-radius:1.25rem;padding:2.5rem;max-width:460px;width:90%;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);animation:tourSlideUp .4s ease;">
                <div style="font-size:3.5rem;margin-bottom:0.75rem;">👋</div>
                <h2 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0 0 0.5rem;">Selamat Datang di Sistem Bimbel</h2>
                <p style="font-size:0.9rem;color:#64748b;line-height:1.6;margin:0 0 1.75rem;">
                    Sistem akan membantu Anda mengelola siswa, guru, jadwal,
                    absensi, rapor, dan keuangan secara terintegrasi.
                </p>
                <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
                    <button id="tour-onboarding-start"
                        style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;border-radius:0.75rem;background:linear-gradient(135deg,#4364F7 0%,#6FB1FC 100%);color:#fff;font-size:0.9rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(67,100,247,.35);transition:all .2s ease;">
                        🚀 Mulai Panduan
                    </button>
                    <button id="tour-onboarding-skip"
                        style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;border-radius:0.75rem;background:#f1f5f9;color:#475569;font-size:0.9rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;transition:all .2s ease;">
                        Nanti Saja
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(overlay);

        document.getElementById('tour-onboarding-start').addEventListener('click', function () {
            overlay.remove();
            // Small delay to let modal animation finish
            setTimeout(function () {
                startSystemTour();
            }, 400);
        });

        document.getElementById('tour-onboarding-skip').addEventListener('click', function () {
            overlay.remove();
            markTourCompleted();
        });
    }

    /* ----------------------------------------------------------
     * INJECT CSS ANIMATIONS
     * ---------------------------------------------------------- */

    function injectTourStyles() {
        if (document.getElementById('tour-custom-styles')) return;

        const style = document.createElement('style');
        style.id = 'tour-custom-styles';
        style.textContent = `
            @keyframes tourFadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes tourSlideUp {
                from { opacity: 0; transform: translateY(20px) scale(0.96); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }

            /* Driver.js popover customization */
            .kaifa-tour-popover {
                border-radius: 1rem !important;
                box-shadow: 0 20px 40px -8px rgba(0,0,0,0.2) !important;
            }
            .kaifa-tour-popover .driver-popover-title {
                font-size: 1rem !important;
                font-weight: 700 !important;
            }
            .kaifa-tour-popover .driver-popover-description {
                font-size: 0.875rem !important;
                color: #475569 !important;
                line-height: 1.5 !important;
            }
            .kaifa-tour-popover .driver-popover-progress-text {
                font-size: 0.75rem !important;
                color: #94a3b8 !important;
            }
            .kaifa-tour-popover .driver-popover-next-btn,
            .kaifa-tour-popover .driver-popover-prev-btn {
                border-radius: 0.5rem !important;
                font-weight: 600 !important;
                font-size: 0.82rem !important;
                padding: 0.4rem 1rem !important;
                text-shadow: none !important;
            }
            .kaifa-tour-popover .driver-popover-next-btn {
                background: linear-gradient(135deg, #4364F7, #6FB1FC) !important;
                color: #fff !important;
                border: none !important;
            }
        `;
        document.head.appendChild(style);
    }

    /* ----------------------------------------------------------
     * AUTO-INIT ON PAGE LOAD
     * ---------------------------------------------------------- */

    function init() {
        injectTourStyles();

        // Check if we're on the admin dashboard
        const isDashboard = window.location.pathname === '/admin'
            || window.location.pathname === '/admin/'
            || window.location.pathname.endsWith('/admin');

        const tourCompletedAttr = document.body.getAttribute('data-tour-completed');
        const tourCompleted = tourCompletedAttr === '1' || tourCompletedAttr === 'true';

        if (isDashboard && !tourCompleted) {
            // Wait a moment for sidebar to render
            setTimeout(function () {
                showOnboardingModal();
            }, 1200);
        }
    }

    // Expose globally
    window.startSystemTour = startSystemTour;
    window.showOnboardingModal = showOnboardingModal;

    // Init when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
