<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=flights-app', 'flightsappweb', 'pw');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// verify correct attributes
if (!isset($_POST['airport_code']) || !isset($_POST['city_name']) || 
    !isset($_POST['state'])) {

    echo 'Error: attributes set incorrectly' . PHP_EOL;
    exit;
}


$airport_code = $_POST['airport_code'];
$city_name = $_POST['city_name'];
$state_name = $_POST['state'];

$ins_airport = $db->prepare('INSERT INTO airport(airport_code, city_name, '
    . 'state_name) VALUES (:airport_code, :city_name, :state_name)');
$ins_airport->bindValue(':airport_code', $airport_code);
$ins_airport->bindValue(':city_name', $city_name);
$ins_airport->bindValue(':state_name', $state_name);

try {
    $ins_airport->execute();
} catch (PDOException $e) {
    echo 'Error: problem adding airport' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit;
}

echo 'Yay' . PHP_EOL;

?>
