
    (() => {
      const canvas = document.getElementById('snow-canvas');
      const ctx = canvas.getContext('2d');

      const state = {
        dpr: Math.min(window.devicePixelRatio || 1, 2), // limité pour la perf
        width: 0,
        height: 0,
        flakes: [],
        running: true,
        lastTS: 0,
        density: parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--snow-density')) || 0.00022,
        windScale: parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--snow-wind')) || 1.0,
        speedScale: parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--snow-speed')) || 1.0,
      };

      // Gestion responsive + HiDPI
      function resize() {
        state.width = Math.max(1, Math.floor(canvas.clientWidth));
        state.height = Math.max(1, Math.floor(canvas.clientHeight));
        const { dpr } = state;
        canvas.width = Math.floor(state.width * dpr);
        canvas.height = Math.floor(state.height * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        rebuildFlakes();
      }

      // Flocon avec profondeur (z) pour simuler le bokeh / parallax
      function createFlake() {
        const z = Math.pow(Math.random(), 2); // plus de flocons lointains
        const size = lerp(0.6, 3.2, z); // rayon en px (avant dpr)
        const speedY = lerp(15, 80, z); // px/sec
        const swayAmp = lerp(8, 28, z); // oscillation horizontale
        const blur = z > 0.75 ? 2 : z > 0.5 ? 1 : 0; // léger flou pour les gros flocons
        const alpha = lerp(0.25, 0.95, z);
        return {
          x: Math.random() * state.width,
          y: Math.random() * state.height,
          z,
          r: size,
          vy: speedY,
          sway: swayAmp,
          seed: Math.random() * 1000,
          blur,
          alpha,
        };
      }

      function rebuildFlakes() {
        const count = Math.floor(state.width * state.height * state.density);
        const prev = state.flakes;
        if (prev.length === 0) {
          state.flakes = Array.from({ length: count }, createFlake);
        } else if (count > prev.length) {
          state.flakes.push(...Array.from({ length: count - prev.length }, createFlake));
        } else if (count < prev.length) {
          state.flakes.length = count;
        }
      }

      function lerp(a, b, t) { return a + (b - a) * t; }
      function clamp(n, a, b) { return Math.max(a, Math.min(b, n)); }

      function windAt(y, t) {
        // Vent pseudo-pérlin simple basé sur sin, varie doucement verticalement et dans le temps
        const kY = 0.0012; // fréquence spatiale
        const kT = 0.00035; // fréquence temporelle
        const base = Math.sin(y * kY + t * kT) + Math.sin(y * kY * 0.5 + t * kT * 1.6) * 0.5;
        return base * 30 * state.windScale; // px/sec
      }

      function update(dt, t) {
        const g = 1.0 * state.speedScale; // gravité (échelle)
        for (let i = 0; i < state.flakes.length; i++) {
          const f = state.flakes[i];
          const w = windAt(f.y, t) * (0.4 + f.z * 0.6); // le vent affecte plus les gros flocons
          const sway = Math.sin((t * 0.002) + f.seed + f.y * 0.01) * f.sway;

          f.x += (w + sway) * dt;
          f.y += (f.vy * g) * dt;

          // Recyclage des flocons qui sortent de l'écran
          if (f.y - f.r > state.height) {
            f.y = -f.r - Math.random() * 40;
            f.x = Math.random() * state.width;
          } else if (f.x + f.r < 0) {
            f.x = state.width + f.r;
          } else if (f.x - f.r > state.width) {
            f.x = -f.r;
          }
        }
      }

      function draw() {
        ctx.clearRect(0, 0, state.width, state.height);

        // Tri par profondeur pour un rendu plus naturel (les plus petits derrière)
        const arr = state.flakes;
        arr.sort((a, b) => a.z - b.z);

        // Dessin en 2 passes : loin (petits, sans blur), près (gros, avec blur/alpha)
        // Passe lointaine
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillStyle = '#0dfd05ff';

        ctx.beginPath();
        for (let i = 0; i < arr.length; i++) {
          const f = arr[i];
          if (f.r <= 1.2) {
            ctx.globalAlpha = f.alpha * 0.7;
            ctx.moveTo(f.x + f.r, f.y);
            ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2);
          }
        }
        ctx.fill();

        // Passe proche (légère lueur pour bokeh)
        for (let i = 0; i < arr.length; i++) {
          const f = arr[i];
          if (f.r > 1.2) {
            ctx.save();
            ctx.globalAlpha = f.alpha;
            if (f.blur) {
              ctx.shadowColor = 'rgba(116, 1, 1, 1)';
              ctx.shadowBlur = f.blur * 2;
            } else {
              ctx.shadowBlur = 0;
            }
            ctx.beginPath();
            ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2);
            ctx.fillStyle = '#880303ff';
            ctx.fill();
            ctx.restore();
          }
        }

        // Légère brume pour renforcer la profondeur (optionnelle)
        const mistAlpha = clamp(state.flakes.length / 1600, 0, 0.08);
        if (mistAlpha > 0) {
          const g = ctx.createLinearGradient(0, 0, 0, state.height);
          g.addColorStop(0, `rgba(255,255,255,${mistAlpha * 0.25})`);
          g.addColorStop(1, `rgba(255,255,255,0)`);
          ctx.fillStyle = g;
          ctx.fillRect(0, 0, state.width, state.height);
        }
      }

      function frame(ts) {
        if (!state.running) return;
        if (!state.lastTS) state.lastTS = ts;
        const dt = Math.min(0.033, (ts - state.lastTS) / 1000); // clamp à 33ms
        state.lastTS = ts;
        update(dt, ts);
        draw();
        requestAnimationFrame(frame);
      }

      // Contrôles UI
      const densityEl = document.getElementById('density');
      const windEl = document.getElementById('wind');
      const speedEl = document.getElementById('speed');
      const toggleEl = document.getElementById('toggle');

      function syncControlsFromState() {
        densityEl.value = state.density;
        windEl.value = state.windScale;
        speedEl.value = state.speedScale;
      }

      densityEl.addEventListener('input', () => {
        state.density = parseFloat(densityEl.value);
        rebuildFlakes();
      });
      windEl.addEventListener('input', () => {
        state.windScale = parseFloat(windEl.value);
      });
      speedEl.addEventListener('input', () => {
        state.speedScale = parseFloat(speedEl.value);
      });
      toggleEl.addEventListener('click', () => {
        state.running = !state.running;
        toggleEl.textContent = state.running ? '⏸︎ Pause' : '▶︎ Reprendre';
        if (state.running) {
          state.lastTS = 0;
          requestAnimationFrame(frame);
        }
      });

      // Démarrage
      syncControlsFromState();
      resize();
      window.addEventListener('resize', resize);
      requestAnimationFrame(frame);

      // Mise en pause automatique si l'onglet est caché (perf)
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          state.running = false;
          toggleEl.textContent = '▶︎ Reprendre';
        }
      });

      // Reprise au retour sur l'onglet
      window.addEventListener('focus', () => {
        if (!state.running) {
          state.running = true;
          state.lastTS = 0;
          toggleEl.textContent = '⏸︎ Pause';
          requestAnimationFrame(frame);
        }
      });
    })();
