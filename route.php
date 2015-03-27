<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Find a route | Flights app</title>
    </head>
    <body>
        <h1>Find a route</h1>
<?php
require_once('database.php');

function format_flight($flight) {
    return '<div class="flight">' . $flight['airline'] . ' '
        . $flight['flight_number'] . ' -- ' . $flight['source_airport'] . ' ('
        . $flight['departure_time'] . ') -> ' . $flight['destination_airport']
        . ' (' . $flight['arrival_time'] . ')</div>';
}

function format_indirect($row) {
    return '<div class="flight">' . $row['airline1'] . $row['flight1'] . ', '
        . $row['airline2'] . ' ' . $row['flight2'] . '</div>';
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
  'SELECT *' . PHP_EOL
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

echo '<h2>Indirect:</h2>' . PHP_EOL;
while ($row = $get_route->fetch()) {
    echo format_indirect($row) . PHP_EOL;
}

echo '<h2>Direct:</h2>' . PHP_EOL;
while ($row = $get_direct->fetch()) {
    echo format_flight($row) . PHP_EOL;
}

?>
    </body>
</html>
