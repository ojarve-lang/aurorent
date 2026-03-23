<?php
include("../inc/auth.php");
include("../inc/db.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    die("Autot ei leitud.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mark = $_POST['mark'];
    $model = $_POST['model'];
    $engine = $_POST['engine'];
    $fuel = $_POST['fuel'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $year = $_POST['year'];
    $transmission = $_POST['transmission'];
    $seats = $_POST['seats'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE cars SET mark=?, model=?, engine=?, fuel=?, price=?, image=?, year=?, transmission=?, seats=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("ssssdssisssi", $mark, $model, $engine, $fuel, $price, $image, $year, $transmission, $seats, $description, $status, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muuda autot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Muuda autot</h1>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Mark</label>
            <input type="text" name="mark" class="form-control" value="<?php echo htmlspecialchars($car['mark']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mudel</label>
            <input type="text" name="model" class="form-control" value="<?php echo htmlspecialchars($car['model']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mootor</label>
            <input type="text" name="engine" class="form-control" value="<?php echo htmlspecialchars($car['engine']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kütus</label>
            <input type="text" name="fuel" class="form-control" value="<?php echo htmlspecialchars($car['fuel']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hind</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($car['price']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pildi link</label>
            <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($car['image']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Aasta</label>
            <input type="number" name="year" class="form-control" value="<?php echo htmlspecialchars($car['year']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Käigukast</label>
            <input type="text" name="transmission" class="form-control" value="<?php echo htmlspecialchars($car['transmission']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kohad</label>
            <input type="number" name="seats" class="form-control" value="<?php echo htmlspecialchars($car['seats']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kirjeldus</label>
            <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($car['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Staatus</label>
            <select name="status" class="form-select" required>
                <option value="vaba" <?php if ($car['status'] === 'vaba') echo 'selected'; ?>>vaba</option>
                <option value="renditud" <?php if ($car['status'] === 'renditud') echo 'selected'; ?>>renditud</option>
                <option value="hoolduses" <?php if ($car['status'] === 'hoolduses') echo 'selected'; ?>>hoolduses</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvesta muudatused</button>
        <a href="index.php" class="btn btn-secondary">Tagasi</a>
    </form>
</div>

</body>
</html>
