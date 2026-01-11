<?php

// mysqli_report(MYSQLI_REPORT_OFF);

define("SERVER", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB_NAME", "test");

$db = new mysqli(SERVER, USER, PASSWORD, DB_NAME);
if ($db -> connect_error) {
    die("Błąd łączenia z bazą danych: ".$db->connect_error);
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <div>
        <h3>Search for user</h3>
    </div>
    <form action="index.php" method="post">
        <label>Name: <input type="text" name="name" id="name"></label>
        <label>Lastanme: <input type="text" name="lastname" id="lastname"></label>
        <label>Grade: <input type="text" name="grade" id="grade"></label>
        <button type="submit" name="search">Search</button>
    </form>
</body>
</html>


<?php

if (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $name = $_POST['name'] ?? "";
    $lastname = $_POST['lastname'] ?? "";
    $grade = $_POST['grade'] ?? "";

    $query = "SELECT * FROM users WHERE 1";
    if (!empty($name)) $query.=" and name like '$name'";
    if (!empty($lastname)) $query.=" and lastname like '$lastname'";
    if (!empty($grade)) $query.=" and grade like '$grade'";


    $data = $db -> query($query);
    if ($data -> num_rows === 0) {
        echo "<p>No rows retured</p>";
    }
    else {
        echo "<table>";
        echo 
        "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Grade</th>
        </tr>";

        foreach ($data as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $lastname = $row['lastname'];
            $grade = $row['grade'];

            echo 
            "<tr>
                <td>$id</td>
                <td>$name</td>
                <td>$lastname</td>
                <td>$grade</td>
            </tr>";
        }
        echo "</table>";
    }

}
else {
    echo "<p>Enter all data<p>";
}

$db -> close();
?>