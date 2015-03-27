<?php
require_once('database.php');

// verify correct attributes
if (!isset($_POST['airport_code']) || !isset($_POST['city_name']) || 
    !isset($_POST['state'])) {

    echo 'Error: attributes set incorrectly' . PHP_EOL;
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
    echo 'Error: problem adding airport' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit;
}

echo 'Yay' . PHP_EOL;

?>
