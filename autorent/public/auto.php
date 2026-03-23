<?php
include("../inc/db.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = "";

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

include("../inc/db.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = "";

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST" && $car) {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    if ($start_date > $end_date) {
        $message = "<div class='alert alert-danger'>Lõppkuupäev peab olema pärast alguskuupäeva.</div>";
    } else {
        // Kontrolli kattuvust
        $check = $conn->prepare("
            SELECT id
            FROM reservations
            WHERE car_id = ?
            AND start_date <= ?
            AND end_date >= ?
            LIMIT 1
        ");
        $check->bind_param("iss", $id, $end_date, $start_date);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>See auto on valitud ajavahemikus juba broneeritud.</div>";
        } else {
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $days = $start->diff($end)->days + 1;

            $total_price = $days * $car["price"];
            $user_id = 1;

            $insert = $conn->prepare("
                INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price)
                VALUES (?, ?, ?, ?, ?)
            ");
            $insert->bind_param("iissd", $user_id, $id, $start_date, $end_date, $total_price);

            if ($insert->execute()) {
                $message = "<div class='alert alert-success'>Broneering salvestatud. Koguhind: " . htmlspecialchars($total_price) . " €</div>";
            } else {
                $message = "<div class='alert alert-danger'>Broneeringu salvestamine ebaõnnestus.</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
<?php echo $message; ?>
    <?php if ($car): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($car['image']); ?>" class="img-fluid rounded" alt="Auto pilt">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($car['mark'] . " " . $car['model']); ?></h1>
                <p><strong>Mootor:</strong> <?php echo htmlspecialchars($car['engine']); ?></p>
                <p><strong>Kütus:</strong> <?php echo htmlspecialchars($car['fuel']); ?></p>
                <p><strong>Hind:</strong> <?php echo htmlspecialchars($car['price']); ?> €/päev</p>
                <a href="cars.php" class="btn btn-secondary">Tagasi</a>
  <hr>

<h4>Broneeri see auto</h4>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Alguskuupäev</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Lõppkuupäev</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Arvuta hind ja broneeri</button>
</form>          </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Autot ei leitud.</div>
        <a href="cars.php" class="btn btn-secondary">Tagasi</a>
    <?php endif; ?>
</div>
</body>
</html>
