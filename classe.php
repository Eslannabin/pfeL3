<?php

class bibliotaque {
    //connexion à la base de données
    function connect(){
        $user="root";
        $pass="";
        $dsn="mysql:host=localhost;dbname=pfe";
        try{
            $db=new PDO($dsn,$user,$pass);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $db;
    }
   
    //ajouter un mémoire
    function ajouterMemoire($universite,$filiere,$specialite,$diplome,$titre,$encadreur,$auteur,$annee){
        $db=$this->connect();
        $sql="INSERT INTO memoires(universite,filiere,specialite,diplome,titre,encadreur,auteur,annee) VALUES(?,?,?,?,?,?,?,?)";
        $stmt=$db->prepare($sql);
        $stmt->execute([$universite,$filiere,$specialite,$diplome,$titre,$encadreur,$auteur,$annee]);
    }


}
?>