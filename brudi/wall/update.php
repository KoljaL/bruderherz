<?php


//
// get data from client
//
$data = json_decode(file_get_contents('php://input'), true);

//
// check if data is valid
//
// data must be an array and have 16 items
// if data is not valid, send error message to client
if (is_array($data) === false && count($data) !== 16) {
  $json = [
    'status' => 'error',
    'message' => 'invalid data received',
  ];
}

// 
// if data is valid, save data to currentVideos.json
// 
else {
  // save data to currentVideos.json
  $save = file_put_contents('currentVideos.json', json_encode($data));

  // check if save was successful
  // if save was not successful, send error message to client
  if ($save === false) {
    $json = [
      'status' => 'error',
      'message' => 'could not save data',
    ];
  }

  // if save was successful, send success message to client
  // and send currentVideos.json back to client
  else {
    $file = json_decode(file_get_contents('currentVideos.json'), true);
    $json = [
      'status' => 'success',
      'message' => 'data saved',
      'data' => $file,
    ];
  }
}

//
// send response to client as JSON
// 
header('Content-Type: application/json');
echo json_encode($json);





///////////////// NEW ///////////////////////

if ($_POST['data']) {
  $data = json_decode(file_get_contents('php://input'), true);
  $save = file_put_contents('currentVideos.json', json_encode($data));
}



if ($_GET['filename']) {
  $filename = $_GET['filename'];
  $file = json_decode(file_get_contents('files' . $filename . '.json'), true);
  $json = [
    'status' => 'success',
    'message' => 'data saved',
    'data' => $file,
  ];
  header('Content-Type: application/json');
  echo json_encode($json);
}