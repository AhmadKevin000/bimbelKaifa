import './bootstrap';

/* ============================================================
   KAIFA Tutoring Center - Landing Page Scripts
   ============================================================ */

// --- Testimonial Slider ---
let currentSlide = 0;
const totalSlides = 2;

function moveSlider(index) {
    currentSlide = index;
    const track = document.getElementById('slider-track');
    if (track) {
        track.style.transform = `translateX(-${index * 100}%)`;
    }

    // Update dots
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.getElementById(`dot-${i}`);
        if (dot) {
            if (i === index) {
                dot.classList.remove('bg-white/30');
                dot.classList.add('bg-white');
            } else {
                dot.classList.add('bg-white/30');
                dot.classList.remove('bg-white');
            }
        }
    }
}

// Auto play slider
setInterval(() => {
    currentSlide = (currentSlide + 1) % totalSlides;
    moveSlider(currentSlide);
}, 5000);

// Expose moveSlider globally for inline onclick attributes
window.moveSlider = moveSlider;

// --- Mobile Menu & Smooth Scrolling ---
document.addEventListener('DOMContentLoaded', () => {
    const mobileButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileButton?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('hidden');
    });

    mobileMenu?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Flip Card Logic
    document.querySelectorAll('.flip-trigger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const card = this.closest('.flip-card');
            if (card) card.classList.add('is-flipped');
        });
    });

    document.querySelectorAll('.flip-back-trigger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const card = this.closest('.flip-card');
            if (card) card.classList.remove('is-flipped');
        });
    });
});

