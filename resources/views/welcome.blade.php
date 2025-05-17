<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Waves Beach Resort</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet" />
</head>
<body>
<header class="navbar">
  <div class="logo">
    <img src="{{ asset('images/logs.png') }}" alt="WAVES Logo" />
    <div class="logo-text">
      <h1 class="title">WAVES</h1>
      <p class="sub-title">Resort</p>
    </div>
  </div>

  <button class="navbar-toggler" onclick="toggleMenu()">
    <i class="fa-solid fa-bars"></i>
  </button>

  <nav class="nav-links" id="navMenu">
    <a href="#" class="nav-link active">Home</a>
    <a href="#about" class="nav-link">About</a>
    @guest
      <a class="nav-link" href="{{ route('login') }}">Book</a>
    @endguest
    @auth
      <a class="nav-link" href="{{ route('customer.reservation') }}">Book</a>
    @endauth
    <div class="profile-container">
      <a href="{{ route('customer.profile') }}">
        <i class="fas fa-user-circle" id="profile-icon"></i>
      </a>
    </div>
  </nav>
</header>



    <!-- home section -->
    <section id="home">
      <div class="content">
        <h3>Beach days are the best days <br /> Seas your moment</h3>
        <p>
          Feel you summer and relaxing moment with your family and friends
          <br />Cuz it's time to feel the summer vibe.
        </p>
        <button id="btn">Book Now</button>
      </div>
    </section>

    <!-- about section -->
    <div class="about" id="about">
      <div class="about-container">
        <div class="heading">About Us</div>
        <div class="about-row">
          <div class="about-col">
            <div class="card">
              <img src="{{ asset('images/abt.jpg') }}" alt="" />
            </div>
          </div>
          <div class="about-col">
            <p>
              Welcome to WAVES Resort! Spend your day lounging in our private cabanas, taking a dip in the crystal-clear waters, or enjoying a refreshing cocktail at our beachside bar.
              <br /><br />We are committed to providing a welcoming and relaxing environment where you can connect with nature, recharge, and make lasting memories.
              <br /><br />Our friendly staff is dedicated to ensuring your visit is comfortable and enjoyable, with personalized service that makes you feel right at home.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- resort preview -->
    <section class="top-cards">
      <div class="heading2">Resort Preview</div>
      <div class="cards-container">
        <div class="card">
          <img src="{{ asset('images/prev1.jpg') }}" alt="Preview 1" />
        </div>
        <div class="card">
          <img src="{{ asset('images/prev2.jpg') }}" alt="Preview 2" />
        </div>
        <div class="card">
          <img src="{{ asset('images/prev3.jpg') }}" alt="Preview 3" />
        </div>
      </div>
    </section>

    <!-- footer -->
    <footer class="site-footer">
      <p>&copy; 2025 Waves Beach Resort. All rights reserved.</p>
    </footer>
  </div>
  <script>
  function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('show');
  }
</script>

</body>
</html>
