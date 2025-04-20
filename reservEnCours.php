
<?php
session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: connexion.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "gestion_hotel");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Afficher les informations du client (partie 5b - 4 pts)

// Partie 6 - Afficher les réservations en cours (6 pts)
$clientId = $_SESSION['client_id'];
$sql = "SELECT r.*, h.titre 
        FROM reservation r
        JOIN hotel h ON r.iid_hotel = h.id_hotel
        WHERE r.iid_client = '$clientId' AND r.date_fin_sejour >= CURDATE()";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<h2 class="text-center p-3 text-primary">
    Bienvenue <?= htmlspecialchars($_SESSION['client_nom'] ?? '') ?> 
    (CIN: <?= htmlspecialchars($_SESSION['client_cin'] ?? 'Non défini') ?>)
</h2>

<h3>Vos réservations en cours</h3>
<table class="table table-hober">
    <tr>
        <th>ID Réservation</th>
        <th>Hôtel</th>
        <th>Date début</th>
        <th>Date fin</th>
    </tr>
    <?php while($res = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $res['id_reserv']; ?></td>
        <td><?php echo $res['titre']; ?></td>
        <td><?php echo $res['date_debut_sejour']; ?></td>
        <td><?php echo $res['date_fin_sejour']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>

<?php
mysqli_close($conn);
?>
