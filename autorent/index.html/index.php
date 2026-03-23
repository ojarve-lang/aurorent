<?php
include("../inc/auth.php");
include("../inc/db.php");

// Autod
$cars = $conn->query("SELECT * FROM cars ORDER BY id DESC");

// Broneeringud
$reservations = $conn->query("
    SELECT r.*, c.mark, c.model
    FROM reservations r
    JOIN cars c ON r.car_id = c.id
    ORDER BY r.id DESC
");
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container d-flex justify-content-between">
        <span class="navbar-brand">Admin paneel</span>

        <div class="d-flex gap-2">
            <a href="add_car.php" class="btn btn-success btn-sm">Lisa auto</a>
            <a href="../public/autod.php" class="btn btn-outline-light btn-sm">Avalik vaade</a>
            <a href="logout.php" class="btn btn-warning btn-sm">Logi välja</a>
        </div>
    </div>
</nav>

<div class="container my-5">

    <!-- AUTOD -->
    <h2 class="mb-3">Autod</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mark</th>
                <th>Mudel</th>
                <th>Aasta</th>
                <th>Staatus</th>
                <th>Hind</th>
                <th>Tegevused</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($car = $cars->fetch_assoc()): ?>
            <tr>
                <td><?php echo $car['id']; ?></td>
                <td><?php echo htmlspecialchars($car['mark']); ?></td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['year']); ?></td>
                <td><?php echo htmlspecialchars($car['status']); ?></td>
                <td><?php echo htmlspecialchars($car['price']); ?> €</td>
                <td>
                    <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="btn btn-primary btn-sm">Muuda</a>
                    <a href="delete_car.php?id=<?php echo $car['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Kas kustutada?')">Kustuta</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- BRONEERINGUD -->
    <h2 class="mt-5 mb-3">Broneeringud</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Auto</th>
                <th>Algus</th>
                <th>Lõpp</th>
                <th>Hind</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($r = $reservations->fetch_assoc()): ?>
            <tr>
                <td><?php echo $r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['mark'] . " " . $r['model']); ?></td>
                <td><?php echo $r['start_date']; ?></td>
                <td><?php echo $r['end_date']; ?></td>
                <td><?php echo $r['total_price']; ?> €</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>