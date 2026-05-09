{{-- Pattern Background: Subtle Grid Lines (static, masked near cursor) --}}
{{-- Static grid: light mode (higher opacity) --}}
<div class="pointer-events-none fixed inset-0 z-0 dark:hidden"
    style="background-image: linear-gradient(rgba(161,161,170,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.07) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 140px, black 190px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 140px, black 190px);">
</div>
{{-- Static grid: dark mode (subtle opacity) --}}
<div class="pointer-events-none fixed inset-0 z-0 hidden dark:block"
    style="background-image: linear-gradient(rgba(161,161,170,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.03) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 140px, black 190px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 140px, black 190px);">
</div>

{{-- Pattern Background: Interactive Lens-Distorted Grid Lines & Chart --}}
<div class="pointer-events-none fixed inset-0 z-0" x-data="{
    canvas: null,
    ctx: null,
    width: 0,
    height: 0,
    mouseX: -1000,
    mouseY: -1000,
    gridSize: 24,
    segStep: 5,
    lensRadius: 110,
    glowRadius: 170,
    maxMagnification: 2.5,
    pendingFrame: false,

    init() {
        this.canvas = this.$refs.canvas;
        this.ctx = this.canvas.getContext('2d');
        this.resize();
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => {
            this.mouseX = e.clientX;
            this.mouseY = e.clientY;
            if (!this.pendingFrame) {
                this.pendingFrame = true;
                requestAnimationFrame(() => {
                    this.draw();
                    this.pendingFrame = false;
                });
            }
        });
        this.draw();
    },

    resize() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        const dpr = window.devicePixelRatio || 1;
        this.canvas.width = this.width * dpr;
        this.canvas.height = this.height * dpr;
        this.ctx.scale(dpr, dpr);
        this.draw();
    },


    draw() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        // --- Lens displacement helper ---
        const displace = (ox, oy) => {
            let dx = ox - this.mouseX;
            let dy = oy - this.mouseY;
            let dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < this.lensRadius && dist > 0) {
                let bf = 1 + (this.maxMagnification - 1) * Math.pow(1 - dist / this.lensRadius, 2);
                let ang = Math.atan2(dy, dx);
                return [this.mouseX + Math.cos(ang) * dist * bf, this.mouseY + Math.sin(ang) * dist * bf];
            }
            return [ox, oy];
        };

        // --- Sample a cubic bezier with lens displacement ---
        const sampledBezier = (p0, p1, p2, p3, n = 60) => {
            let pts = [];
            for (let i = 0; i <= n; i++) {
                let t = i / n,
                    mt = 1 - t;
                let x = mt * mt * mt * p0[0] + 3 * mt * mt * t * p1[0] + 3 * mt * t * t * p2[0] + t * t * t * p3[0];
                let y = mt * mt * mt * p0[1] + 3 * mt * mt * t * p1[1] + 3 * mt * t * t * p2[1] + t * t * t * p3[1];
                pts.push(displace(x, y));
            }
            return pts;
        };

        const fillShape = (pts, gradient) => {
            this.ctx.beginPath();
            pts.forEach(([x, y], i) => i === 0 ? this.ctx.moveTo(x, y) : this.ctx.lineTo(x, y));
            this.ctx.closePath();
            this.ctx.fillStyle = gradient;
            this.ctx.fill();
        };

        let isDark = document.documentElement.classList.contains('dark');
        const W = this.width,
            H = this.height;

        // --- Distorted grid lines (Circular Glow Effect) ---
        let baseOpacity = isDark ? 0.22 : 0.35;
        let colorRgb = isDark ? '185, 28, 28' : '239, 68, 68';

        // Create a single radial gradient for all lines
        let gridGrad = this.ctx.createRadialGradient(this.mouseX, this.mouseY, 0, this.mouseX, this.mouseY, this.glowRadius);
        gridGrad.addColorStop(0, `rgba(${colorRgb}, ${baseOpacity})`);
        gridGrad.addColorStop(0.6, `rgba(${colorRgb}, ${baseOpacity * 0.4})`);
        gridGrad.addColorStop(1, `rgba(${colorRgb}, 0)`);

        this.ctx.lineWidth = 1;
        this.ctx.lineCap = 'round';
        this.ctx.strokeStyle = gridGrad;

        // Draw horizontal and vertical lines in a circular-aware range
        const drawRange = this.glowRadius;

        // Horizontal lines
        let rowMin = Math.floor((this.mouseY - drawRange) / this.gridSize);
        let rowMax = Math.ceil((this.mouseY + drawRange) / this.gridSize);
        for (let row = rowMin; row <= rowMax; row++) {
            let oy = row * this.gridSize;
            this.ctx.beginPath();
            let first = true;
            for (let x = this.mouseX - drawRange; x <= this.mouseX + drawRange; x += this.segStep) {
                let [fx, fy] = displace(x, oy);
                if (first) { this.ctx.moveTo(fx, fy);
                    first = false; } else { this.ctx.lineTo(fx, fy); }
            }
            this.ctx.stroke();
        }

        // Vertical lines
        let colMin = Math.floor((this.mouseX - drawRange) / this.gridSize);
        let colMax = Math.ceil((this.mouseX + drawRange) / this.gridSize);
        for (let col = colMin; col <= colMax; col++) {
            let ox = col * this.gridSize;
            this.ctx.beginPath();
            let first = true;
            for (let y = this.mouseY - drawRange; y <= this.mouseY + drawRange; y += this.segStep) {
                let [fx, fy] = displace(ox, y);
                if (first) { this.ctx.moveTo(fx, fy);
                    first = false; } else { this.ctx.lineTo(fx, fy); }
            }
            this.ctx.stroke();
        }

        // --- Accent shapes (drawn last, on top of grid) ---
        // --- Accent 1: Large radial sweep from top-right corner ---
        let arc1pts = [displace(W, 0)];
        arc1pts = arc1pts.concat(sampledBezier([W * 0.35, 0], [W * 0.65, 0], [W, H * 0.25], [W, H * 0.65]));
        let g1 = this.ctx.createRadialGradient(W, 0, W * 0.05, W, 0, W * 0.75);
        g1.addColorStop(0, isDark ? 'rgba(35,5,5,0.95)' : 'rgba(255,242,242,0.95)');
        g1.addColorStop(0.45, isDark ? 'rgba(120,20,20,0.6)' : 'rgba(239,68,68,0.3)');
        g1.addColorStop(1, 'rgba(0,0,0,0)');
        fillShape(arc1pts, g1);

        // --- Accent 2: Sharper inner arc, top-right (adds depth) ---
        let arc2pts = [displace(W, 0)];
        arc2pts = arc2pts.concat(sampledBezier([W * 0.68, 0], [W * 0.88, 0], [W, H * 0.1], [W, H * 0.32]));
        let g2 = this.ctx.createRadialGradient(W, 0, 0, W, 0, W * 0.38);
        g2.addColorStop(0, isDark ? 'rgba(60,8,8,0.98)' : 'rgba(255,238,238,0.98)');
        g2.addColorStop(0.55, isDark ? 'rgba(160,25,25,0.55)' : 'rgba(239,68,68,0.35)');
        g2.addColorStop(1, 'rgba(0,0,0,0)');
        fillShape(arc2pts, g2);

        // --- Accent 3: Subtle counter-arc from bottom-left ---
        let arc3pts = [displace(0, H)];
        arc3pts = arc3pts.concat(sampledBezier([W * 0.28, H], [W * 0.1, H], [0, H * 0.82], [0, H * 0.55]));
        let g3 = this.ctx.createRadialGradient(0, H, 0, 0, H, H * 0.48);
        g3.addColorStop(0, isDark ? 'rgba(30,5,5,0.88)' : 'rgba(255,240,240,0.88)');
        g3.addColorStop(0.5, isDark ? 'rgba(110,18,18,0.4)' : 'rgba(239,68,68,0.2)');
        g3.addColorStop(1, 'rgba(0,0,0,0)');
        fillShape(arc3pts, g3);

    }
}">
    <canvas x-ref="canvas" class="block h-full w-full"></canvas>
</div>

{{-- Interactive Cursor Glow --}}
<div class="pointer-events-none fixed inset-0 z-0 transition duration-300"
    style="background: radial-gradient(160px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), rgba(239, 68, 68, 0.06), transparent 100%);">
</div>
