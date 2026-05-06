{{-- Pattern Background: Subtle Dots --}}
<div class="pointer-events-none fixed inset-0 z-0"
    style="background-image: radial-gradient(rgba(161, 161, 170, 0.15) 1.5px, transparent 1.5px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 160px, black 200px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 160px, black 200px);">
</div>

{{-- Pattern Background: Interactive Convex Camera Lens (Fish-eye) & Chart --}}
<div class="pointer-events-none fixed inset-0 z-0" x-data="{
    canvas: null,
    ctx: null,
    width: 0,
    height: 0,
    mouseX: -1000,
    mouseY: -1000,
    gridSize: 24,
    baseDotSize: 1.5,
    lensRadius: 100,
    glowRadius: 150,
    maxMagnification: 2,
    pendingFrame: false,
    chartPoints: [],

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
        this.chartPoints = [];
        this.draw();
    },

    getChartPoints() {
        let points = [];
        points.push({ x: 100, y: 0 });
        points.push({ x: 100, y: 100 });
        points.push({ x: 0, y: 100 });

        const addCurve = (p0, p1, p2, p3) => {
            const steps = 50;
            for (let i = 1; i <= steps; i++) {
                let t = i / steps;
                let mt = 1 - t;
                let mt2 = mt * mt;
                let mt3 = mt2 * mt;
                let t2 = t * t;
                let t3 = t2 * t;

                let x = mt3 * p0.x + 3 * mt2 * t * p1.x + 3 * mt * t2 * p2.x + t3 * p3.x;
                let y = mt3 * p0.y + 3 * mt2 * t * p1.y + 3 * mt * t2 * p2.y + t3 * p3.y;
                points.push({ x: x, y: y });
            }
        };

        addCurve({ x: 0, y: 100 }, { x: 20, y: 100 }, { x: 45, y: 99 }, { x: 58, y: 92 });
        addCurve({ x: 58, y: 92 }, { x: 68, y: 86 }, { x: 75, y: 72 }, { x: 82, y: 55 });
        addCurve({ x: 82, y: 55 }, { x: 88, y: 40 }, { x: 92, y: 20 }, { x: 100, y: 0 });

        return points.map(p => ({
            origX: (p.x / 100) * this.width,
            origY: (p.y / 100) * this.height
        }));
    },

    draw() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        if (this.chartPoints.length === 0) {
            this.chartPoints = this.getChartPoints();
        }

        this.ctx.beginPath();
        for (let i = 0; i < this.chartPoints.length; i++) {
            let p = this.chartPoints[i];
            let px = p.origX;
            let py = p.origY;

            let dx = px - this.mouseX;
            let dy = py - this.mouseY;
            let dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < this.lensRadius && dist > 0) {
                let nd = dist / this.lensRadius;
                let A = this.maxMagnification - 1;
                let bulgeFactor = 1 + A * Math.pow(1 - nd, 2);

                let newDist = dist * bulgeFactor;
                let angle = Math.atan2(dy, dx);

                px = this.mouseX + Math.cos(angle) * newDist;
                py = this.mouseY + Math.sin(angle) * newDist;
            }

            if (i === 0) this.ctx.moveTo(px, py);
            else this.ctx.lineTo(px, py);
        }
        this.ctx.closePath();

        let isDark = document.documentElement.classList.contains('dark');
        let grad = this.ctx.createLinearGradient(0, 0, 0, this.height);
        if (isDark) {
            grad.addColorStop(0, 'rgba(127, 29, 29, 0.4)');
            grad.addColorStop(1, 'rgba(153, 27, 27, 0.12)');
        } else {
            grad.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
            grad.addColorStop(1, 'rgba(252, 165, 165, 0.1)');
        }
        this.ctx.fillStyle = grad;
        this.ctx.fill();

        for (let c = Math.floor((this.mouseX - this.glowRadius) / this.gridSize); c <= Math.ceil((this.mouseX + this.glowRadius) / this.gridSize); c++) {
            for (let r = Math.floor((this.mouseY - this.glowRadius) / this.gridSize); r <= Math.ceil((this.mouseY + this.glowRadius) / this.gridSize); r++) {
                let ox = c * this.gridSize + (this.gridSize / 2);
                let oy = r * this.gridSize + (this.gridSize / 2);
                let dx = ox - this.mouseX;
                let dy = oy - this.mouseY;
                let dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < this.glowRadius) {
                    let finalX = ox,
                        finalY = oy,
                        dotSize = this.baseDotSize;
                    if (dist < this.lensRadius && dist > 0) {
                        let nd = dist / this.lensRadius;
                        let bulgeFactor = 1 + (this.maxMagnification - 1) * Math.pow(1 - nd, 2);
                        finalX = this.mouseX + Math.cos(Math.atan2(dy, dx)) * (dist * bulgeFactor);
                        finalY = this.mouseY + Math.sin(Math.atan2(dy, dx)) * (dist * bulgeFactor);
                        dotSize = this.baseDotSize * bulgeFactor;
                    }
                    let opacity = 0.8 * Math.pow(Math.max(0, 1 - (dist / this.glowRadius)), 1.2);
                    this.ctx.fillStyle = `rgba(239, 68, 68, ${opacity})`;
                    this.ctx.beginPath();
                    this.ctx.arc(finalX, finalY, dotSize, 0, Math.PI * 2);
                    this.ctx.fill();
                }
            }
        }
    }
}">
    <canvas x-ref="canvas" class="block h-full w-full"></canvas>
</div>

{{-- Interactive Cursor Glow --}}
<div class="pointer-events-none fixed inset-0 z-0 transition duration-300"
    style="background: radial-gradient(160px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), rgba(239, 68, 68, 0.06), transparent 100%);">
</div>
