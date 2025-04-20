<?php
$conn = mysqli_connect("localhost", "root", "", "gestion_hotel");


// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Requête pour récupérer tous les hôtels
$sql = "SELECT h.*, t.nombre_étolle 
        FROM hotel h 
        JOIN typehotel t ON h.iid_type = t.id_type";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Hôtels</title>
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
    <h1 class="text-center text-warning p-5">Liste des Hôtels</h1>
    <table class="table table-hover mt-5">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Adresse</th>
            <th>Prix par nuit</th>
            <th>Nombre d'étoiles</th>
            <th>Places disponibles</th>
            <th>Action</th>
        </tr>
        <?php while($hotel = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $hotel['id_hotel']; ?></td>
            <td><?php echo $hotel['titre']; ?></td>
            <td><?php echo $hotel['adresse']; ?></td>
            <td><?php echo $hotel['prix_par_nuit']; ?></td>
            <td><?php echo $hotel['nombre_étolle']; ?></td>
            <td><?php echo $hotel['nombre_de_places']; ?></td>
            <td>
                <a class="btn btn-danger" href="supprimerH.php?id=<?php echo $hotel['id_hotel']; ?>" 
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet hôtel?')">
                   Supprimer
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    </div>
</body>
</html>

<?php
// Fermer la connexion
mysqli_close($conn);
?>