<?php
// add.php — Add Senior Citizen Form
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Senior Citizen | OSCA Records System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/add.css">
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
      <section class="panel" aria-labelledby="formTitle">
        <header class="form-head">
          <h1 id="formTitle">Add Senior Citizen</h1>
          <p>Fill in the details to add a senior to the list</p>
        </header>

        <form id="seniorForm" novalidate>

          <!-- Personal Information -->
          <div class="section" role="group" aria-labelledby="secPersonal">
            <h2 class="section-title" id="secPersonal">Personal Information</h2>
            <div class="fields">
              <div class="field c4">
                <label for="lastName">Last Name</label>
                <input id="lastName" name="lastName" type="text" placeholder="Yoshino" autocomplete="family-name" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c4">
                <label for="firstName">First Name</label>
                <input id="firstName" name="firstName" type="text" placeholder="Akira Andrei" autocomplete="given-name" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c4">
                <label for="middleName">Middle Name</label>
                <input id="middleName" name="middleName" type="text" placeholder="Optional" autocomplete="additional-name">
                <label class="check" for="noMiddle">
                  <input id="noMiddle" type="checkbox"> <span>I don't have middle name</span>
                </label>
              </div>

              <div class="field c3">
                <label for="birthDate">Birthdate</label>
                <input id="birthDate" name="birthDate" type="date" required>
                <span class="hint" id="ageHint"></span>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c3">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" class="select" required>
                  <option value="" selected disabled>Select (M/F)</option>
                  <option value="M">Male (M)</option>
                  <option value="F">Female (F)</option>
                </select>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c3">
                <label for="civilStatus">Civil Status</label>
                <select id="civilStatus" name="civilStatus" class="select" required>
                  <option value="" selected disabled>Select</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c3">
                <label for="pension">Pension Beneficiary</label>
                <select id="pension" name="pension" class="select" required>
                  <option value="" selected disabled>Select</option>
                  <option value="Pension Beneficiary">Pension Beneficiary</option>
                  <option value="Not Pension Beneficiary">Not Pension Beneficiary</option>
                </select>
                <span class="error" aria-live="polite"></span>
              </div>
            </div>
          </div>

          <!-- Contact & Address -->
          <div class="section" role="group" aria-labelledby="secAddress">
            <h2 class="section-title" id="secAddress">Contact &amp; Address</h2>
            <div class="fields">
              <div class="field c4">
                <label for="mobile">Mobile Number</label>
                <input id="mobile" name="mobile" type="tel" inputmode="numeric" maxlength="11" placeholder="09190000000" autocomplete="tel" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c5">
                <label for="street">Address (House No./Street)</label>
                <input id="street" name="street" type="text" placeholder="123 Doon" autocomplete="street-address" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c3">
                <label for="purok">Purok</label>
                <select id="purok" name="purok" class="select" required>
                  <option value="Purok 1" selected>Purok 1</option>
                  <option value="Purok 2">Purok 2</option>
                  <option value="Purok 3">Purok 3</option>
                  <option value="Purok 4">Purok 4</option>
                  <option value="Purok 5">Purok 5</option>
                  <option value="Purok 6">Purok 6</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Registration Details -->
          <div class="section" role="group" aria-labelledby="secReg">
            <h2 class="section-title" id="secReg">Registration Details</h2>
            <div class="fields">
              <div class="field c4">
                <label for="regDate">Registration Date</label>
                <input id="regDate" name="regDate" type="date" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c4">
                <label for="verification">Verification</label>
                <select id="verification" name="verification" class="select">
                  <option value="Not verified" selected>Not verified</option>
                  <option value="Verified">Verified</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Contact Person -->
          <div class="section" role="group" aria-labelledby="secContact">
            <h2 class="section-title" id="secContact">Contact Person</h2>
            <div class="fields">
              <div class="field c4">
                <label for="contactName">Full Name</label>
                <input id="contactName" name="contactName" type="text" placeholder="Jose Rizal" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <div class="field c4">
                <label for="relationship">Relationship</label>
                <select id="relationship" name="relationship" class="select">
                  <option value="Son" selected>Son</option>
                  <option value="Daughter">Daughter</option>
                  <option value="Spouse">Spouse</option>
                  <option value="Sibling">Sibling</option>
                  <option value="Grandchild">Grandchild</option>
                  <option value="Relative">Other relative</option>
                  <option value="Caregiver">Caregiver</option>
                </select>
              </div>
              <div class="field c4">
                <label for="contactNumber">Contact Information</label>
                <input id="contactNumber" name="contactNumber" type="tel" inputmode="numeric" maxlength="11" placeholder="09000000000" required>
                <span class="error" aria-live="polite"></span>
              </div>
              <label class="check c12" for="authorized">
                <input id="authorized" name="authorized" type="checkbox"> <span>Authorized to claim payouts for this senior</span>
              </label>
            </div>
          </div>

          <div class="actions">
            <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
            <button type="submit" class="btn btn-save">Save</button>
          </div>
        </form>
      </section>
    </main>

  </div>

  <script src="assets/js/add.js"></script>
</body>
</html>