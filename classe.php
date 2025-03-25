<?php
class bibliotaque {
    private $db;

    // Connexion à la base de données
    public function connect() {
        $user = "root";
        $pass = "";
        $dsn = "mysql:host=localhost;dbname=pfe";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Ajouter un mémoire
    public function ajouterMemoire($universite, $filiere, $specialite, $diplome, 
                                 $titre, $encadreur, $auteur, $annee, 
                                 $resume, $fichier_pdf) {
        try {
            // Établir la connexion
            $this->connect();
            
            // Préparation de la requête SQL
            $sql = "INSERT INTO memoires (universite, filiere, specialite, diplome, 
                                        titre, encadreur, auteur, annee, 
                                        resume, fichier_pdf) 
                    VALUES (:universite, :filiere, :specialite, :diplome, 
                           :titre, :encadreur, :auteur, :annee, 
                           :resume, :fichier_pdf)";
            
            $stmt = $this->db->prepare($sql);
            
            // Liaison des paramètres
            $stmt->bindParam(':universite', $universite);
            $stmt->bindParam(':filiere', $filiere);
            $stmt->bindParam(':specialite', $specialite);
            $stmt->bindParam(':diplome', $diplome);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':encadreur', $encadreur);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':annee', $annee, PDO::PARAM_INT);
            $stmt->bindParam(':resume', $resume);
            $stmt->bindParam(':fichier_pdf', $fichier_pdf);
            
            // Exécution de la requête
            $result = $stmt->execute();
            
            // Fermeture de la connexion
            $this->closeConnection();
            
            return $result;
            
        } catch (PDOException $e) {
            // Fermeture de la connexion en cas d'erreur
            $this->closeConnection();
            throw new Exception("Erreur lors de l'ajout : " . $e->getMessage());
        }
    }

    // Fermer la connexion
    public function closeConnection() {
        if ($this->db !== null) {
            $this->db = null;
        }
    }
}
?>
