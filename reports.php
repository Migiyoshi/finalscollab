<?php
// reports.php — Reports & Export Module connected to MySQL
require_once __DIR__ . '/includes/db.php';

// Get filter inputs from URL parameters (defaults)
$birthMonth = $_GET['birth_month'] ?? 'all';
$purok = $_GET['purok'] ?? 'all';
$pensionStatus = $_GET['pension'] ?? 'all';
$searchName = trim($_GET['search'] ?? '');

try {
    // Base query
    $sql = "SELECT * FROM senior_citizens WHERE 1=1";
    $params = [];

    // Filter by Birth Month if selected
    if ($birthMonth !== 'all' && is_numeric($birthMonth)) {
        $sql .= " AND MONTH(birth_date) = ?";
        $params[] = $birthMonth;
    }

    // Filter by Purok if selected
    if ($purok !== 'all') {
        $sql .= " AND purok = ?";
        $params[] = $purok;
    }

    // Filter by Pension Status if selected
    if ($pensionStatus !== 'all') {
        $sql .= " AND pension_status = ?";
        $params[] = $pensionStatus;
    }

    // Filter by Name search if entered
    if ($searchName !== '') {
        $sql .= " AND (first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ?)";
        $searchTerm = "%" . $searchName . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $filteredSeniors = $stmt->fetchAll();

    // Get overall total registered count for the header
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM senior_citizens");
    $totalRegistered = $stmtTotal->fetchColumn();

} catch (PDOException $e) {
    $dbError = $e->getMessage();
    $filteredSeniors = [];
    $totalRegistered = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports | OSCA Records System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/list.css">
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
        <a class="nav-link" href="list.php"><i class="bi bi-person-fill"></i> List</a>
        <a class="nav-link active" href="reports.php" aria-current="page"><i class="bi bi-files"></i> Reports</a>
      </nav>

      <a class="nav-link logout" href="login.html"><i class="bi bi-box-arrow-left"></i> Log out</a>
    </aside>

    <!-- Main -->
    <main class="main">
      <section class="panel panel-lg" aria-labelledby="reportTitle">
        <div class="panel-head">
          <div>
            <h2 id="reportTitle">Senior Citizens Reports</h2>
            <p class="panel-sub"><?php echo htmlspecialchars($totalRegistered); ?> Total Registered</p>
          </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="reports.php" class="toolbar" style="gap: 15px; display: flex; flex-wrap: wrap; align-items: center;">
          
          <!-- Search Bar for Name -->
          <div class="search" style="flex: 1; min-width: 220px; display: flex; align-items: center; background: #fff; border: 1px solid #cbd5e1; border-radius: 6px; padding: 0 12px;">
            <i class="bi bi-search" aria-hidden="true" style="color: #64748b; margin-right: 8px;"></i>
            <input name="search" type="search" value="<?php echo htmlspecialchars($searchName); ?>" placeholder="Search by Name..." aria-label="Search by name" autocomplete="off" style="border: none; outline: none; width: 100%; padding: 10px 0; font-family: inherit;" onchange="this.form.submit()">
          </div>

          <!-- Birth Month Filter -->
          <select name="birth_month" class="select select-lg" onchange="this.form.submit()">
            <option value="all" <?php echo ($birthMonth === 'all') ? 'selected' : ''; ?>>All Birth Months</option>
            <option value="1" <?php echo ($birthMonth === '1') ? 'selected' : ''; ?>>January</option>
            <option value="2" <?php echo ($birthMonth === '2') ? 'selected' : ''; ?>>February</option>
            <option value="3" <?php echo ($birthMonth === '3') ? 'selected' : ''; ?>>March</option>
            <option value="4" <?php echo ($birthMonth === '4') ? 'selected' : ''; ?>>April</option>
            <option value="5" <?php echo ($birthMonth === '5') ? 'selected' : ''; ?>>May</option>
            <option value="6" <?php echo ($birthMonth === '6') ? 'selected' : ''; ?>>June</option>
            <option value="7" <?php echo ($birthMonth === '7') ? 'selected' : ''; ?>>July</option>
            <option value="8" <?php echo ($birthMonth === '8') ? 'selected' : ''; ?>>August</option>
            <option value="9" <?php echo ($birthMonth === '9') ? 'selected' : ''; ?>>September</option>
            <option value="10" <?php echo ($birthMonth === '10') ? 'selected' : ''; ?>>October</option>
            <option value="11" <?php echo ($birthMonth === '11') ? 'selected' : ''; ?>>November</option>
            <option value="12" <?php echo ($birthMonth === '12') ? 'selected' : ''; ?>>December</option>
          </select>

          <!-- Purok Filter -->
          <select name="purok" class="select select-lg" onchange="this.form.submit()">
            <option value="all" <?php echo ($purok === 'all') ? 'selected' : ''; ?>>All Puroks</option>
            <option value="Purok 1" <?php echo ($purok === 'Purok 1') ? 'selected' : ''; ?>>Purok 1</option>
            <option value="Purok 2" <?php echo ($purok === 'Purok 2') ? 'selected' : ''; ?>>Purok 2</option>
            <option value="Purok 3" <?php echo ($purok === 'Purok 3') ? 'selected' : ''; ?>>Purok 3</option>
            <option value="Purok 4" <?php echo ($purok === 'Purok 4') ? 'selected' : ''; ?>>Purok 4</option>
            <option value="Purok 5" <?php echo ($purok === 'Purok 5') ? 'selected' : ''; ?>>Purok 5</option>
            <option value="Purok 6" <?php echo ($purok === 'Purok 6') ? 'selected' : ''; ?>>Purok 6</option>
          </select>

          <!-- Pension Filter -->
          <select name="pension" class="select select-lg" onchange="this.form.submit()">
            <option value="all" <?php echo ($pensionStatus === 'all') ? 'selected' : ''; ?>>All Pension Status</option>
            <option value="Pension Beneficiary" <?php echo ($pensionStatus === 'Pension Beneficiary') ? 'selected' : ''; ?>>Pension Beneficiary</option>
            <option value="Not Pension Beneficiary" <?php echo ($pensionStatus === 'Not Pension Beneficiary') ? 'selected' : ''; ?>>Not Pension Beneficiary</option>
          </select>
        </form>

        <div class="table-wrap" style="margin-top: 20px;">
          <table class="table table-list">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Purok</th>
                <th scope="col">Age</th>
                <th scope="col">Birth Month</th>
                <th scope="col">Pension Receiver</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $totalCount = count($filteredSeniors);
              $beneficiaryCount = 0;
              if ($totalCount > 0): 
                foreach ($filteredSeniors as $row): 
                  $fullName = trim($row['first_name'] . ' ' . (!empty($row['middle_name']) ? $row['middle_name'] . ' ' : '') . $row['last_name']);
                  $pBenefit = $row['pension_status'] ?? 'Not Pension Beneficiary';
                  $birthMonthName = !empty($row['birth_date']) ? date("F", strtotime($row['birth_date'])) : 'N/A';
                  if (strpos($pBenefit, 'Not') === false) {
                      $beneficiaryCount++;
                  }
              ?>
                <tr>
                  <td><?php echo htmlspecialchars($fullName); ?></td>
                  <td><?php echo htmlspecialchars($row['purok']); ?></td>
                  <td><?php echo htmlspecialchars($row['age']); ?></td>
                  <td><?php echo htmlspecialchars($birthMonthName); ?></td>
                  <td><?php echo htmlspecialchars($pBenefit); ?></td>
                </tr>
              <?php 
                endforeach; 
              else: 
              ?>
                <tr>
                  <td colspan="5" style="text-align: center; padding: 25px; color: var(--ink-soft);">No records match the selected report filters.</td>
                </tr>
              <?php endif; ?>

              <!-- Summary Totals Row -->
              <tr style="font-weight: bold; background: #f8fafc;">
                <td>Total Filtered</td>
                <td><?php echo $totalCount; ?> Seniors</td>
                <td>-</td>
                <td>-</td>
                <td><?php echo $beneficiaryCount; ?> Beneficiaries</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
          <button type="button" class="btn btn-primary" onclick="window.print()" style="background: #0f172a; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;"><i class="bi bi-printer"></i> Print</button>
        </div>
      </section>
    </main>

  </div>
</body>
</html>