/**
 * Goal: Company profile page — Lenis smooth scroll + GSAP ScrollTrigger animations
 * Caller: resources/views/company.blade.php
 * Deps: lenis, gsap, gsap/ScrollTrigger
 */

import Lenis from "lenis";
import "lenis/dist/lenis.css";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;


/* ─────────────────────────────────────
   1. Lenis Smooth Scroll
   ───────────────────────────────────── */
const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
).matches;

let lenis = null;

function initLenis() {
    if (prefersReducedMotion) return;

    lenis = new Lenis({
        lerp: 0.07,
        orientation: "vertical",
        gestureOrientation: "vertical",
        smoothWheel: true,
        autoRaf: false, // we control RAF for GSAP sync
    });

    // Sync Lenis scroll position with GSAP ScrollTrigger
    lenis.on("scroll", ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);
}

/* ─────────────────────────────────────
   2. Navbar scroll behavior
   ───────────────────────────────────── */
function initNavbar() {
    const navbar = document.querySelector(".cp-navbar");
    if (!navbar) return;

    let lastScroll = 0;

    ScrollTrigger.create({
        trigger: document.body,
        start: "top top",
        end: "bottom bottom",
        onUpdate: (self) => {
            const currentScroll = self.scroll();

            // Add scrolled class after 100px
            if (currentScroll > 100) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }

            // The navbar should remain visible at all times, so we no longer hide it on scroll down.

            lastScroll = currentScroll;
        },
    });

    // Detect Active Section for Navbar Theme
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        ScrollTrigger.create({
            trigger: section,
            start: "top 80px",
            end: "bottom 80px",
            onEnter: () => updateNavTheme(section),
            onEnterBack: () => updateNavTheme(section),
        });
    });

    function updateNavTheme(section) {
        // If the section is the parallax slideshow, use white theme. Otherwise, red theme.
        const isParallax = section.classList.contains('cp-slideshow-section') || section.id === 'services';
        const theme = isParallax ? 'white' : 'red';
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: theme }));
    }

    // Smooth scroll anchor navigation
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = anchor.getAttribute("href");
            const target = document.querySelector(targetId);
            if (target) {
                if (lenis) {
                    lenis.scrollTo(target, { offset: -80 });
                } else {
                    target.scrollIntoView({ behavior: "smooth" });
                }
                // Close mobile menu
                const mobileMenu = document.querySelector(".cp-mobile-menu");
                if (mobileMenu) mobileMenu.classList.remove("active");
            }
        });
    });

    // Mobile hamburger
    const hamburger = document.querySelector(".cp-hamburger");
    const mobileMenu = document.querySelector(".cp-mobile-menu");
    const mobileClose = document.querySelector(".cp-mobile-close");

    if (hamburger && mobileMenu) {
        hamburger.addEventListener("click", () =>
            mobileMenu.classList.add("active")
        );
    }
    if (mobileClose && mobileMenu) {
        mobileClose.addEventListener("click", () =>
            mobileMenu.classList.remove("active")
        );
    }
}

/* ─────────────────────────────────────
   3. Hero animations
   ───────────────────────────────────── */
