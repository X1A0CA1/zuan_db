<?php
$allowed_types = array('biss', 'diss', 'fadian');

$type = in_array($_GET['type'], array('biss', 'diss', 'fadian')) ? $_GET['type'] : null;

if (!$type) {
    $error = array(
        'code' => '400',
        'error' => 'Invalid type parameter',
        'allowed_types' => $allowed_types,
        'timestamp' => time()
    );
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode($error);
    exit();
}

$sql = "SELECT `text` FROM '$type' ORDER BY RANDOM() limit 1";

$db = new SQLite3('./data.db');

$db_result = $db->querySingle($sql);

if ($type == 'biss' || $type == 'diss') {
    $resp = array(
        'code' => '200',
        'value' => $db_result,
        'timestamp' => time()
    );
}
elseif ($type == 'fadian') {
    $resp = array(
        'code' => '200',
        'value' => $db_result,
        'placeholder' => '{holder}',
        'timestamp' => time()
    );
}
else {
    $error = array(
        'code' => '500',
        'error' => 'Internal server error',
        'timestamp' => time()
    );
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode($error);
    exit();
}

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($resp);
