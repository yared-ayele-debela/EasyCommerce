<div id="splash-wrapper">
  <!-- Splash Screens -->
  <div class="splash-screen active" id="splash1">
    <button class="skip-button" onclick="skipAll()">Skip</button>
    <div class="splash-image">
      <img src="{{ asset('logo.png') }}" alt="Welcome">
    </div>
    <div class="splash-title">Welcome to ShopSmart</div>
    <div class="splash-desc">Discover amazing deals every day</div>
    <div class="btn-group-bottom">
      <button class="btn btn-secondary" disabled>Previous</button>
      <button class="btn btn-primary" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash2">
    <button class="skip-button" onclick="skipAll()">Skip</button>
    <div class="splash-image">
      <img src="https://cdn-icons-png.flaticon.com/512/4290/4290854.png" alt="Fast Delivery">
    </div>
    <div class="splash-title">BOOK HOTELS, STRESS-FREE</div>
    <div class="splash-desc">
      Find and book the best hotels in minutes.<br>
      Enjoy your stay, wherever you go.
    </div>
    <div class="btn-group-bottom">
      <button class="btn btn-primary" onclick="prevScreen()">Previous</button>
      <button class="btn btn-primary" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash3">
    <button class="skip-button" onclick="skipAll()">Skip</button>
    <div class="splash-image">
      <img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" alt="Secure Payments">
    </div>
    <div class="splash-title">ORDER FOOD, FAST & FRESH</div>
    <div class="splash-desc">
      Your favorite meals, delivered to your door.<br>
      Easy ordering and real-time tracking.
    </div>
    <div class="btn-group-bottom">
      <button class="btn btn-primary" onclick="prevScreen()">Previous</button>
      <button class="btn btn-primary" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash4">
    <button class="skip-button" onclick="skipAll()">Skip</button>
    <div class="splash-image">
      <img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" alt="Secure Payments">
    </div>
    <div class="splash-title">SHOP SMARTER, LIVE EASY</div>
    <div class="splash-desc">
      Discover a wide range of products from trusted sellers.<br>
      Fast, secure, and simple shopping.
    </div>
    <div class="btn-group-bottom">
      <button class="btn btn-primary" onclick="prevScreen()">Previous</button>
      <button class="btn btn-success" onclick="skipAll()">Start Shopping</button>
    </div>
  </div>
</div>

<div id="main-content" style="display: none">
  @yield('content')
</div>
