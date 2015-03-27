<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=flights-app', 'flightsappweb', 'pw');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // verify correct attributes
    $required_attributes = array('airline', 'flight_number', 'source_airport',
        'destination_airport', 'departure_time', 'arrival_time');
    foreach ($required_attributes as $attribute) {
        if (!isset($_POST[$attribute])) {
            echo 'Error: ' . $attribute . ' set incorrectly' . PHP_EOL;
            exit;
        }
    }

    $airline = $_POST['airline'];
    $flight_number = $_POST['flight_number'];
    $source_airport = $_POST['source_airport'];
    $destination_airport = $_POST['destination_airport'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    $ins_flight = $db->prepare('INSERT INTO flight(airline, flight_number, '
        . 'source_airport, destination_airport, departure_time, arrival_time) '
        . 'VALUES (:airline, :flight_number, :source_airport, '
        . ':destination_airport, :departure_time, :arrival_time)');
    $ins_flight->bindValue(':airline', $airline);
    $ins_flight->bindValue(':flight_number', $flight_number);
    $ins_flight->bindValue(':source_airport', $source_airport);
    $ins_flight->bindValue(':destination_airport', $destination_airport);
    $ins_flight->bindValue(':departure_time', $departure_time);
    $ins_flight->bindValue(':arrival_time', $arrival_time);

    try {
        $ins_flight->execute();
    } catch (PDOException $e) {
        echo 'Error: problem adding flight' . PHP_EOL;
        echo $e->getMessage() . PHP_EOL;
        exit;
    }

    echo 'Yay' . PHP_EOL;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET'
    && isset($_GET['depart_time_start'])
    && isset($_GET['depart_time_end'])) {

    $get_flights = $db->prepare('SELECT * FROM flight WHERE departure_time <= '
        . ':depart_time_end AND departure_time >= :depart_time_start;');
    $get_flights->bindValue(':depart_time_end', $_GET['depart_time_end']);
    $get_flights->bindValue(':depart_time_start', $_GET['depart_time_start']);
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        var_dump($flight);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET'
    && isset($_GET['destination_airport'])) {

    $get_flights = $db->prepare('SELECT * FROM flight WHERE '
        . 'destination_airport = :destination_airport;');
    $get_flights->bindValue(':destination_airport',
        $_GET['destination_airport']);
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        var_dump($flight);
    }
} else {
    echo 'All flights';
    $get_flights = $db->prepare('SELECT * FROM flight;');
    $get_flights->execute();
    while ($flight = $get_flights->fetch()) {
        var_dump($flight);
    }
}

?>
