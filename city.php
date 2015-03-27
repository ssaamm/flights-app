<?php
require_once('database.php');

// verify correct attributes
if (!isset($_POST['name']) || !isset($_POST['state'])
    || !isset($_POST['population'])) {

    echo 'Error: attributes set incorrectly' . PHP_EOL;
    exit;
}


$city_name = $_POST['name'];
$state_name = $_POST['state'];
$population = $_POST['population'];

$ins_city = $db->prepare('INSERT INTO city(city_name, state_name, population) '
    . 'VALUES (:city_name, :state_name, :population)');
$ins_city->bindValue(':city_name', $city_name);
$ins_city->bindValue(':state_name', $state_name);
$ins_city->bindValue(':population', $population);

try {
    $ins_city->execute();
} catch (PDOException $e) {
    echo 'Error: problem adding city' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit;
}

echo 'Yay' . PHP_EOL;

?>
