<?php
// Dashboard.php — Main OSCA Records System Dashboard
session_start();

require_once __DIR__ . '/includes/db.php';

$totalSeniors = 0;
$addedThisMonth = 0;
$addedThisWeek = 0;
$recentSeniors = [];

try {
    // 1. Get Total Seniors Count
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM senior_citizens");
    $totalSeniors = $stmtTotal->fetchColumn();

    // 2. Get Added This Month Count
    $stmtMonth = $pdo->query("SELECT COUNT(*) FROM senior_citizens WHERE MONTH(registration_date) = MONTH(CURRENT_DATE()) AND YEAR(registration_date) = YEAR(CURRENT_DATE())");
    $addedThisMonth = $stmtMonth->fetchColumn();

    // 3. Get Added This Week Count
    $stmtWeek = $pdo->query("SELECT COUNT(*) FROM senior_citizens WHERE YEARWEEK(registration_date, 1) = YEARWEEK(CURRENT_DATE(), 1)");
    $addedThisWeek = $stmtWeek->fetchColumn();

    // 4. Fetch Recently Added Seniors (Latest 7 records)
    $stmtRecent = $pdo->query("SELECT first_name, middle_name, last_name, age, purok, birth_date, application_status FROM senior_citizens ORDER BY id DESC LIMIT 7");
    $recentSeniors = $stmtRecent->fetchAll();

} catch (PDOException $e) {
    $dbError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | OSCA Records System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
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
        <a class="nav-link active" href="Dashboard.php" aria-current="page"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a class="nav-link" href="list.php"><i class="bi bi-person-fill"></i> List</a>
        <a class="nav-link" href="reports.php"><i class="bi bi-files"></i> Reports</a>
      </nav>

      <a class="nav-link logout" href="login.html"><i class="bi bi-box-arrow-left"></i> Log out</a>
    </aside>

    <!-- Main -->
    <main class="main">
      <section class="stats" aria-label="Summary">
        <article class="stat">
          <span class="stat-icon blue"><i class="bi bi-people-fill"></i></span>
          <div>
            <span class="stat-label">Total Seniors</span>
            <strong class="stat-value"><?php echo htmlspecialchars($totalSeniors); ?></strong>
          </div>
        </article>
        <article class="stat">
          <span class="stat-icon green"><i class="bi bi-wallet2"></i></span>
          <div>
            <span class="stat-label">Added This Month</span>
            <strong class="stat-value"><?php echo htmlspecialchars($addedThisMonth); ?></strong>
          </div>
        </article>
        <article class="stat">
          <span class="stat-icon yellow"><i class="bi bi-clock-fill"></i></span>
          <div>
            <span class="stat-label">Added This Week</span>
            <strong class="stat-value"><?php echo htmlspecialchars($addedThisWeek); ?></strong>
          </div>
        </article>
      </section>

      <section class="panel" aria-labelledby="recentTitle">
        <div class="panel-head">
          <h2 id="recentTitle">Recently Added Seniors</h2>
          <a class="btn-add" href="add.php"><i class="bi bi-plus-circle"></i> Add</a>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead class="sr-only">
              <tr><th scope="col">Name</th><th scope="col">Age</th><th scope="col">Purok</th><th scope="col">Birthdate</th><th scope="col">Status</th></tr>
            </thead>
            <tbody id="seniorRows">
              <?php if (count($recentSeniors) > 0): ?>
                <?php foreach ($recentSeniors as $row): ?>
                  <?php 
                    $fullName = trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                    $formattedDate = date("M j, Y", strtotime($row['birth_date']));
                    $status = $row['application_status'] ?? 'Pending';
                  ?>
                  <tr data-name="<?php echo htmlspecialchars($fullName); ?>">
                    <td><?php echo htmlspecialchars($fullName); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['purok']); ?></td>
                    <td><time datetime="<?php echo htmlspecialchars($row['birth_date']); ?>"><?php echo htmlspecialchars($formattedDate); ?></time></td>
                    <td>
                      <select class="select status-select" aria-label="Status for <?php echo htmlspecialchars($fullName); ?>">
                        <option value="pending" <?php echo ($status === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="paid" <?php echo ($status === 'Paid') ? 'selected' : ''; ?>>Paid</option>
                      </select>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" style="text-align: center; color: #4a4a4a; padding: 20px;">No records found in database yet.</td>
                </tr>
              <?php endif; ?>
              <tr class="empty-row" id="emptyRow" hidden>
                <td colspan="5">No seniors found. Try a different name or status.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>

  </div>
</body>
</html>