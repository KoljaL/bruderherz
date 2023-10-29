<?php
$password = "moin";
header('Content-Type: application/json');


// no passwort return imidiatly
if (!isset($_POST['password']) || $_POST['password'] !== $password) {
    echo json_encode(['message' => 'no password']);
    exit;
}



// LOAD JSON
if (isset($_POST['load'])) {
    $filename = "files/" . $_POST['load'] . ".json";
    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        echo json_encode(["message" => "here you are", "data" => $jsonData]);
        exit;
    } else {
        echo "Nein, nein, nein! Datei nicht vorhanden!";
        exit;
    }
}


// SAVE JSON
if (isset($_POST['save'])) {
    $filename = "files/" . $_POST['save'] . ".json";
    $jsonData = $_POST['data'];
    file_put_contents($filename, $jsonData);
    echo json_encode(['message' => 'data saved']);
    exit;
} else {
    echo json_encode(['message' => 'no data']);
    exit;
}