function initHeroAnimations() {
    // Parallax hero background image
    const heroImg = document.querySelector(".cp-hero-bg img");
    if (heroImg) {
        gsap.to(heroImg, {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: ".cp-hero",
                start: "top top",
                end: "bottom top",
                scrub: true,
            },
        });
    }

    // Mouse interactivity parallax
    let mouseX = 0;
    let mouseY = 0;
    let targetMouseX = 0;
    let targetMouseY = 0;

    window.addEventListener("mousemove", (e) => {
        // Normalized cursor coordinates: from -0.5 to 0.5
        targetMouseX = (e.clientX / window.innerWidth) - 0.5;
        targetMouseY = (e.clientY / window.innerHeight) - 0.5;
    });

    // Smoothly interpolate mouse coordinates (inertia)
    gsap.ticker.add(() => {
        mouseX += (targetMouseX - mouseX) * 0.05;
        mouseY += (targetMouseY - mouseY) * 0.05;
    });

    // Floating scatter cards - 3D Image Cloud (Only initialized on screen widths >= 768px)
    if (window.innerWidth >= 768) {
        const count = 18;
        const cardsData = [];

        // Distribute cards evenly in a 3D cylinder/shell surrounding the central text
        for (let i = 0; i < count; i++) {
            // Even angular spacing around the Y-axis
            const theta = (i * Math.PI * 2) / count;
            
            // Radius range (pushed further outward to prevent center crowding)
            const radius = gsap.utils.random(450, 750);
            
            // Height distribution: top, middle, and bottom bands
            const y = gsap.utils.random(-320, 320);
            
            const baseX = Math.cos(theta) * radius;
            const baseZ = Math.sin(theta) * radius;
            const rotationDirection = gsap.utils.random([-1, 1]);

            cardsData.push({
                selector: `.cp-scatter-card-${i + 1}`,
                x: baseX,
                y: y,
                z: baseZ,
                radius: radius,
                theta: theta,
                baseScale: gsap.utils.random(0.65, 0.8), // tightness for balanced proportions
                rotationDirection: rotationDirection,
                introProgress: { value: 0 }
            });
        }

        // Animate each card's intro burst staggered over time
        cardsData.forEach((data, index) => {
            gsap.to(data.introProgress, {
                value: 1,
                duration: 2.8,
                ease: "power3.out",
                delay: index * 0.12
            });
        });

        // Track scroll progress for radial dispersion
        let scrollProgress = 0;
        let targetScrollProgress = 0;
        window.addEventListener("scroll", () => {
            const hero = document.getElementById("hero");
            if (hero) {
                const rect = hero.getBoundingClientRect();
                const scrolled = window.scrollY;
                const heroHeight = rect.height || window.innerHeight;
                targetScrollProgress = gsap.utils.clamp(0, 1, scrolled / heroHeight);
            }
        }, { passive: true });

        // Wrap the render logic in a function to allow pausing
        const renderCards = () => {
            // Smooth scroll interpolation (eliminates jitter & handles sudden teleports)
            scrollProgress += (targetScrollProgress - scrollProgress) * 0.1;

            // Slow Y-axis (horizontal carousel) rotation angle
            const angleY = gsap.ticker.time * 0.05;
            const cosY = Math.cos(angleY);
            const sinY = Math.sin(angleY);

            cardsData.forEach((data, index) => {
                const card = document.querySelector(data.selector);
                if (!card) return;

                const ip = data.introProgress.value;

                // 1. Rotate base coordinates horizontally around Y-axis
                let x1 = data.x * cosY - data.z * sinY;
                let z2 = data.x * sinY + data.z * cosY;
                let y1 = data.y;

                // 2. Add organic floating wobbles
                const time = gsap.ticker.time;
                const floatX = Math.sin(time * 0.5 + index) * 8;
                const floatY = Math.cos(time * 0.4 + index) * 15;

                // 3. Scroll dispersion (radial explosion) based on depth speed multiplier
                const angle2D = Math.atan2(y1, x1);
                const depthMultiplier = 0.3 + ((z2 + 750) / 1500) * 1.5; // foreground items move much faster
                const disperseRadius = scrollProgress * 1800 * depthMultiplier;

                const finalX = x1 + Math.cos(angle2D) * disperseRadius;
                const finalY = y1 + Math.sin(angle2D) * disperseRadius;

                // 4. Perspective Projection: camera distance f
                const f = 750;
                const scaleProjected = f / Math.max(50, f - z2);

                // Center projection on screen and add mouse move offset
                const screenX = finalX * scaleProjected + (mouseX * 45 * depthMultiplier) + floatX;
                const screenY = finalY * scaleProjected + (mouseY * 45 * depthMultiplier) + floatY;
                // Clamp the final projected scale so images don't get too large
                const projectedScale = gsap.utils.clamp(0.4, 1.1, data.baseScale * scaleProjected);

                // 5. Visual depth effects (progressive fading for background items)
                let opacity = 1.0;
                if (z2 < -150) {
                    // Fade out as it goes further back (max 80% fade)
                    opacity = 1.0 - gsap.utils.clamp(0, 0.8, (-z2 - 150) / 500);
                }

                // 6. Straight-line projection interpolation (0 at center to 1 at target positions)
                const curX = screenX * ip;
                const curY = screenY * ip;
                const curScale = projectedScale * ip;
                const curOpacity = opacity * ip;

                // 7. Tornado spin decay
                const initialSpin = (1 - ip) * 720 * data.rotationDirection;
                const stableRot = Math.sin(time * 0.3 + index) * 8; // gentle float wobble rotation
                const currentRotation = initialSpin + stableRot;

                // Apply styles
                gsap.set(card, {
                    left: "50vw",
                    top: "50vh",
                    xPercent: -50,
                    yPercent: -50,
                    x: curX,
                    y: curY,
                    scale: curScale,
                    opacity: curOpacity,
                    zIndex: Math.round(z2 + 1000), // foreground items layer on top
                    position: "absolute"
                });
            });
        };

        // Use IntersectionObserver to pause the 3D ticker when hero is out of view
        const heroNode = document.getElementById("hero");
        if (heroNode) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        gsap.ticker.add(renderCards);
                    } else {
                        gsap.ticker.remove(renderCards);
                    }
                });
            }, { threshold: 0 }); // Trigger as soon as any part is visible
            
            observer.observe(heroNode);
        }
    }

    // Fade in tagline and meta
    gsap.fromTo(
        ".cp-hero-tagline",
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 1, ease: "power2.out", delay: 0.8 }
    );

    gsap.fromTo(
        ".cp-hero-meta",
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 1, ease: "power2.out", delay: 1 }
    );

    gsap.fromTo(
        ".cp-hero-scroll-indicator",
        { opacity: 0 },
        { opacity: 1, duration: 1, delay: 1.5 }
    );
}

