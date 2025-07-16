<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mobile Splash</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: sans-serif;
    }

    .splash-screen {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: linear-gradient(to bottom right, #28e341, #ffffff);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      z-index: 9999;
      transition: opacity 0.4s ease;
    }

    .splash-screen.hide {
      opacity: 0;
      pointer-events: none;
    }

    .main-content {
      display: none;
      padding: 20px;
      text-align: center;
    }

    .splash-logo {
      width: 120px;
      margin-bottom: 20px;
    }

    .start-btn {
      margin-top: 20px;
      padding: 10px 20px;
      background: #fff;
      color: #28e341;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }

    /* Hide splash on larger devices */
    @media (min-width: 768px) {
      .splash-screen {
        display: none !important;
      }
    }
  </style>
</head>
<body>

  <!-- Splash Screen (mobile only) -->
  <div class="splash-screen" id="splash">
    <img src="logo.png" alt="Logo" class="splash-logo" />
    <h1>Welcome to My App</h1>
    <p>Only shows on mobile or PWA</p>
    <button class="start-btn" onclick="hideSplash()">Start</button>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="main">
    <h2>Hello! 🎉</h2>
    <p>This is your main content.</p>
  </div>

  <script>
    function isMobile() {
      return window.innerWidth < 768;
    }

    function hideSplash() {
      const splash = document.getElementById("splash");
      splash.classList.add("hide");
      setTimeout(() => {
        splash.style.display = "none";
        document.getElementById("main").style.display = "block";
      }, 400);
    }

    // Only show splash on mobile or PWA .apk
    document.addEventListener("DOMContentLoaded", function () {
      if (!isMobile()) {
        // Skip splash if not mobile
        hideSplash();
      }
    });
  </script>

</body>
</html>
