<?php
class Bibliotheque
{
   
       private $db;

       public function __construct() {
        $this->connect();
    }
      
       // Connexion à la base de données
       private function connect()
       {
           $user = "root";
           $pass = "";
           $dsn = "mysql:host=localhost;dbname=biblio";
           
           try {
               $this->db = new PDO($dsn, $user, $pass);
               $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $this->db->exec("SET NAMES utf8mb4");
           } catch (PDOException $e) {
               throw new Exception("Erreur de connexion : " . $e->getMessage());
           }
       }
     
   
       // Fermer la connexion
       public function closeConnection()
       {
           $this->db = null;
       }
   

   
       // Méthode unique pour compter les évaluations
       public function getRatingCount($livreId) {
        try {
            if (!$this->db) {
                $this->connect();
            }
            $sql = "SELECT COUNT(*) as count FROM favoris WHERE livre_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $livreId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("Erreur getRatingCount: " . $e->getMessage());
            return 0;
        }
    }
      
       
       // Nouvelle méthode pour la note moyenne
       public function getAverageRating($livreId) {
        try {
            if (!$this->db) {
                $this->connect();
            }
            $sql = "SELECT AVG(note) as moyenne FROM favoris WHERE livre_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $livreId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return round($result['moyenne'] ?? 0, 1);
        } catch (PDOException $e) {
            error_log("Erreur getAverageRating: " . $e->getMessage());
            return 0;
        }
    }
    
    public function checkIfFavorite($user_id, $livre_id) {
        try {
            $this->connect();
            $sql = "SELECT COUNT(*) FROM favoris WHERE user_id = :user_id AND livre_id = :livre_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification des favoris: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    
    public function toggleFavorite($user_id, $livre_id) {
        try {
            $this->connect();
            
            // Vérifier si déjà favori
            if ($this->checkIfFavorite($user_id, $livre_id)) {
                // Supprimer des favoris
                $sql = "DELETE FROM favoris WHERE user_id = :user_id AND livre_id = :livre_id";
            } else {
                // Ajouter aux favoris
                $sql = "INSERT INTO favoris (user_id, livre_id) VALUES (:user_id, :livre_id)";
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return !$this->checkIfFavorite($user_id, $livre_id); // Retourne le nouvel état
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour des favoris: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    public function userExists($user_id) {
        try {
            $this->connect();
            $sql = "SELECT COUNT(*) FROM utilisateurs WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de l'utilisateur: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }


      
      
       
    
       

   
    
    
    public function getLivreById($id) {
        try {
            $this->connect();
            $sql = "SELECT l.*, c.nom as categorie_nom 
                    FROM livre l
                    LEFT JOIN categories c ON l.categories_id = c.id
                    WHERE l.id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du livre: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    
    public function advancedSearch($keyword = '', $categorie = '', $annee = '', $auteur = '') {
        try {
            $this->connect();
            $sql = "SELECT l.*, c.nom as categorie_nom
                    FROM livre l
                    LEFT JOIN categories c ON l.categories_id = c.id
                    WHERE l.status = 'disponible'";
            
            $conditions = [];
            $params = [];
            
            if (!empty($keyword)) {
                $conditions[] = "(l.titre LIKE :keyword OR l.description LIKE :keyword)";
                $params[':keyword'] = "%".$keyword."%";
            }
            
            if (!empty($categorie)) {
                $conditions[] = "l.categories_id = :categorie";
                $params[':categorie'] = $categorie;
            }
            
            if (!empty($annee)) {
                $conditions[] = "l.annee_publication = :annee";
                $params[':annee'] = $annee;
            }
            
            if (!empty($auteur)) {
                $conditions[] = "l.auteur LIKE :auteur";
                $params[':auteur'] = "%".$auteur."%";
            }
            
            if (!empty($conditions)) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }
            
            $sql .= " ORDER BY l.titre ASC";
            
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur recherche avancée: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    
    public function getAnneesDistinctes() {
        try {
            $this->connect();
            $sql = "SELECT DISTINCT annee_publication FROM livre WHERE status = 'disponible' ORDER BY annee_publication DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des années: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    
    public function getCategories() {
        try {
            $this->connect();
            $sql = "SELECT id, nom FROM categories ORDER BY nom";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    // Récupérer toutes les catégories
    public function getAllCategories() {
        try {
            $this->connect();
            $sql = "SELECT id, nom, type, description FROM categories ORDER BY nom";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    
    // Récupérer tous les livres
    public function getAllLivres()  {
    
        try {
            $this->connect();
            $sql = "SELECT l.*, c.nom as categorie_nom 
                    FROM livre l
                    LEFT JOIN categories c ON l.categories_id = c.id
                    WHERE l.status = 'disponible'
                    ORDER BY l.titre ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération: " . $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }
    // Récupérer les commentaires d'un livre
public function getCommentairesByLivreId($livreId) {
    try {
        $this->connect();
        $sql = "SELECT c.*, u.nom as nom_utilisateur 
                FROM commentaires c
                JOIN utilisateurs u ON c.utilisateur_id = u.id
                WHERE c.livre_id = :livre_id
                ORDER BY c.date_creation DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':livre_id', $livreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getCommentairesByLivreId: " . $e->getMessage());
        return [];
    } finally {
        $this->closeConnection();
    }
}

// Ajouter un commentaire
public function ajouterCommentaire($livreId, $utilisateurId, $contenu) {
    try {
        $this->connect();
        $sql = "INSERT INTO commentaires (livre_id, utilisateur_id, contenu) 
                VALUES (:livre_id, :utilisateur_id, :contenu)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':livre_id', $livreId, PDO::PARAM_INT);
        $stmt->bindParam(':utilisateur_id', $utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    } catch (PDOException $e) {
        error_log("Erreur ajouterCommentaire: " . $e->getMessage());
        return false;
    } finally {
        $this->closeConnection();
    }
}

public function getCommentaires($livre_id) {
    try {
        $this->connect();
        $sql = "SELECT * FROM commentaires 
                WHERE livre_id = :livre_id 
                ORDER BY date_creation DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des commentaires: " . $e->getMessage());
    } finally {
        $this->closeConnection();
    }
}

    // Ajouter une categories
    public function ajoutercategories($nom_categories)
    {
        try {
            $this->connect();
            $sql = "INSERT INTO categories (nom_categories) VALUES (:nom_categories)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nom_categories', $nom_categories);
            $result = $stmt->execute();
            $this->closeConnection();
            return $result;
        } catch (PDOException $e) {
            $this->closeConnection();
            throw new Exception("Erreur lors de l'ajout de la categories: " . $e->getMessage());
        }
    }
    // Ajouter un livre
public function ajouterLivre(
    $titre,
    $auteur,
    $categorie,
    $annee_publication,
    $nombre_pages,
    $description,
    $pdf_path,
    $image_path = null,
    $id_utilisateur = null
) {
    try {
        $this->connect();
        
        $sql = "INSERT INTO livre (titre, auteur, categorie, annee_publication, 
                nombre_pages, description, pdf_path, image_path, id_utilisateur) 
                VALUES (:titre, :auteur, :categorie, :annee_publication, 
                :nombre_pages, :description, :pdf_path, :image_path, :id_utilisateur)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->bindParam(':annee_publication', $annee_publication, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_pages', $nombre_pages, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':pdf_path', $pdf_path);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);

        $result = $stmt->execute();
        $this->closeConnection();
        return $result;
    } catch (PDOException $e) {
        $this->closeConnection();
        throw new Exception("Erreur lors de l'ajout du livre : " . $e->getMessage());
    }
}
   
}
    
   
    