/* ─────────────────────────────────────
   4. Generic scroll-triggered reveals
   ───────────────────────────────────── */
function initScrollReveals() {
    // Fade-up reveals
    gsap.utils.toArray(".cp-reveal").forEach((el) => {
        gsap.to(el, {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: el,
                start: "top 88%",
                toggleActions: "play none none none",
            },
        });
    });

    // Fade-left reveals
    gsap.utils.toArray(".cp-reveal-left").forEach((el) => {
        gsap.to(el, {
            opacity: 1,
            x: 0,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: el,
                start: "top 88%",
                toggleActions: "play none none none",
            },
        });
    });

    // Fade-right reveals
    gsap.utils.toArray(".cp-reveal-right").forEach((el) => {
        gsap.to(el, {
            opacity: 1,
            x: 0,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: el,
                start: "top 88%",
                toggleActions: "play none none none",
            },
        });
    });

    // Scale reveals
    gsap.utils.toArray(".cp-reveal-scale").forEach((el) => {
        gsap.to(el, {
            opacity: 1,
            scale: 1,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: el,
                start: "top 88%",
                toggleActions: "play none none none",
            },
        });
    });

    // Stagger reveal groups
    gsap.utils.toArray("[data-stagger-parent]").forEach((parent) => {
        const children = parent.querySelectorAll("[data-stagger-child]");
        gsap.fromTo(
            children,
            { opacity: 0, y: 30 },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.12,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: parent,
                    start: "top 85%",
                    toggleActions: "play none none none",
                },
            }
        );
    });

    // Divider line animations
    gsap.utils.toArray(".cp-divider").forEach((el) => {
        gsap.fromTo(
            el,
            { scaleX: 0 },
            {
                scaleX: 1,
                duration: 1.2,
                ease: "power2.inOut",
                scrollTrigger: {
                    trigger: el,
                    start: "top 90%",
                    toggleActions: "play none none none",
                },
            }
        );
    });
}

/* ─────────────────────────────────────
   5. Counter animation
   ───────────────────────────────────── */
function initCounters() {
    gsap.utils.toArray("[data-counter]").forEach((el) => {
        const target = parseInt(el.dataset.counter, 10);
        const suffix = el.dataset.counterSuffix || "";
        const obj = { val: 0 };

        gsap.to(obj, {
            val: target,
            duration: 2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: el,
                start: "top 85%",
                toggleActions: "play none none none",
            },
            onUpdate: () => {
                el.textContent = Math.round(obj.val) + suffix;
            },
        });
    });
}

/* ─────────────────────────────────────
   6. Interactive Pinned Stacking Slideshow
   ───────────────────────────────────── */
