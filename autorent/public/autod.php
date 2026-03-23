<?php
include("../inc/db.php");

$result = $conn->query("SELECT * FROM cars ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Autode nimekiri</h1>

    <div class="row">
        <?php while ($car = $result->fetch_assoc()): ?>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($car['mark'] . " " . $car['model']); ?>
                        </h5>

                        <p>Mootor: <?php echo htmlspecialchars($car['engine']); ?></p>
                        <p>Kütus: <?php echo htmlspecialchars($car['fuel']); ?></p>
                        <p>Aasta: <?php echo htmlspecialchars($car['year']); ?></p>
                        <p>Käigukast: <?php echo htmlspecialchars($car['transmission']); ?></p>
                        <p>Kohad: <?php echo htmlspecialchars($car['seats']); ?></p>
                        <p>Staatus: <?php echo htmlspecialchars($car['status']); ?></p>

                        <p><strong><?php echo htmlspecialchars($car['price']); ?> €/päev</strong></p>
                    </div>

                    <div class="card-footer">
                        <a href="auto.php?id=<?php echo $car['id']; ?>" class="btn btn-dark w-100">Rendi</a>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
