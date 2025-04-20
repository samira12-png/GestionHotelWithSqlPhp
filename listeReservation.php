<?php
$conn = mysqli_connect("localhost", "root", "", "gestion_hotel");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les types d'hôtels pour la liste déroulante
$types = mysqli_query($conn, "SELECT * FROM typehotel");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['type'])) {
    $typeId = mysqli_real_escape_string($conn, $_POST['type']);
    
    $sql = "SELECT r.*, h.titre, c.nom, c.prenom 
            FROM reservation r
            JOIN hotel h ON r.iid_hotel = h.id_hotel
            JOIN client c ON r.iid_client = c.id_client
            WHERE h.iid_type = '$typeId'";
    $reservations = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Réservations par Type d'Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
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
    <h1 class="text-center p-5">Réservations par Type d'Hôtel</h1>
    <form method="POST">
        <label>Sélectionnez un type d'hôtel:
            <select class="form-select" name="type" required>
                <?php while($type = mysqli_fetch_assoc($types)): ?>
                <option value="<?php echo $type['id_type']; ?>">
                    <?php echo $type['nombre_étolle']; ?> étoiles
                </option>
                <?php endwhile; ?>
            </select>
        </label>
        <button class="btn btn-primary" type="submit">Afficher</button>
    </form>

    <?php if (isset($reservations)): ?>
    <h2 class="text-center p-3 text-warning">Résultats</h2>
    <table class="table table-striped">
        <tr>
            <th>ID Réservation</th>
            <th>Hôtel</th>
            <th>Client</th>
            <th>Date début</th>
            <th>Date fin</th>
        </tr>
        <?php while($res = mysqli_fetch_assoc($reservations)): ?>
        <tr>
            <td><?php echo $res['id_reserv']; ?></td>
            <td><?php echo $res['titre']; ?></td>
            <td><?php echo $res['prenom'] . ' ' . $res['nom']; ?></td>
            <td><?php echo $res['date_debut_sejour']; ?></td>
            <td><?php echo $res['date_fin_sejour']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</body>
</html>

<?php
mysqli_close($conn);
?>