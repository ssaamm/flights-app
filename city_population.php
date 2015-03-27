<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Change a city's population | Flights app</title>
    </head>
    <body>
        <h1>Change a city's population</h1>
        <p><?php
require_once('database.php');

// verify correct attributes
if (!isset($_POST['name']) || !isset($_POST['state'])
    || !isset($_POST['population'])) {

    echo 'Error: attributes set incorrectly';
    exit;
}


$city_name = $_POST['name'];
$state_name = $_POST['state'];
$population = $_POST['population'];

$ins_city = $db->prepare('UPDATE city SET population = :population WHERE '
    . 'city_name = :city_name AND state_name = :state_name;');
$ins_city->bindValue(':city_name', $city_name);
$ins_city->bindValue(':state_name', $state_name);
$ins_city->bindValue(':population', $population);

try {
    $ins_city->execute();
} catch (PDOException $e) {
    echo 'Error: problem changing population<br>' . PHP_EOL;
    echo $e->getMessage();
    exit;
}

if ($ins_city->rowCount() <= 0) {
    echo 'Heads up: that didn\'t change anything';
} else {
    echo 'Updated population. Thanks!';
}

?></p>
    </body>
</html>
