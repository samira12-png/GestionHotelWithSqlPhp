<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$conn = mysqli_connect("localhost", "root", "", "gestion_hotel");


    // Vérifier la connexion
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Récupérer et échapper les données
    // Version minimaliste (non recommandée pour production)
    $titre = trim($_POST['titre']);
    $adresse = trim($_POST['adresse']);
    $prix = (float)$_POST['prix'];
    $type = (int)$_POST['type'];
    $places = (int)$_POST['places'];
    
    // Requête d'insertion
    $sql = "INSERT INTO hotel (titre, adresse, prix_par_nuit, iid_type, nombre_de_places)
            VALUES ('$titre', '$adresse', '$prix', '$type', '$places')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: listerH.php"); // Redirection après ajout
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
} else {
    // Afficher le formulaire
    $conn = mysqli_connect("localhost", "root", "", "gestion_hotel");
    $types = mysqli_query($conn, "SELECT * FROM typehotel");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Ajouter un Hôtel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    </head>
    <body>
<div class="container">
<nav class="navbar navbar-dark bg-primary mb-4">
  <div class="container">
    <span class="navbar-brand fw-bold">MyHotel</span>
    <div class="d-flex gap-2">
      <a class="btn btn-light btn-sm" href="ajouterH.php">Ajouter</a>
      <a class="btn btn-light btn-sm" href="listerH.php">Hôtels</a>
      <a class="btn btn-light btn-sm" href="listeReservation.php">Réservations</a>
      <a class="btn btn-light btn-sm" href="reservEnCours.php">En Cours</a>
    </div>
  </div>
</nav>
<h1 class="text-center p-3">Ajouter un nouvel hôtel</h1>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="row g-3 p-3 border border-3 m-auto">
            <label>Titre: <input class="form-control"  type="text" name="titre" required></label><br>
            <label>Adresse: <input class="form-control" type="text" name="adresse" required></label><br>
            <label>Prix par nuit: <input class="form-control" type="number" name="prix" required></label><br>
            <label>Type d'hôtel:
                <select name="type" class="form-select" required>
                    <?php while($type = mysqli_fetch_assoc($types)): ?>
                    <option value="<?php echo $type['id_type']; ?>">
                        <?php echo $type['nombre_étolle']; ?> étoiles
                    </option>
                    <?php endwhile; ?>
                </select>
            </label><br>
            <label>Nombre de places: <input class="form-control" type="number" name="places" required></label><br>
            <button class="btn btn-info" type="submit">Ajouter</button>
        </form>
        <a class="btn btn-success mt-4" href="listerH.php">Voir la liste</a>

</div>
    </body>
    </html>
    <?php
    mysqli_close($conn);
}
?>