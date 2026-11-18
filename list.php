<?php
// list.php — Senior Citizen Management List
require_once __DIR__ . '/includes/db.php';

$seniors = [];
$totalRegistered = 0;

try {
    // 1. Get total count of registered seniors
    $stmtCount = $pdo->query("SELECT COUNT(*) FROM senior_citizens");
    $totalRegistered = $stmtCount->fetchColumn();

    // 2. Fetch all senior citizen records from database
    $stmt = $pdo->query("SELECT * FROM senior_citizens ORDER BY id DESC");
    $seniors = $stmt->fetchAll();

} catch (PDOException $e) {
    $dbError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Senior Citizens | OSCA Records System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
        <a class="nav-link active" href="list.php" aria-current="page"><i class="bi bi-person-fill"></i> List</a>
        <a class="nav-link" href="reports.php"><i class="bi bi-files"></i> Reports</a>
      </nav>

      <a class="nav-link logout" href="login.html"><i class="bi bi-box-arrow-left"></i> Log out</a>
    </aside>

    <!-- Main -->
    <main class="main">
      <section class="panel panel-lg" aria-labelledby="listTitle">
        <div class="panel-head">
          <div>
            <h2 id="listTitle">Senior Citizens</h2>
            <p class="panel-sub"><?php echo htmlspecialchars($totalRegistered); ?> Registered</p>
          </div>
          <!-- Updated to point to add.php -->
          <a class="btn-add" href="add.php"><i class="bi bi-plus-circle"></i> Add</a>
        </div>

        <div class="toolbar">
          <div class="search">
            <i class="bi bi-search" aria-hidden="true"></i>
            <input id="search" type="search" placeholder="Search by Name" aria-label="Search by name" autocomplete="off">
          </div>
          <select id="statusFilter" class="select select-lg" aria-label="Filter by status">
            <option value="all">All Status</option>
            <option value="Pension Beneficiary">Pension Beneficiary</option>
            <option value="Not Pension Beneficiary">Not Pension Beneficiary</option>
          </select>
        </div>

        <div class="table-wrap">
          <table class="table table-list">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Purok</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Change Status</th>
              </tr>
            </thead>
            <tbody id="seniorRows">
              <?php if (count($seniors) > 0): ?>
                <?php foreach ($seniors as $row): ?>
                  <?php 
                    $fullName = trim($row['first_name'] . ' ' . (!empty($row['middle_name']) ? $row['middle_name'] . ' ' : '') . $row['last_name']);
                    $formattedBirthDate = date("M j, Y", strtotime($row['birth_date']));
                    $pensionStatus = $row['pension_status'] ?? 'Not Pension Beneficiary';
                  ?>
                  <tr data-name="<?php echo htmlspecialchars($fullName); ?>" data-status="<?php echo htmlspecialchars($pensionStatus); ?>">
                    <td><?php echo htmlspecialchars($fullName); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['purok']); ?></td>
                    <td><time datetime="<?php echo htmlspecialchars($row['birth_date']); ?>"><?php echo htmlspecialchars($formattedBirthDate); ?></time></td>
                    <td>
                      <select class="select status-select" aria-label="Status for <?php echo htmlspecialchars($fullName); ?>">
                        <option value="Pension Beneficiary" <?php echo (strpos($pensionStatus, 'Pension Beneficiary') !== false && strpos($pensionStatus, 'Not') === false) ? 'selected' : ''; ?>>Pension Beneficiary</option>
                        <option value="Not Pension Beneficiary" <?php echo (strpos($pensionStatus, 'Not') !== false) ? 'selected' : ''; ?>>Not Pension Beneficiary</option>
                      </select>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" style="text-align: center; padding: 25px; color: var(--ink-soft);">No records found in database.</td>
                </tr>
              <?php endif; ?>
              <tr class="empty-row" id="emptyRow" hidden>
                <td colspan="5">No seniors found. Try a different name or status.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <nav class="pager" aria-label="Pagination">
          <button type="button" aria-label="Previous page"><i class="bi bi-chevron-left"></i></button>
          <button type="button" aria-current="page">1</button>
          <button type="button">2</button>
          <button type="button">3</button>
          <button type="button" aria-label="Next page"><i class="bi bi-chevron-right"></i></button>
        </nav>
      </section>
    </main>

  </div>

  <script>
    // Search by name + filter by status dynamically reading database rows
    const rows = [...document.querySelectorAll("#seniorRows tr[data-name]")];
    const search = document.getElementById("search");
    const filter = document.getElementById("statusFilter");
    const emptyRow = document.getElementById("emptyRow");

    function applyFilters() {
      const term = search.value.trim().toLowerCase();
      const status = filter.value;
      let shown = 0;
      
      rows.forEach((row) => {
        const matchName = row.dataset.name.toLowerCase().includes(term);
        const currentSelectVal = row.querySelector(".status-select").value;
        const matchStatus = status === "all" || currentSelectVal === status;
        
        row.hidden = !(matchName && matchStatus);
        if (!row.hidden) shown++;
      });
      
      emptyRow.hidden = shown > 0;
    }

    search.addEventListener("input", applyFilters);
    filter.addEventListener("change", applyFilters);
    document.querySelectorAll(".status-select").forEach((s) => s.addEventListener("change", applyFilters));
  </script>
</body>
</html>