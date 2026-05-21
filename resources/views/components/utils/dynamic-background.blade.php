{{-- Goal: GPU-accelerated lens distorted interactive background using WebGL + 2D Canvas hybrid rendering, Livewire: None, Alpine: dynamic-background --}}
{{-- Pattern Background: Subtle Grid Lines (static, masked near cursor) --}}
{{-- Static grid: light mode (higher opacity) --}}
<div class="pointer-events-none absolute inset-0 dark:hidden"
    style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden; background-image: linear-gradient(rgba(161,161,170,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.07) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
</div>
{{-- Static grid: dark mode (subtle opacity) --}}
<div class="pointer-events-none absolute inset-0 hidden dark:block"
    style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden; background-image: linear-gradient(rgba(161,161,170,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.03) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
</div>

{{-- Pattern Background: Interactive Lens-Distorted Grid Lines & Chart --}}
<div id="dynamic-bg-container" class="pointer-events-none fixed inset-0 z-0 overflow-hidden" style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;" x-data="{
    quality: 'high',
    canvasGl: null,
    canvas2d: null,
    gl: null,
    ctx: null,
    program: null,
    width: 0,
    height: 0,
    mouseX: -1000,
    mouseY: -1000,
    gridSize: 24,
    lensRadius: 110,
    glowRadius: 170,
    maxMagnification: 2.5,
    pendingFrame: false,
    uLoc: {},
    isTabVisible: true,
    lastFrameTime: 0,
    slowFramesCount: 0,
    lensRadiusSq: 12100,
    oneOverLensRadius: 1/110,
    maxMagMinusOne: 1.5,

    init() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const isLowHardware = navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4;
        const isMobile = window.matchMedia('(pointer: coarse)').matches || /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

        if (prefersReducedMotion || isLowHardware) {
            this.quality = 'low';
        } else if (isMobile) {
            this.quality = 'medium';
        } else {
            this.quality = 'high';
        }

        // Cache precalculated values
        this.lensRadiusSq = this.lensRadius * this.lensRadius;
        this.oneOverLensRadius = 1 / this.lensRadius;
        this.maxMagMinusOne = this.maxMagnification - 1;

        this.canvasGl = this.$refs.canvasGl;
        this.canvas2d = this.$refs.canvas2d;
        this.ctx = this.canvas2d.getContext('2d');

        // Page Visibility API
        document.addEventListener('visibilitychange', () => {
            this.isTabVisible = !document.hidden;
            if (this.isTabVisible) {
                this.lastFrameTime = 0;
                this.draw();
            }
        });

        // Skip WebGL if quality is low
        if (this.quality === 'low') {
            this.resize();
            window.addEventListener('resize', () => this.resize());
            return;
        }

        const gl = this.canvasGl.getContext('webgl', { alpha: true, antialias: false, premultipliedAlpha: false });
        if (!gl) {
            console.warn('WebGL not supported, falling back to 2D');
            this.quality = 'low';
            this.resize();
            window.addEventListener('resize', () => this.resize());
            return;
        }
        this.gl = gl;

        const vsSource = `
            attribute vec2 position;
            void main() {
                gl_Position = vec4(position, 0.0, 1.0);
            }
        `;

        const fsSource = `
            precision mediump float;
            uniform vec2 u_resolution;
            uniform vec2 u_mouse;
            uniform float u_dpr;
            uniform float u_grid_size;
            uniform float u_lens_radius;
            uniform float u_glow_radius;
            uniform float u_magnification;
            uniform vec3 u_grid_color;
            uniform float u_base_opacity;

            void main() {
                vec2 st = gl_FragCoord.xy;
                vec2 mouse = vec2(u_mouse.x * u_dpr, u_resolution.y - (u_mouse.y * u_dpr));

                vec2 to_mouse = st - mouse;
                float dist = length(to_mouse);
                float glow_radius = u_glow_radius * u_dpr;

                // GPU optimization: discard pixel calculations outside active glow radius
                if (dist > glow_radius) { discard; }

                float lens_radius = u_lens_radius * u_dpr;

                vec2 sample_pos = st;
                if (dist < lens_radius && dist > 0.001) {
                    float factor = 1.0 - (dist / lens_radius);
                    float bf = 1.0 + (u_magnification - 1.0) * (factor * factor);
                    sample_pos = mouse + normalize(to_mouse) * (dist / bf);
                }

                float grid_size = u_grid_size * u_dpr;
                vec2 grid_fract = mod(sample_pos, grid_size);
                float dist_x = min(grid_fract.x, grid_size - grid_fract.x);
                float dist_y = min(grid_fract.y, grid_size - grid_fract.y);

                float line_half_width = 0.7 * u_dpr;
                float smooth_edge = 0.5 * u_dpr;

                float alpha_x = 1.0 - smoothstep(line_half_width - smooth_edge, line_half_width + smooth_edge, dist_x);
                float alpha_y = 1.0 - smoothstep(line_half_width - smooth_edge, line_half_width + smooth_edge, dist_y);

                float line_alpha = max(alpha_x, alpha_y);
                float glow = pow(clamp(1.0 - (dist / glow_radius), 0.0, 1.0), 1.5);

                gl_FragColor = vec4(u_grid_color, line_alpha * glow * u_base_opacity);
            }
        `;

        const compileShader = (source, type) => {
            const shader = gl.createShader(type);
            gl.shaderSource(shader, source);
            gl.compileShader(shader);
            if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                console.error('Shader compile error:', gl.getShaderInfoLog(shader));
                gl.deleteShader(shader);
                return null;
            }
            return shader;
        };

        const vs = compileShader(vsSource, gl.VERTEX_SHADER);
        const fs = compileShader(fsSource, gl.FRAGMENT_SHADER);
        if (!vs || !fs) {
            this.quality = 'low';
            this.resize();
            window.addEventListener('resize', () => this.resize());
            return;
        }

        const program = gl.createProgram();
        gl.attachShader(program, vs);
        gl.attachShader(program, fs);
        gl.linkProgram(program);

        if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
            console.error('WebGL Program link error:', gl.getProgramInfoLog(program));
            this.quality = 'low';
            this.resize();
            window.addEventListener('resize', () => this.resize());
            return;
        }
        this.program = program;

        const vertices = new Float32Array([
            -1.0, -1.0,
            1.0, -1.0,
            -1.0, 1.0,
            1.0, 1.0
        ]);

        const buffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
        gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW);

        const posAttrib = gl.getAttribLocation(program, 'position');
        gl.enableVertexAttribArray(posAttrib);
        gl.vertexAttribPointer(posAttrib, 2, gl.FLOAT, false, 0, 0);

        this.uLoc = {
            resolution: gl.getUniformLocation(program, 'u_resolution'),
            mouse: gl.getUniformLocation(program, 'u_mouse'),
            dpr: gl.getUniformLocation(program, 'u_dpr'),
            gridSize: gl.getUniformLocation(program, 'u_grid_size'),
            lensRadius: gl.getUniformLocation(program, 'u_lens_radius'),
            glowRadius: gl.getUniformLocation(program, 'u_glow_radius'),
            magnification: gl.getUniformLocation(program, 'u_magnification'),
            gridColor: gl.getUniformLocation(program, 'u_grid_color'),
            baseOpacity: gl.getUniformLocation(program, 'u_base_opacity')
        };

        this.resize();
        window.addEventListener('resize', () => this.resize());

        window.addEventListener('mousemove', (e) => {
            if (!this.isTabVisible || this.quality === 'low') return;

            this.mouseX = e.clientX;
            this.mouseY = e.clientY;

            this.$el.style.setProperty('--mouse-x', e.clientX + 'px');
            this.$el.style.setProperty('--mouse-y', e.clientY + 'px');

            if (!this.pendingFrame) {
                this.pendingFrame = true;
                requestAnimationFrame(() => {
                    this.draw();
                    this.pendingFrame = false;
                });
            }
        }, { passive: true });

        this.draw();
    },

    resize() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        
        let dpr = window.devicePixelRatio || 1;
        if (this.quality === 'medium') {
            dpr = Math.min(dpr, 1.25);
        } else if (this.quality === 'low') {
            dpr = 1.0;
        }

        if (this.canvasGl) {
            this.canvasGl.width = this.width * dpr;
            this.canvasGl.height = this.height * dpr;
        }

        if (this.canvas2d) {
            this.canvas2d.width = this.width * dpr;
            this.canvas2d.height = this.height * dpr;
            this.ctx.setTransform(1, 0, 0, 1, 0, 0);
            this.ctx.scale(dpr, dpr);
        }

        this.draw();
    },

    draw() {
        if (!this.isTabVisible) return;
        
        const now = performance.now();
        if (this.quality !== 'low' && this.lastFrameTime > 0) {
            const elapsed = now - this.lastFrameTime;
            if (elapsed < 200) {
                if (elapsed > 33) {
                    this.slowFramesCount++;
                    if (this.slowFramesCount >= 5) {
                        this.downgradeQuality();
                        return;
                    }
                } else if (this.slowFramesCount > 0) {
                    this.slowFramesCount--;
                }
            }
        }
        this.lastFrameTime = now;

        this.drawWebGL();
        this.draw2D();
    },

    downgradeQuality() {
        if (this.quality === 'high') {
            this.quality = 'medium';
            this.slowFramesCount = 0;
            this.resize();
        } else if (this.quality === 'medium') {
            this.quality = 'low';
            this.slowFramesCount = 0;
            this.cleanupWebGL();
            this.resize();
        }
    },

    cleanupWebGL() {
        if (this.gl && this.program) {
            const gl = this.gl;
            gl.useProgram(null);
            gl.deleteProgram(this.program);
            this.program = null;
            this.gl = null;
        }
    },

    drawWebGL() {
        const gl = this.gl;
        if (!gl || this.quality === 'low') return;

        let dpr = window.devicePixelRatio || 1;
        if (this.quality === 'medium') {
            dpr = Math.min(dpr, 1.25);
        }

        gl.viewport(0, 0, this.canvasGl.width, this.canvasGl.height);
        gl.clear(gl.COLOR_BUFFER_BIT);

        gl.useProgram(this.program);

        gl.uniform2f(this.uLoc.resolution, this.canvasGl.width, this.canvasGl.height);
        gl.uniform2f(this.uLoc.mouse, this.mouseX, this.mouseY);
        gl.uniform1f(this.uLoc.dpr, dpr);
        gl.uniform1f(this.uLoc.gridSize, this.gridSize);
        gl.uniform1f(this.uLoc.lensRadius, this.lensRadius);
        gl.uniform1f(this.uLoc.glowRadius, this.glowRadius);
        gl.uniform1f(this.uLoc.magnification, this.maxMagnification);

        const isDark = document.documentElement.classList.contains('dark');
        const colorRgb = isDark ? [185 / 255, 28 / 255, 28 / 255] : [239 / 255, 68 / 255, 68 / 255];
        gl.uniform3f(this.uLoc.gridColor, colorRgb[0], colorRgb[1], colorRgb[2]);

        const baseOpacity = isDark ? 0.22 : 0.35;
        gl.uniform1f(this.uLoc.baseOpacity, baseOpacity);

        gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    },

    draw2D() {
        if (!this.ctx) return;
        this.ctx.clearRect(0, 0, this.width, this.height);

        const isLow = this.quality === 'low';
        const isMedium = this.quality === 'medium';
        const nSteps = isLow ? 15 : (isMedium ? 20 : 60);

        const displace = isLow ? (ox, oy) => [ox, oy] : (ox, oy) => {
            let dx = ox - this.mouseX;
            let dy = oy - this.mouseY;
            let distSq = dx * dx + dy * dy;
            if (distSq < this.lensRadiusSq && distSq > 0) {
                let dist = Math.sqrt(distSq);
                let bf = 1 + this.maxMagMinusOne * Math.pow(1 - dist * this.oneOverLensRadius, 2);
                let ang = Math.atan2(dy, dx);
                return [this.mouseX + Math.cos(ang) * dist * bf, this.mouseY + Math.sin(ang) * dist * bf];
            }
            return [ox, oy];
        };

        const sampledBezier = (p0, p1, p2, p3, n = nSteps) => {
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

        const isDark = document.documentElement.classList.contains('dark');
        const W = this.width, H = this.height;

        // --- Accent shapes ---
        // --- Accent 1: Large radial sweep from top-right corner ---
        let arc1pts = [displace(W, 0)];
        arc1pts = arc1pts.concat(sampledBezier([W * 0.35, 0], [W * 0.65, 0], [W, H * 0.25], [W, H * 0.65]));
        let g1 = this.ctx.createRadialGradient(W, 0, W * 0.05, W, 0, W * 0.75);
        g1.addColorStop(0, isDark ? 'rgba(35,5,5,0.95)' : 'rgba(255,242,242,0.95)');
        g1.addColorStop(0.45, isDark ? 'rgba(120,20,20,0.6)' : 'rgba(239,68,68,0.3)');
        g1.addColorStop(1, 'rgba(0,0,0,0)');
        fillShape(arc1pts, g1);

        // --- Accent 2: Sharper inner arc, top-right ---
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
    {{-- Pattern Background: Subtle Grid Lines (static, masked near cursor) --}}
    {{-- Static grid: light mode (higher opacity) --}}
    <div class="pointer-events-none absolute inset-0 dark:hidden"
        style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden; background-image: linear-gradient(rgba(161,161,170,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.07) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
    </div>
    {{-- Static grid: dark mode (subtle opacity) --}}
    <div class="pointer-events-none absolute inset-0 hidden dark:block"
        style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden; background-image: linear-gradient(rgba(161,161,170,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.03) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
    </div>

    {{-- Pattern Background: Interactive Lens-Distorted Grid Lines & Chart --}}
    <div class="pointer-events-none absolute inset-0" style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;">
        <canvas x-ref="canvasGl" class="absolute inset-0 block h-full w-full" style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;" :class="{'hidden': quality === 'low'}"></canvas>
        <canvas x-ref="canvas2d" class="absolute inset-0 block h-full w-full" style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;"></canvas>
    </div>

    {{-- Interactive Cursor Glow --}}
    <div x-show="quality !== 'low'" class="pointer-events-none absolute inset-0"
        style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden; background: radial-gradient(150px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), rgba(239, 68, 68, 0.06), transparent 100%);">
    </div>
</div>