function initInteractiveSlideshow() {
    const section = document.querySelector(".cp-slideshow-section");
    if (!section) return;

    const slides = gsap.utils.toArray(".cp-slide");
    if (slides.length <= 1) return;

    const contents = gsap.utils.toArray(".cp-slide-content");

    // Initialize slides for Curtain Reveal: they stack statically, all slides after slide 1 are hidden from bottom
    gsap.set(slides.slice(1), { clipPath: "inset(100% 0% 0% 0%)", yPercent: 0 });
    gsap.set(slides[0], { clipPath: "inset(0% 0% 0% 0%)", yPercent: 0 });

    // Set initial staggered states for static pinned text sub-elements with custom clip-paths
    if (contents.length > 0) {
        contents.forEach((content, i) => {
            const indicator = content.querySelector(".cp-slide-indicator");
            const badge = content.querySelector(".cp-slide-badge");
            const title = content.querySelector(".cp-slide-title");
            const btn = content.querySelector(".cp-slide-btn");

            if (i === 0) {
                if (indicator) gsap.set(indicator, { opacity: 1, y: 0, autoAlpha: 1 });
                if (badge) gsap.set(badge, { opacity: 1, x: 0, autoAlpha: 1, clipPath: "inset(0% 0% 0% 0%)" });
                if (title) gsap.set(title, { opacity: 1, y: 0, autoAlpha: 1, clipPath: "inset(0% 0% 0% 0%)" });
                if (btn) gsap.set(btn, { opacity: 1, x: 0, autoAlpha: 1, clipPath: "inset(0% 0% 0% 0%)" });
                gsap.set(content, { opacity: 1, autoAlpha: 1 });
            } else {
                if (indicator) gsap.set(indicator, { opacity: 0, y: 15, autoAlpha: 0 });
                if (badge) gsap.set(badge, { opacity: 0, x: -40, autoAlpha: 0, clipPath: "inset(0% 100% 0% 0%)" });
                if (title) gsap.set(title, { opacity: 0, y: -50, autoAlpha: 0, clipPath: "inset(0% 0% 100% 0%)" });
                if (btn) gsap.set(btn, { opacity: 0, x: -40, autoAlpha: 0, clipPath: "inset(0% 100% 0% 0%)" });
                gsap.set(content, { opacity: 0, autoAlpha: 0 });
            }
        });
    }

    // Create primary pinned timeline with relaxed scrub (1.2s) and doubled scroll distance (200% per slide)
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: section,
            start: "top top",
            end: `+=${(slides.length - 1) * 100}%`, // Further reduced for lighter, faster scroll effort
            pin: true,
            scrub: true, // Tied directly to scroll to prevent trailing jitter during rapid anchor navigation
        }
    });

    // Define absolute start times for transitions to eliminate all dead zones
    // We stretch the transition duration to 1.3, so they are perfectly back-to-back:
    // 0.0 -> 1.3 -> 2.6 -> 3.9
    const startTimes = [0.0, 1.3, 2.6];

    // Animate each slide reveal using curtain-like clipPath inset
    slides.slice(1).forEach((slide, index) => {
        const label = `slide-${index}`;
        const startTime = startTimes[index];

        // Add the label at absolute timestamp
        tl.addLabel(label, startTime);

        const prevBgWrap = slides[index].querySelector(".cp-slide-bg-wrap");
        const nextBgWrap = slide.querySelector(".cp-slide-bg-wrap");

        // 1. Reveal slide from bottom to top (inset(100% 0 0 0) -> inset(0 0 0 0))
        tl.fromTo(slide,
            { clipPath: "inset(100% 0% 0% 0%)" },
            {
                clipPath: "inset(0% 0% 0% 0%)",
                ease: "none",
                duration: 1.3
            },
            label
        );

        // 2. Parallax Depth: Incoming background shifts UP from below with high momentum
        if (nextBgWrap) {
            tl.fromTo(nextBgWrap,
                { yPercent: 60 },
                { yPercent: 0, ease: "none", duration: 1.3 },
                label
            );
        }

        // 3. Parallax Depth: Outgoing background gets pushed UP by incoming with high momentum
        if (prevBgWrap) {
            tl.fromTo(prevBgWrap,
                { yPercent: 0 },
                { yPercent: -60, ease: "none", duration: 1.3 },
                label
            );
        }

        // 4. Add luxury organic depth with gentle zoom on the background image
        const bg = slide.querySelector(".cp-slide-bg");
        if (bg) {
            tl.fromTo(bg,
                { scale: 1.12 },
                { scale: 1.05, ease: "none", duration: 1.3 },
                label
            );
        }

        // 3. Slide-Out current active text sub-elements in REVERSE order (btn -> title -> badge -> indicator)
        if (contents[index]) {
            const prevIndicator = contents[index].querySelector(".cp-slide-indicator");
            const prevBadge = contents[index].querySelector(".cp-slide-badge");
            const prevTitle = contents[index].querySelector(".cp-slide-title");
            const prevBtn = contents[index].querySelector(".cp-slide-btn");

            if (prevBtn) {
                tl.to(prevBtn, {
                    opacity: 0,
                    x: -40,
                    clipPath: "inset(0% 100% 0% 0%)",
                    autoAlpha: 0,
                    ease: "power3.in",
                    duration: 0.3
                }, label);
            }

            if (prevTitle) {
                tl.to(prevTitle, {
                    opacity: 0,
                    y: -50,
                    clipPath: "inset(0% 0% 100% 0%)",
                    autoAlpha: 0,
                    ease: "power3.in",
                    duration: 0.3
                }, `${label}+=0.06`);
            }

            if (prevBadge) {
                tl.to(prevBadge, {
                    opacity: 0,
                    x: -40,
                    clipPath: "inset(0% 100% 0% 0%)",
                    autoAlpha: 0,
                    ease: "power3.in",
                    duration: 0.3
                }, `${label}+=0.12`);
            }

            if (prevIndicator) {
                tl.to(prevIndicator, {
                    opacity: 0,
                    y: -15,
                    autoAlpha: 0,
                    ease: "power3.in",
                    duration: 0.3
                }, `${label}+=0.18`);
            }

            tl.to(contents[index], {
                opacity: 0,
                autoAlpha: 0,
                duration: 0.3
            }, `${label}+=0.15`);
        }

        // 4. Slide-In next text sub-elements in staggered sequence (NORMAL order: indicator -> badge -> title -> btn)
        if (contents[index + 1]) {
            const nextIndicator = contents[index + 1].querySelector(".cp-slide-indicator");
            const nextBadge = contents[index + 1].querySelector(".cp-slide-badge");
            const nextTitle = contents[index + 1].querySelector(".cp-slide-title");
            const nextBtn = contents[index + 1].querySelector(".cp-slide-btn");

            // Make the container active just before text reveals
            tl.to(contents[index + 1], {
                opacity: 1,
                autoAlpha: 1,
                duration: 0.1
            }, `${label}+=0.42`);

            if (nextIndicator) {
                tl.fromTo(nextIndicator,
                    { opacity: 0, y: 15, autoAlpha: 0 },
                    {
                        opacity: 1,
                        y: 0,
                        autoAlpha: 1,
                        ease: "power3.out",
                        duration: 0.4
                    },
                    `${label}+=0.42`
                );
            }

            if (nextBadge) {
                tl.fromTo(nextBadge,
                    { opacity: 0, x: -40, clipPath: "inset(0% 100% 0% 0%)", autoAlpha: 0 },
                    {
                        opacity: 1,
                        x: 0,
                        clipPath: "inset(0% 0% 0% 0%)",
                        autoAlpha: 1,
                        ease: "power3.out",
                        duration: 0.4
                    },
                    `${label}+=0.48`
                );
            }

            if (nextTitle) {
                tl.fromTo(nextTitle,
                    { opacity: 0, y: -50, clipPath: "inset(0% 0% 100% 0%)", autoAlpha: 0 },
                    {
                        opacity: 1,
                        y: 0,
                        clipPath: "inset(0% 0% 0% 0%)",
                        autoAlpha: 1,
                        ease: "power3.out",
                        duration: 0.4
                    },
                    `${label}+=0.56`
                );
            }

            if (nextBtn) {
                tl.fromTo(nextBtn,
                    { opacity: 0, x: -40, clipPath: "inset(0% 100% 0% 0%)", autoAlpha: 0 },
                    {
                        opacity: 1,
                        x: 0,
                        clipPath: "inset(0% 0% 0% 0%)",
                        autoAlpha: 1,
                        ease: "power3.out",
                        duration: 0.4
                    },
                    `${label}+=0.64`
                );
            }
        }
    });

    // 5. Animate Slide Progress Bars synchronized with scrub timeline
    if (contents[0]) {
        const prog0 = contents[0].querySelector('.cp-slide-progress');
        if (prog0) tl.fromTo(prog0, { scaleX: 0 }, { scaleX: 1, ease: "none", duration: 0.5 }, 0);
    }
    
    slides.slice(1).forEach((slide, index) => {
        const content = contents[index + 1];
        if (content) {
            const prog = content.querySelector('.cp-slide-progress');
            if (prog) {
                const textStartTime = startTimes[index] + 0.42;
                const nextStartTime = startTimes[index + 1] ? startTimes[index + 1] : 3.9;
                const duration = nextStartTime - textStartTime;
                
                tl.fromTo(prog, { scaleX: 0 }, { scaleX: 1, ease: "none", duration: duration }, textStartTime);
            }
        }
    });

    // Removed final static buffer entirely so unpin happens instantly and seamlessly
}

