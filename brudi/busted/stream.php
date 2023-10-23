<?php

// load config file
$config = require './config.php';
// print_r($config);

// $db will be our database file
$db = $config['file'];
// $lastModified will be the last time the file was modified
$lastModified = filemtime($db);
// $etagFile will be the md5 hash of the file
$etagFile = md5_file($db);
// $db_json will be the json data of the file
$db_json = json_decode(file_get_contents($db), true);


/*
 *
 * initialisation of data
 *
 */
$init_data = [
  "Name" => "",
  "Date" => "",
  "Member" => "",
  "Typ" => "",
  "Tags" => "",
  "Priority" => "",
  "Link" => "",
  "Notes" => ""
];

// check if file exists
// if not, create a new file with the data
if (!file_exists($config['file'])) {
  file_put_contents($config['file'], json_encode($init_data));
}


/*
 *
 * get data
 *
 */
if (isset($_GET['getData'])) {
  header('Content-Type: text/event-stream');
  header('Cache-Control: no-cache');
  header('Connection: keep-alive');

  sendData(json_encode($db_json));

  while (true) {
    $newData = hasDbFileChanged();

    if (!empty($newData)) {
      sendData($newData);
    }

    sleep(1);
  }
}


function sendData($data) {
  echo "data: " . json_encode($data) . "\n\n";
  ob_flush();
  flush();
}


function hasDbFileChanged() {
  global $db, $lastModified, $etagFile, $db_json;

  // $lastModifiedCurrent will be the last time the file was modified
  $lastModifiedCurrent = filemtime($db);
  // $etagFileCurrent will be the md5 hash of the file
  $etagFileCurrent = md5_file($db);
  // $db_jsonCurrent will be the json data of the file
  $db_jsonCurrent = json_decode(file_get_contents($db), true);

  // check if file has changed
  if ($lastModifiedCurrent != $lastModified || $etagFileCurrent != $etagFile) {
    // update variables
    $lastModified = $lastModifiedCurrent;
    $etagFile = $etagFileCurrent;
    $db_json = $db_jsonCurrent;

    // return new data
    return $db_json;
  }
  return [];
}