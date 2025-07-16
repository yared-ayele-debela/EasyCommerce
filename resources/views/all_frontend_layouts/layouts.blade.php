<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Three Screen Splash</title>
  <style>
    /* body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: sans-serif;
      background: #f5f5f5;
      overflow: hidden;
    } */

    .splash-screen {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: linear-gradient(to bottom right, #28e341, #ffffff);
      color: #fff;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
      z-index: 9999;
      transition: opacity 0.4s ease;
    }

    .splash-screen.active {
      display: flex;
    }

    .splash-logo {
      width: 100px;
      margin-bottom: 20px;
    }

    .splash-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .splash-desc {
      font-size: 1rem;
      margin-bottom: 30px;
    }

    .button-group {
      display: flex;
      justify-content: space-between;
      width: 100%;
      max-width: 300px;
      gap: 10px;
    }

    .btn {
      padding: 10px;
      flex: 1;
      background: #fff;
      color: #28e341;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .skip-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: none;
      border: none;
      color: #fff;
      text-decoration: underline;
      font-weight: bold;
      cursor: pointer;
    }

    .main-content {
      display: none;
      padding: 20px;
      text-align: center;
    }

    @media (min-width: 768px) {
      .splash-screen {
        display: none !important;
      }
    }
  </style>
</head>
<body>

  <!-- Splash Screens -->
  <div class="splash-screen active" id="splash1">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    <img src="logo.png" alt="Logo" class="splash-logo" />
    <div class="splash-title">Welcome!</div>
    <div class="splash-desc">Discover amazing products at your fingertips.</div>
    <div class="button-group">
      <button class="btn" disabled>Previous</button>
      <button class="btn" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash2">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    <img src="logo.png" alt="Logo" class="splash-logo" />
    <div class="splash-title">Fast Delivery</div>
    <div class="splash-desc">Get your orders quickly and reliably.</div>
    <div class="button-group">
      <button class="btn" onclick="prevScreen()">Previous</button>
      <button class="btn" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash3">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    <img src="logo.png" alt="Logo" class="splash-logo" />
    <div class="splash-title">Get Started</div>
    <div class="splash-desc">Join us today and enjoy the best deals.</div>
    <div class="button-group">
      <button class="btn" onclick="prevScreen()">Previous</button>
      <button class="btn" onclick="skipAll()">Start</button>
    </div>
  </div>

  <!-- Main App Content -->
  <div class="main-content" id="main">
    <h2>🎉 Welcome to the App!</h2>
    <p>You’ve successfully entered the main content.</p>
  </div>

  <script>
    const screens = ['splash1', 'splash2', 'splash3'];
    let current = 0;

    function updateScreens() {
      screens.forEach((id, index) => {
        document.getElementById(id).classList.toggle('active', index === current);
      });
    }

    function nextScreen() {
      if (current < screens.length - 1) {
        current++;
        updateScreens();
      }
    }

    function prevScreen() {
      if (current > 0) {
        current--;
        updateScreens();
      }
    }

    function skipAll() {
      screens.forEach(id => {
        document.getElementById(id).style.display = 'none';
      });
      document.getElementById('main').style.display = 'block';
    }

    document.addEventListener("DOMContentLoaded", function () {
      const isMobile = window.innerWidth < 768;
      const hasVisited = localStorage.getItem("hasVisited");
      if (isMobile && !hasVisited) {
        document.getElementById(screens[current]).classList.add('active');
        localStorage.setItem("hasVisited", "true");
      } else {
        skipAll();
      }
    });
  </script>

</body>
</html>
