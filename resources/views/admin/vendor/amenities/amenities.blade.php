<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/amenities.css') }}"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Amenities</title>
</head>

<body>
   <!-- NAVIGATION BAR SECTION -->

  <nav class="navbar">

    <div class="left-side-nav">
      <a href="{{ url('dashboard') }}">
        <button class="dashboard" id="dashboard">
          <i class="material-icons nav-icons">dashboard</i> Dashboard
        </button>
      </a>
      <a href="{{ route('admin.vendor.cottages') }}">
        <button class="ameneties" id="ameneties-btn">
          <i class="material-icons nav-icons">holiday_village</i> Amenities
        </button>
      </a>
      <a href="{{ route('admin.vendor.reservation_calendar') }}">
        <button class="reservations" id="reservation">
          <i class="material-icons nav-icons">date_range</i> Reservations
        </button>
      </a>
    </div>

    <div class="right-side-nav">
      <button class="profile">
        <i class="material-icons" style="font-size:45px; color: white">
          account_circle
        </i>
      </button>
    </div>

  </nav>

  <!-- SIDEBAR SECTION  -->

  <div class="container">

    <nav class="sidebar">
      <div class="icon-container" id="cottages-tab">
        <i class="material-icons side-icons">
          storefront
        </i>
        <p class="icon-label">
          Cottages
        </p>
      </div>

      <div class="icon-container" id="tables-tab">
        <i class="material-icons side-icons" >
          dining
        </i>
        <p class="icon-label">
          Tables
        </p>
      </div>

        <div class="icon-container" id="cancel-tab">
          <i class="material-icons side-icons">
            close
          </i>
          <p class="icon-label">
            Cancel
          </p>
      </div>

    </nav>

  <!----------------------- MAIN SECTION  ---------------------------->
    
  <main class="main">

    <div class="date-container">
      <h2 id="current-date" class="date-title"></h2>
  
      <div class="date-selectors">
        <select id="month-select"></select>
        <select id="day-select"></select>
        <select id="year-select"></select>
        <select id="time-select">
          <option>12:00 AM</option>
          <option>1:00 AM</option>
          <option>2:00 AM</option>
          <option>3:00 AM</option>
          <option>4:00 AM</option>
          <option>5:00 AM</option>
          <option>6:00 AM</option>
          <option>7:00 AM</option>
          <option>8:00 AM</option>
          <option>9:00 AM</option>
          <option>10:00 AM</option>
          <option>11:00 AM</option>
          <option>12:00 PM</option>
          <option>1:00 PM</option>
          <option>2:00 PM</option>
          <option>3:00 PM</option>
          <option>4:00 PM</option>
          <option>5:00 PM</option>
          <option>6:00 PM</option>
          <option>7:00 PM</option>
          <option>8:00 PM</option>
          <option>9:00 PM</option>
          <option>10:00 PM</option>
          <option>11:00 PM</option>
        </select>
      </div>
    </div>
  
    @yield('amenities-content') 


  </div>

  


  <script>
    window.onload = function () {
      const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];
  
      const monthSelect = document.getElementById("month-select");
      const daySelect = document.getElementById("day-select");
      const yearSelect = document.getElementById("year-select");
      const currentDateTitle = document.getElementById("current-date");
  
      // Populate month select
      monthNames.forEach((month, index) => {
        const option = document.createElement("option");
        option.value = index;
        option.textContent = month;
        monthSelect.appendChild(option);
      });
  
      // Populate year select
      const currentYear = new Date().getFullYear();
      for (let y = currentYear - 5; y <= currentYear + 5; y++) {
        const option = document.createElement("option");
        option.value = y;
        option.textContent = y;
        yearSelect.appendChild(option);
      }
  
      // Update days
      function updateDays() {
        const selectedYear = parseInt(yearSelect.value);
        const selectedMonth = parseInt(monthSelect.value);
        const daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();
  
        daySelect.innerHTML = "";
        for (let d = 1; d <= daysInMonth; d++) {
          const option = document.createElement("option");
          option.value = d;
          option.textContent = d;
          daySelect.appendChild(option);
        }
      }
  
      // Update header
      function updateTitle() {
        const selectedMonth = monthNames[parseInt(monthSelect.value)];
        const selectedDay = daySelect.value;
        const selectedYear = yearSelect.value;
  
        currentDateTitle.textContent = `${selectedMonth} ${selectedDay}, ${selectedYear}`;
      }
  
      // Initial setup
      const now = new Date();
      monthSelect.value = now.getMonth();
      yearSelect.value = now.getFullYear();
      updateDays();
      daySelect.value = now.getDate();
      updateTitle();
  
      // Event listeners
      monthSelect.addEventListener("change", () => {
        updateDays();
        updateTitle();
      });
  
      yearSelect.addEventListener("change", () => {
        updateDays();
        updateTitle();
      });
  
      daySelect.addEventListener("change", updateTitle);
    };
    
    function loadContent(page) {
  fetch(page)
    .then(response => response.text())
    .then(html => {
      document.getElementById('main-content').innerHTML = html;
    })
    .catch(error => {
      console.error('Error loading content:', error);
    });
}


  // Sidebar tab buttons
  const cottagesTab = document.getElementById('cottages-tab');
  const tablesTab = document.getElementById('tables-tab');
  const cancelTab = document.getElementById('cancel-tab');

  cottagesTab.addEventListener('click', () => {
    setActiveTab(cottagesTab);
    window.location.href = "{{ route('admin.vendor.cottages') }}";
  });


  tablesTab.addEventListener('click', () => {
    setActiveTab(tablesTab);
    window.location.href = "{{ route('admin.vendor.tables') }}";
  });

  cancelTab.addEventListener('click', () =>{
    setActiveTab(cancelTab);
    window.location.href = "{{ url('cancel') }}";
  });

  function setActiveTab(activeTab) {
    document.querySelectorAll('.icon-container').forEach(tab => {
      tab.classList.remove('active');
    });
    activeTab.classList.add('active');
  }
    
  

  
    
  </script>
    
    
  
</body>
</html>