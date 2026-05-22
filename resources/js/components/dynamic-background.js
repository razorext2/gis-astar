/** Goal: Alpine.js component for ultra-lightweight CSS Masking and Canvas 2D hybrid background, Caller: dynamic-background.blade.php, Deps: Alpine.js */
document.addEventListener("alpine:init", () => {
    Alpine.data("dynamicBackground", () => ({
        quality: "high",
        canvas2d: null,
        ctx: null,
        width: 0,
        height: 0,
        isTabVisible: true,
        _abortController: null,
        _resizeTimer: null,
        _bgCache: null,
        _themeObserver: null,

        init() {
            const prefersReducedMotion = window.matchMedia(
                "(prefers-reduced-motion: reduce)",
            ).matches;
            const isLowHardware =
                navigator.hardwareConcurrency &&
                navigator.hardwareConcurrency < 4;
            const isMobile =
                window.matchMedia("(pointer: coarse)").matches ||
                /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

            if (prefersReducedMotion || isLowHardware) {
                this.quality = "low";
            } else if (isMobile) {
                this.quality = "medium";
            } else {
                this.quality = "high";
            }

            // Observe dark mode toggle to invalidate accent shape cache
            this._themeObserver = new MutationObserver(() => {
                this._bgCache = null;
                this.draw();
            });
            this._themeObserver.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ["class"],
            });

            this.canvas2d = this.$refs.canvas2d;
            this.ctx = this.canvas2d.getContext("2d");

            // AbortController for centralized event listener cleanup
            this._abortController = new AbortController();
            const signal = this._abortController.signal;

            // Page Visibility API
            document.addEventListener(
                "visibilitychange",
                () => {
                    this.isTabVisible = !document.hidden;
                    if (this.isTabVisible) {
                        this.draw();
                    }
                },
                { signal },
            );

            // Debounced resize handler
            window.addEventListener(
                "resize",
                () => {
                    clearTimeout(this._resizeTimer);
                    this._resizeTimer = setTimeout(() => this.resize(), 150);
                },
                { signal },
            );

            // Light-weight mousemove handler to update CSS variables for CSS masking
            window.addEventListener(
                "mousemove",
                (e) => {
                    if (!this.isTabVisible || this.quality === "low" || !this.dynamicBg) return;

                    this.$el.style.setProperty("--mouse-x", e.clientX + "px");
                    this.$el.style.setProperty("--mouse-y", e.clientY + "px");
                },
                { passive: true, signal },
            );

            this.resize();
        },

        resize() {
            this.width = window.innerWidth;
            this.height = window.innerHeight;

            let dpr = window.devicePixelRatio || 1;
            if (this.quality === "medium") {
                dpr = Math.min(dpr, 1.25);
            } else if (this.quality === "low") {
                dpr = 1.0;
            }

            if (this.canvas2d) {
                this.canvas2d.width = this.width * dpr;
                this.canvas2d.height = this.height * dpr;
                this.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.ctx.scale(dpr, dpr);
            }

            this._bgCache = null;
            this.draw();
        },

        draw() {
            if (!this.isTabVisible) return;
            this.draw2D();
        },

        destroy() {
            if (this._abortController) {
                this._abortController.abort();
                this._abortController = null;
            }
            if (this._themeObserver) {
                this._themeObserver.disconnect();
                this._themeObserver = null;
            }
            clearTimeout(this._resizeTimer);
            this._bgCache = null;
        },

        _buildBgCache() {
            const W = this.width,
                H = this.height;
            if (!W || !H) return;

            const offscreen = document.createElement("canvas");
            offscreen.width = W;
            offscreen.height = H;
            const ox = offscreen.getContext("2d");

            const nSteps =
                this.quality === "low"
                    ? 15
                    : this.quality === "medium"
                      ? 20
                      : 60;

            const sampledBezier = (p0, p1, p2, p3, n = nSteps) => {
                let pts = [];
                for (let i = 0; i <= n; i++) {
                    let t = i / n,
                        mt = 1 - t;
                    pts.push([
                        mt * mt * mt * p0[0] +
                            3 * mt * mt * t * p1[0] +
                            3 * mt * t * t * p2[0] +
                            t * t * t * p3[0],
                        mt * mt * mt * p0[1] +
                            3 * mt * mt * t * p1[1] +
                            3 * mt * t * t * p2[1] +
                            t * t * t * p3[1],
                    ]);
                }
                return pts;
            };

            const fillShape = (pts, gradient) => {
                ox.beginPath();
                pts.forEach(([x, y], i) =>
                    i === 0 ? ox.moveTo(x, y) : ox.lineTo(x, y),
                );
                ox.closePath();
                ox.fillStyle = gradient;
                ox.fill();
            };

            const isDark = document.documentElement.classList.contains("dark");

            // --- Accent 1: Large radial sweep from top-right corner ---
            let arc1pts = [[W, 0]];
            arc1pts = arc1pts.concat(
                sampledBezier(
                    [W * 0.35, 0],
                    [W * 0.65, 0],
                    [W, H * 0.25],
                    [W, H * 0.65],
                ),
            );
            let g1 = ox.createRadialGradient(W, 0, W * 0.05, W, 0, W * 0.75);
            g1.addColorStop(
                0,
                isDark ? "rgba(35,5,5,0.95)" : "rgba(255,242,242,0.95)",
            );
            g1.addColorStop(
                0.45,
                isDark ? "rgba(120,20,20,0.6)" : "rgba(239,68,68,0.3)",
            );
            g1.addColorStop(1, "rgba(0,0,0,0)");
            fillShape(arc1pts, g1);

            // --- Accent 2: Sharper inner arc, top-right ---
            let arc2pts = [[W, 0]];
            arc2pts = arc2pts.concat(
                sampledBezier(
                    [W * 0.68, 0],
                    [W * 0.88, 0],
                    [W, H * 0.1],
                    [W, H * 0.32],
                ),
            );
            let g2 = ox.createRadialGradient(W, 0, 0, W, 0, W * 0.38);
            g2.addColorStop(
                0,
                isDark ? "rgba(60,8,8,0.98)" : "rgba(255,238,238,0.98)",
            );
            g2.addColorStop(
                0.55,
                isDark ? "rgba(160,25,25,0.55)" : "rgba(239,68,68,0.35)",
            );
            g2.addColorStop(1, "rgba(0,0,0,0)");
            fillShape(arc2pts, g2);

            // --- Accent 3: Subtle counter-arc from bottom-left ---
            let arc3pts = [[0, H]];
            arc3pts = arc3pts.concat(
                sampledBezier(
                    [W * 0.28, H],
                    [W * 0.1, H],
                    [0, H * 0.82],
                    [0, H * 0.55],
                ),
            );
            let g3 = ox.createRadialGradient(0, H, 0, 0, H, H * 0.48);
            g3.addColorStop(
                0,
                isDark ? "rgba(30,5,5,0.88)" : "rgba(255,240,240,0.88)",
            );
            g3.addColorStop(
                0.5,
                isDark ? "rgba(110,18,18,0.4)" : "rgba(239,68,68,0.2)",
            );
            g3.addColorStop(1, "rgba(0,0,0,0)");
            fillShape(arc3pts, g3);

            this._bgCache = offscreen;
        },

        draw2D() {
            if (!this.ctx) return;
            this.ctx.clearRect(0, 0, this.width, this.height);

            if (!this._bgCache) {
                this._buildBgCache();
            }

            if (this._bgCache) {
                this.ctx.drawImage(this._bgCache, 0, 0);
            }
        },
    }));
});
