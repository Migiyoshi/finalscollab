<?php
// saved.php — Confirmation screen after successful entry insertion
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saved | OSCA Records System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/saved.css">
</head>
<body>
  <div class="app">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand">
        <img src="assets/img/mayondonlogo.png" alt="Barangay seal">
        <div>
          <strong>Welcome Admin1!</strong>
          <small>Payout management system</small>
        </div>
      </div>

      <nav class="nav" aria-label="Main">
        <a class="nav-link" href="Dashboard.php"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a class="nav-link active" href="list.php" aria-current="page"><i class="bi bi-person-fill"></i> List</a>
        <a class="nav-link" href="reports.php"><i class="bi bi-files"></i> Reports</a>
      </nav>

      <a class="nav-link logout" href="login.html"><i class="bi bi-box-arrow-left"></i> Log out</a>
    </aside>

    <!-- Main -->
    <main class="main">
      <section class="panel" aria-labelledby="savedTitle">
        <div class="saved" role="status">

          <!-- Document + check illustration -->
          <svg class="saved-art" viewBox="-58 -4 220 205" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Document with a check mark">
            <defs>
              <clipPath id="docClip">
                <path d="M22 0H101L147 46V171Q147 193 125 193H22Q0 193 0 171V22Q0 0 22 0Z"/>
              </clipPath>
              <clipPath id="checkClip">
                <circle cx="5" cy="142" r="51"/>
              </clipPath>
            </defs>

            <!-- document -->
            <g clip-path="url(#docClip)">
              <rect x="0" y="0" width="147" height="193" fill="#e1f0f9"/>
              <rect x="73" y="0" width="74" height="193" fill="#bde0f1"/>
            </g>
            <path d="M101 0V24Q101 46 123 46H147Z" fill="#7bbfe3"/>

            <!-- text lines -->
            <rect x="26" y="68" width="94" height="12" rx="6" fill="#5c5c7c"/>
            <rect x="26" y="101" width="94" height="12" rx="6" fill="#46465f"/>
            <rect x="26" y="136" width="94" height="12" rx="6" fill="#46465f"/>

            <!-- check circle -->
            <g clip-path="url(#checkClip)">
              <rect x="-46" y="91" width="51" height="102" fill="#47b5ff"/>
              <rect x="5" y="91" width="51" height="102" fill="#0a98ff"/>
            </g>
            <path d="M-13 140L2 155L27 130" fill="none" stroke="#4b4b6b" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>

          <h1 id="savedTitle">Saved Successfully</h1>
          <a class="btn-back" href="list.php">Back to List</a>
        </div>
      </section>
    </main>

  </div>
</body>
</html>