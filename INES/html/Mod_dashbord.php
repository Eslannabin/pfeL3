<?php
// Start session and include config
session_start();
require 'a111.php';

// Get current moderator name from session
$moderatorName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Modérateur';
?>

<div class="main-content">
  <!-- Dashboard Header -->
  <header class="dashboard-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1><i class="fas fa-user-shield me-2"></i>Tableau de Bord Modérateur</h1>
        </div>
        <div class="col-md-6 text-end">
          <span class="badge bg-light text-dark me-2">
            <i class="fas fa-bell"></i> 3
          </span>
          <span class="badge bg-light text-dark">
            <i class="fas fa-user"></i> <?= htmlspecialchars($moderatorName) ?> (Modérateur)
          </span>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <!-- Statistics  -->
    <div class="row">
      <?php
      try {
        // Get statistics 
        $stats = [
          'total' => 0,
          'pending' => 0,
          'approved' => 0,
          'rejected' => 0
        ];

        // Total submissions
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM memoires");
        $stats['total'] = $stmt->fetchColumn();

        // Pending
        $stmt = $pdo->prepare("SELECT COUNT(*) as pending FROM memoires WHERE status = 'en_attente'");
        $stmt->execute();
        $stats['pending'] = $stmt->fetchColumn();

        // Accepter
        $stmt = $pdo->prepare("SELECT COUNT(*) as approved FROM memoires WHERE status = 'accepter'");
        $stmt->execute();
        $stats['approved'] = $stmt->fetchColumn();

        // Rejeter
        $stmt = $pdo->prepare("SELECT COUNT(*) as rejected FROM memoires WHERE status = 'refuser'");
        $stmt->execute();
        $stats['rejected'] = $stmt->fetchColumn();
      } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $stats = [
          'total' => 'N/A',
          'pending' => 'N/A',
          'approved' => 'N/A',
          'rejected' => 'N/A'
        ];
      }
      ?>

      <div class="col-md-3">
        <div class="stat-card text-center text-primary">
          <i class="fas fa-file-alt"></i>
          <h3><?= htmlspecialchars($stats['total']) ?></h3>
          <p>Soumissions Totales</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card text-center text-warning">
          <i class="fas fa-clock"></i>
          <h3><?= htmlspecialchars($stats['pending']) ?></h3>
          <p>En Attente</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card text-center text-success">
          <i class="fas fa-check-circle"></i>
          <h3><?= htmlspecialchars($stats['approved']) ?></h3>
          <p>Approuvés</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card text-center text-danger">
          <i class="fas fa-times-circle"></i>
          <h3><?= htmlspecialchars($stats['rejected']) ?></h3>
          <p>Rejetés</p>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="row mt-6w">
      <!-- Pending Actions -->
      <div class="col-md-8">
        <div class="pending-actions">
          <h3><i class="fas fa-tasks me-2"></i>Actions en Attente</h3>
          <hr>

          <div class="action-items">
            <?php
            try {
              // Query to get pending memoires using PDO
              $stmt = $pdo->prepare("SELECT id, titre, auteur, date_ajout, universite, filiere 
                                      FROM memoires 
                                      WHERE status = 'en_attente'
                                      ORDER BY date_ajout DESC 
                                      LIMIT 3");
              $stmt->execute();

              if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  // Calculate time difference
                  $submissionTime = new DateTime($row['date_ajout']);
                  $currentTime = new DateTime();
                  $interval = $submissionTime->diff($currentTime);

                  $timeText = "";
                  if ($interval->d > 0) {
                    $timeText = "il y a " . $interval->d . " jour" . ($interval->d > 1 ? "s" : "");
                  } elseif ($interval->h > 0) {
                    $timeText = "il y a " . $interval->h . " heure" . ($interval->h > 1 ? "s" : "");
                  } else {
                    $timeText = "il y a " . $interval->i . " minute" . ($interval->i > 1 ? "s" : "");
                  }

                  echo '
                        <div class="action-item" data-id="' . htmlspecialchars($row['id']) . '">
                            <h5>Nouvelle soumission de mémoire</h5>
                            <p><strong>Université:</strong> ' . htmlspecialchars($row['universite']) . '</p>
                            <p><strong>Filière:</strong> ' . htmlspecialchars($row['filiere']) . '</p>
                            <p><strong>Titre:</strong> "' . htmlspecialchars($row['titre']) . '"</p>
                            <p><strong>Soumis par:</strong> ' . htmlspecialchars($row['auteur']) . ' (' . $timeText . ')</p>
                            <div>
                                <button class="btn btn-sm btn-success me-2 approve-btn">Approuver</button>
                                <button class="btn btn-sm btn-danger me-2 reject-btn">Rejeter</button>
                                <a href="Gestion_memoires_mod.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-outline-secondary">Voir détails</a>
                            </div>
                        </div>';
                }
              } else {
                echo '<div class="alert alert-info">Aucune action en attente.</div>';
              }
            } catch (PDOException $e) {
              error_log("Database error: " . $e->getMessage());
              echo '<div class="alert alert-danger">Erreur de chargement des données.</div>';
            }
            ?>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="pending-actions">
          <h3><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
          <hr>

          <div class="quick-actions text-center">
            <button class="btn btn-primary">
              <i class="fas fa-search me-2"></i>Search Content
            </button>
            <button class="btn btn-success">
              <i class="fas fa-user-plus me-2"></i>Add User
            </button>
            <button class="btn btn-warning">
              <i class="fas fa-ban me-2"></i>Ban User
            </button>
            <button class="btn btn-info">
              <i class="fas fa-chart-bar me-2"></i>View Reports
            </button>
            <button class="btn btn-secondary">
              <i class="fas fa-cog me-2"></i>Settings
            </button>
          </div>

          <hr>

          <h5><i class="fas fa-history me-2"></i>Recent Activity</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Approved thesis "AI in Education"</li>
            <li class="list-group-item">Rejected spam comment</li>
            <li class="list-group-item">Updated moderation guidelines</li>
          </ul>
        </div>

      </div>
    </div>
  </div>