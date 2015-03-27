<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Flights | Flights app</title>
    </head>
    <body>
        <h1>Flights</h1>
        <p><?php
require_once('database.php');

function format_flight($flight) {
    return '<div class="flight">' . $flight['airline'] . ' '
        . $flight['flight_number'] . ' -- ' . $flight['source_airport'] . ' ('
        . $flight['departure_time'] . ') -> ' . $flight['destination_airport']
        . ' (' . $flight['arrival_time'] . ')</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // verify correct attributes
    $required_attributes = array('airline', 'flight_number', 'source_airport',
        'destination_airport', 'departure_time', 'arrival_time');
    foreach ($required_attributes as $attribute) {
        if (!isset($_POST[$attribute])) {
            echo 'Error: ' . $attribute . ' set incorrectly';
            exit;
        }
    }

    $ins_flight = $db->prepare('INSERT INTO flight(airline, flight_number, '
        . 'source_airport, destination_airport, departure_time, arrival_time) '
        . 'VALUES (:airline, :flight_number, :source_airport, '
        . ':destination_airport, :departure_time, :arrival_time)');
    $ins_flight->bindValue(':airline', $_POST['airline']);
    $ins_flight->bindValue(':flight_number', $_POST['flight_number']);
    $ins_flight->bindValue(':source_airport', $_POST['source_airport']);
    $ins_flight->bindValue(':destination_airport', $_POST['destination_airport']);
    $ins_flight->bindValue(':departure_time', $_POST['departure_time']);
    $ins_flight->bindValue(':arrival_time', $_POST['arrival_time']);

    try {
        $ins_flight->execute();
    } catch (PDOException $e) {
        echo 'Error: problem adding flight<br>' . PHP_EOL;
        echo $e->getMessage();
        exit;
    }

    echo 'Flight added. Thanks!';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET'
    && isset($_GET['depart_time_start'])
    && isset($_GET['depart_time_end'])) {

    $get_flights = $db->prepare('SELECT * FROM flight WHERE departure_time <= '
        . ':depart_time_end AND departure_time >= :depart_time_start;');
    $get_flights->bindValue(':depart_time_end', $_GET['depart_time_end']);
    $get_flights->bindValue(':depart_time_start', $_GET['depart_time_start']);
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        echo format_flight($flight);
        echo "<br>" . PHP_EOL;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET'
    && !empty($_GET['destination_airport'])) {

    $get_flights = $db->prepare('SELECT * FROM flight WHERE '
        . 'destination_airport = :destination_airport;');
    $get_flights->bindValue(':destination_airport',
        $_GET['destination_airport']);
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        echo format_flight($flight);
        echo "<br>" . PHP_EOL;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['airline'])) {
    $get_flights = $db->prepare('SELECT * FROM flight WHERE airline = '
        . ':airline;');
    $get_flights->bindValue(':airline', $_GET['airline']);
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        var_dump($flight);
        echo "<br>" . PHP_EOL;
    }
} else {
    $get_flights = $db->prepare('SELECT * FROM flight;');
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        echo format_flight($flight);
        echo "<br>" . PHP_EOL;
    }
}

?></p>
    </body>
</html>
