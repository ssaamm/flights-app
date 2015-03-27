<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add an airport | Flights app</title>
    </head>
    <body>
        <h1>Add an airport</h1>
        <p><?php
require_once('database.php');

// verify correct attributes
if (!isset($_POST['airport_code']) || !isset($_POST['city_name']) || 
    !isset($_POST['state'])) {

    echo 'Error: attributes set incorrectly';
    exit;
}

$ins_airport = $db->prepare('INSERT INTO airport(airport_code, city_name, '
    . 'state_name) VALUES (:airport_code, :city_name, :state_name)');
$ins_airport->bindValue(':airport_code', $_POST['airport_code']);
$ins_airport->bindValue(':city_name', $_POST['city_name']);
$ins_airport->bindValue(':state_name', $_POST['state']);

try {
    $ins_airport->execute();
} catch (PDOException $e) {
    echo 'Error: problem adding airport<br>' . PHP_EOL;
    echo $e->getMessage();
    exit;
}

echo 'Airport added. Thanks!';

?></p>
    </body>
</html>
