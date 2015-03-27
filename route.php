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
if (!isset($_GET['source_airport']) || !isset($_GET['destination_airport'])) {
    echo 'Error: attributes set incorrectly' . PHP_EOL;
    exit;
}

$get_route = $db->prepare(
  'SELECT f1.airline AS airline1, f1.flight_number AS flight1, '
. 'f2.airline AS airline2, f2.flight_number AS flight2' . PHP_EOL
. 'FROM  flight AS f1, flight AS f2' . PHP_EOL
. 'WHERE f1.source_airport = :source_airport' . PHP_EOL
. '  AND ADDTIME(f1.arrival_time, \'00:15:00\') <= f2.departure_time' . PHP_EOL
. '  AND f1.destination_airport = f2.source_airport' . PHP_EOL
. '  AND f2.destination_airport = :destination_airport;' . PHP_EOL);
$get_route->bindValue(':source_airport', $_GET['source_airport']);
$get_route->bindValue(':destination_airport', $_GET['destination_airport']);

$get_direct = $db->prepare(
  'SELECT airline, flight_number' . PHP_EOL
. 'FROM  flight' . PHP_EOL
. 'WHERE source_airport = :source_airport' . PHP_EOL
. '  AND destination_airport = :destination_airport;' . PHP_EOL);
$get_direct->bindValue(':source_airport', $_GET['source_airport']);
$get_direct->bindValue(':destination_airport', $_GET['destination_airport']);

try {
    $get_route->execute();
    $get_direct->execute();
} catch (PDOException $e) {
    echo 'Error: problem adding city' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit;
}

echo 'Indirect:' . PHP_EOL;
while ($row = $get_route->fetch()) {
    var_dump($row);
}

echo 'Direct:' . PHP_EOL;
while ($row = $get_direct->fetch()) {
    var_dump($row);
}

?>
