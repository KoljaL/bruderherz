<?php

//
// settings 
// 
$password = "moin";
$folder = "files/";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// var_dump($_POST);
//
// no passwort return imidiatly
// 
if (!isset($_POST['password']) || $_POST['password'] !== $password || empty($_POST['password'])) {
    echo "No password";
    exit;
}

//
// no file return imidiatly
//
if (!isset($_POST['file']) || $_POST['file'] == "" || empty($_POST['file'])) {
    echo "No file";
    exit;
}

// 
// if data is empty return imidiatly
//
if (isset($_POST['data']) && empty($_POST['data'])) {
    echo "No data";
    exit;
}




//
// SAVE JSON
//
if (isset($_POST['data'])) {
    //
    // save data to file 
    $filename = $folder . $_POST['file'] . ".json";
    $jsonData = $_POST['data'];
    file_put_contents($filename, $jsonData);
    //
    // return saved file as json
    $jsonData = file_get_contents($filename);
    header('Content-Type: application/json');
    // echo json_encode($jsonData);
    echo $jsonData;
    exit;
}



//
// LOAD JSON
// 
else {
    $filename = $folder . $_POST['file'] . ".json";
    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        header('Content-Type: application/json');
        // echo json_encode($jsonData);
        echo $jsonData;
        exit;
    } else {
        echo "File not found!";
        exit;
    }
}








///////////////////////// OLD //////////////////////

//
// LOAD JSON
// 
// if (isset($_POST['load'])) {
//     $filename = $folder . "/" . $_POST['load'] . ".json";
//     if (file_exists($filename)) {
//         $jsonData = file_get_contents($filename);
//         header('Content-Type: application/json');
//         echo json_encode($jsonData);
//         exit;
//     } else {
//         echo "File not found!";
//         exit;
//     }
// }



//
// SAVE JSON
//
// if (isset($_POST['save'])) {
//     $filename = $folder . "/" . $_POST['save'] . ".json";
//     $jsonData = $_POST['data'];
//     file_put_contents($filename, $jsonData);
//     echo "File saved!";
//     exit;
// } else {
//     echo "Data not found!";
//     exit;
// }


