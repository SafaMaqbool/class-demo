<?php
//connect to db
$pdo = new PDO("mysql:host=localhost;dbname=class_demo", "root", "");


//get all the students from the table
$students = $pdo->query("Select * from students")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Demo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Import students csv file</h2>
    <form action="action.php?do=import" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv">
        <button>Upload</button>
    </form>

    <h2>Upload student photo</h2>
    <form action="action.php?do=photo" method="post" enctype="multipart/form-data">
        <input type="number" name="id" placeholder="Student ID">
        <input type="file" name="photo">
        <button>Upload Photo</button>
    </form>
    <p>
        <a href="action.php?do=export">Download CSV</a>
        <a href="action.php?do=json">View JSON</a>
    </p>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>Photo</th>
        </tr>
        <?php foreach ($students as $s) { ?>
            <tr>
                <td><?php echo $s['id']; ?></td>
                <td><?php echo $s['name']; ?></td>
                <td><?php echo $s['city']; ?></td>
                <td>  <?php if (!empty($s['image'])): ?>
                        <!-- uploads folder ka naam aur db se photo ka naam link kiya -->
                        <img src="uploads/<?php echo htmlspecialchars($s['image']); ?>" alt="Student Photo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <?php else: ?>
                        <span>No Photo</span>
                    <?php endif; ?></td>
            </tr>
        <?php } ?>
    </table>


</body>

</html>