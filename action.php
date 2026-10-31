<?php

$do = $_GET['do'];
$pdo = new PDO("mysql:host=localhost;dbname=class_demo", "root", "");

if ($do == "import") {
    $file = fopen($_FILES['csv']['tmp_name'], "r");
    fgetcsv($file);

    while ($row = fgetcsv($file)) {
        if (empty($row[0])) continue;
        $stmt = $pdo->prepare("INSERT INTO students (name,city) VALUES (?,?)");
        $stmt->execute([$row[0], $row[1]]);
    }
    fclose($file);
    header("Location: index.php");
}

if($do=="export"){
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=students.csv");
    $out=fopen("php://output","w");
    fputcsv($out,["id","name","city"]);

    foreach($pdo->query("SELECT * FROM students") as $row){
        fputcsv($out,[$row['id'], $row['name'], $row['city']]);
    }



}

if($do=="photo"){
    $name=time() . "_" .$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$name);
    $stmt=$pdo->prepare("UPDATE students SET image=? where id=?");
    $stmt->execute([$name, $_POST['id']]);
    header("Location: index.php");
}

if($do=="json"){
    header("Content-Type: application/json");
    $data=$pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}



?>

