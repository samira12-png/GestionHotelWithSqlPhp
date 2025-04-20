<?php
// supprimerH.php
if(isset($_GET['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "gestion_hotel");
    
    // Vérifier la connexion
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $id =  $_GET['id'];
    

        // Supprimer l'hôtel
        $deleteSql = "DELETE FROM hotel WHERE id_hotel = '$id'";
        if (mysqli_query($conn, $deleteSql)) {
            header("Location: listerH.php"); // Redirection après suppression
            exit();
        } else {
            echo "Erreur lors de la suppression: " . mysqli_error($conn);
        }
    
    
    // Fermer la connexion
    mysqli_close($conn);
}
?>