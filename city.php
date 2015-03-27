<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add a city | Flights app</title>
    </head>
    <body>
        <h1>Add a city</h1>
        <p><?php
require_once('database.php');

// verify correct attributes
if (!isset($_POST['name']) || !isset($_POST['state'])
    || !isset($_POST['population'])) {

    echo 'Error: attributes set incorrectly';
    exit;
}

$ins_city = $db->prepare('INSERT INTO city(city_name, state_name, population) '
    . 'VALUES (:city_name, :state_name, :population)');
$ins_city->bindValue(':city_name', $_POST['name']);
$ins_city->bindValue(':state_name', $_POST['state']);
$ins_city->bindValue(':population', $_POST['population']);

try {
    $ins_city->execute();
} catch (PDOException $e) {
    echo 'Error: problem adding city<br>' . PHP_EOL;
    echo $e->getMessage();
    exit;
}

echo 'City added. Thanks!';

?></p>
    </body>
</html>
