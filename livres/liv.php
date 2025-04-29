<?php
require 'class.php';

$obj = new Bibliotheque();

// Récupérer les critères de recherche
$keyword = $_GET['keyword'] ?? '';
$categorie = $_GET['categorie'] ?? '';
$annee = $_GET['annee'] ?? '';
$auteur = $_GET['auteur'] ?? '';

// Recherche dans la base de données
$livres = $obj->advancedSearch($keyword, $categorie, $annee, $auteur);

// Récupérer les données pour les filtres
$categories = $obj->getAllCategories();
$annees = $obj->getAnneesDistinctes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique - Livres</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="liv.css">
</head>
<body>
    <?php include 'header.html'; ?>
    
    <div class="container">
        <form method="GET" id="searchForm" class="search-filter">
            <div class="search-bar">
                <input type="text" name="keyword" placeholder="Rechercher..." 
                       value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit"><i class="fas fa-search"></i> Rechercher</button>
            </div>
            
            <div class="filter-options">
                <div class="filter-group">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie" class="auto-submit">
                        <option value="">Toutes</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $categorie == $c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="annee">Année</label>
                    <select id="annee" name="annee" class="auto-submit">
                        <option value="">Toutes</option>
                        <?php foreach ($annees as $a): ?>
                            <option value="<?= $a ?>" <?= $annee == $a ? 'selected' : '' ?>>
                                <?= $a ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" placeholder="Filtrer par auteur"
                           value="<?= htmlspecialchars($auteur) ?>" class="auto-submit">
                </div>
            </div>
        </form>
        
        <div class="livres-container">
            <?php if (empty($livres)): ?>
                <div class="no-results">
                    <i class="fas fa-info-circle"></i>
                    <p>Aucun livre trouvé correspondant aux critères de recherche</p>
                </div>
            <?php else: ?>
                <?php foreach ($livres as $livre): 
                    $shortTitle = mb_strlen($livre['titre']) > 40 ? mb_substr($livre['titre'], 0, 37).'...' : $livre['titre'];
                    $shortAuthor = mb_strlen($livre['auteur']) > 25 ? mb_substr($livre['auteur'], 0, 22).'...' : $livre['auteur'];
                ?>
                    <a href="livre.php?id=<?= $livre['id'] ?>" class="livre-card">
                        <div class="image-container">
                            <?php if (!empty($livre['image'])): ?>
                                <img src="uploads/covers/<?= htmlspecialchars($livre['image']) ?>" 
                                     class="livre-cover"
                                     alt="<?= htmlspecialchars($shortTitle) ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="no-cover">
                                    <i class="fas fa-book"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-content">
                            <h3 class="livre-title"><?= htmlspecialchars($shortTitle) ?></h3>
                            <p class="livre-author"><?= htmlspecialchars($shortAuthor) ?></p>
                           
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.auto-submit').forEach(element => {
            element.addEventListener('change', function() {
                document.getElementById('searchForm').submit();
            });
        });
    </script>
    <script src="darkMode.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>