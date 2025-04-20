
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "gestion_hotel");
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM client WHERE login = '$login' AND motPasse = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $client = mysqli_fetch_assoc($result);
        $_SESSION['client_id'] = $client['id_client'];
        $_SESSION['client_nom'] = $client['nom'];
        $_SESSION['client_cin'] = $client['cin'];
        header("Location: reservEncours.php");
        exit();
    } else {
        $error = "Login ou mot de passe incorrect";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <h1 class="text-center">Connexion Client</h1>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST" class="row g-3 p-3 border border-3 m-auto" >
        <label>Login: <input class="form-control" type="text" name="login" required></label><br>
        <label>Mot de passe: <input type="password" class="form-control" name="password" required></label><br>
        <button class="btn btn-primary mt-3" type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>