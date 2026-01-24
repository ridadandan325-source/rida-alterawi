<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Digital Lands</title>

  <!-- Tailwind CDN (Landing فقط) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body { margin: 0; overflow: hidden; }
    #globe { position: absolute; inset: 0; }
    .glass {
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.16);
      backdrop-filter: blur(12px);
    }
    /* subtle animated glow */
    .glow {
      position:absolute;
      width: 520px;
      height: 520px;
      border-radius: 999px;
      filter: blur(60px);
      opacity: .55;
      animation: float 7s ease-in-out infinite;
      pointer-events:none;
    }
    @keyframes float {
      0%,100% { transform: translateY(0px); }
      50% { transform: translateY(-14px); }
    }
  </style>
</head>

<body class="bg-black text-white">

  <!-- Globe Canvas -->
  <div id="globe"></div>

  <!-- Dark overlay gradient -->
  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/45 to-black/85"></div>

  <!-- Soft color glows -->
  <div class="glow left-[-140px] top-[-140px] bg-violet-500/60"></div>
  <div class="glow right-[-160px] bottom-[-160px] bg-emerald-400/50" style="animation-delay:1.2s;"></div>

  <!-- Content -->
  <div class="relative z-10 min-h-screen flex items-center">
    <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">

      <!-- Left -->
      <div>
        <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full">
          <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
          <span class="text-sm text-white/80">Own digital lands as tokens</span>
        </div>

        <h1 class="mt-5 text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
          Digital Lands
          <span class="block text-white/80">Buy • Sell • Explore</span>
        </h1>

        <p class="mt-5 text-white/70 text-lg leading-relaxed max-w-xl">
          Explore lands on an interactive globe, then buy digital plots securely after you sign in.
          Simple, fast, and game-like.
        </p>

        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('register') }}"
             class="px-5 py-3 rounded-xl bg-white text-black font-bold hover:opacity-90 shadow-lg shadow-white/10">
            Create Account
          </a>

          <a href="{{ route('login') }}"
             class="px-5 py-3 rounded-xl glass font-bold hover:bg-white/10">
            Login
          </a>

          <!-- ✅ تعديل: Preview يروح على /map -->
          <a href="{{ url('/map') }}"
             class="px-5 py-3 rounded-xl border border-white/20 font-bold hover:bg-white/10">
            Explore (Preview)
          </a>
        </div>

        <div class="mt-6 text-sm text-white/50">
          Tip: After login, you’ll access the full map, purchases, and sales dashboard.
        </div>

        <div class="mt-4 text-xs text-white/40">
          Powered by Laravel + Breeze + Leaflet • Globe animation for a premium first impression.
        </div>
      </div>

      <!-- Right card -->
      <div class="glass rounded-2xl p-6 lg:p-8">
        <div class="text-sm text-white/70">What you can do</div>

        <div class="mt-4 space-y-4">
          <div class="flex gap-3">
            <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center">🗺️</div>
            <div>
              <div class="font-bold">Explore on the Map</div>
              <div class="text-white/60 text-sm">See lands as markers and focus on specific plots.</div>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center">💸</div>
            <div>
              <div class="font-bold">Buy & Own</div>
              <div class="text-white/60 text-sm">Buy once only — ownership transfers automatically.</div>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center">📦</div>
            <div>
              <div class="font-bold">Track Purchases & Sales</div>
              <div class="text-white/60 text-sm">View your purchases and your sold lands anytime.</div>
            </div>
          </div>
        </div>

        <!-- Mini hint -->
        <div class="mt-6 text-xs text-white/50">
          Preview mode lets visitors explore the map. Buying requires login.
        </div>
      </div>

    </div>
  </div>

  <!-- Three.js + Globe.gl -->
  <script src="https://unpkg.com/three@0.159.0/build/three.min.js"></script>
  <script src="https://unpkg.com/globe.gl@2.32.1/dist/globe.gl.min.js"></script>

  <script>
    const el = document.getElementById('globe');

    const globe = Globe()(el)
      .globeImageUrl('https://unpkg.com/three-globe/example/img/earth-night.jpg')
      .bumpImageUrl('https://unpkg.com/three-globe/example/img/earth-topology.png')
      .backgroundImageUrl('https://unpkg.com/three-globe/example/img/night-sky.png')
      .atmosphereColor('#8b5cf6')
      .atmosphereAltitude(0.25)
      .showGraticules(false);

    function resize() {
      globe.width(window.innerWidth);
      globe.height(window.innerHeight);
    }
    window.addEventListener('resize', resize);
    resize();

    globe.pointOfView({ lat: 31.95, lng: 35.91, altitude: 2.2 });

    globe.controls().autoRotate = true;
    globe.controls().autoRotateSpeed = 0.45;
    globe.controls().enableZoom = true;

    const scene = globe.scene();
    scene.add(new THREE.AmbientLight(0xffffff, 1.1));
    const dirLight = new THREE.DirectionalLight(0xffffff, 2.2);
    dirLight.position.set(1, 1, 1);
    scene.add(dirLight);
  </script>

</body>
</html>