/* ─────────────────────────────────────
   7. Staggered Portfolio Showcase Parallax
   ───────────────────────────────────── */
function initStaggeredShowcase() {
    const staggeredItems = gsap.utils.toArray(".cp-staggered-item");
    if (!staggeredItems.length) return;

    staggeredItems.forEach(item => {
        const speed = parseFloat(item.dataset.scrollSpeed) || 0.05;
        const imgWrap = item.querySelector(".cp-staggered-img-wrap");
        const img = item.querySelector(".cp-staggered-img-wrap img");
        const text = item.querySelector(".mt-5");

        // 1. Dramatic ClipPath Reveal for the image container
        if (imgWrap) {
            gsap.fromTo(imgWrap,
                { clipPath: "inset(100% 0% 0% 0%)" },
                {
                    clipPath: "inset(0% 0% 0% 0%)",
                    duration: 1.2,
                    ease: "power3.inOut",
                    scrollTrigger: {
                        trigger: item,
                        start: "top 85%",
                        toggleActions: "play reverse play reverse"
                    }
                }
            );
        }

        // 2. Text fade and slide up with delay
        if (text) {
            gsap.fromTo(text,
                { opacity: 0, y: 30 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: "power2.out",
                    delay: 0.2, // slightly delayed after image
                    scrollTrigger: {
                        trigger: item,
                        start: "top 85%",
                        toggleActions: "play reverse play reverse"
                    }
                }
            );
        }

        // 3. Parallax scroll on individual images (inner image movement)
        if (img) {
            gsap.fromTo(img,
                { yPercent: -8 },
                {
                    yPercent: 8,
                    ease: "none",
                    scrollTrigger: {
                        trigger: item,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true
                    }
                }
            );
        }

        // Parallax glide shift on the card itself for larger screen widths
        if (window.innerWidth >= 768) {
            gsap.to(item, {
                y: () => -window.innerHeight * speed,
                ease: "none",
                scrollTrigger: {
                    trigger: item,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            });
        }
    });
}

/* ─────────────────────────────────────
   8. Parallax images
   ───────────────────────────────────── */
function initParallax() {
    gsap.utils.toArray(".cp-parallax-img").forEach((img) => {
        gsap.fromTo(
            img,
            { yPercent: -10 },
            {
                yPercent: 10,
                ease: "none",
                scrollTrigger: {
                    trigger: img.closest(".cp-parallax-wrap") || img,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true,
                },
            }
        );
    });
}

/* ─────────────────────────────────────
   9. Timeline animation
   ───────────────────────────────────── */
function initTimeline() {
    gsap.utils.toArray(".cp-timeline-item").forEach((item, i) => {
        gsap.fromTo(
            item,
            { opacity: 0, y: 40 },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: item,
                    start: "top 85%",
                    toggleActions: "play none none none",
                },
            }
        );
    });
}

/* ─────────────────────────────────────
   10. Technical Drawing SVG Draw-In
   ───────────────────────────────────── */
function initFooterDrawing() {
    const drawing = document.querySelector(".cp-footer-drawing");
    if (!drawing) return;

    const paths = drawing.querySelectorAll("path, rect, line, circle");
    paths.forEach(path => {
        const length = path.getTotalLength();
        gsap.set(path, {
            strokeDasharray: length,
            strokeDashoffset: length
        });
        
        gsap.to(path, {
            strokeDashoffset: 0,
            duration: 2.5,
            ease: "power1.inOut",
            scrollTrigger: {
                trigger: drawing,
                start: "top 85%",
                toggleActions: "play none none none"
            }
        });
    });
}

/* ─────────────────────────────────────
   INIT
   ───────────────────────────────────── */
document.addEventListener("DOMContentLoaded", () => {
    initLenis();
    initNavbar();
    initHeroAnimations();
    initScrollReveals();
    initCounters();
    initInteractiveSlideshow();
    initStaggeredShowcase();
    initParallax();
    initTimeline();
    initFooterDrawing();
});
