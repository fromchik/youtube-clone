<?php
$jsonFilePath = 'video.json';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

function getData() {
    global $jsonFilePath;
    if (!file_exists($jsonFilePath)) {
        return [];
    }
    $jsonData = file_get_contents($jsonFilePath);
    return json_decode($jsonData, true);
}

function saveData($data) {
    global $jsonFilePath;
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($jsonFilePath, $jsonData);
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = getData();
    if (isset($_GET['id'])) {
        $videoId = $_GET['id'];
        foreach ($data as $video) {
            if ($video['id'] === $videoId) {
                header('Content-Type: application/json');
                echo json_encode($video);
                exit();
            }
        }
        http_response_code(404);
        echo json_encode(['message' => 'Video not found']);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getData();
    $input = json_decode(file_get_contents('php://input'), true);
    $data[] = $input;
    saveData($data);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Data added successfully']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = getData();
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($_GET['id'])) {
        $videoId = $_GET['id'];
        foreach ($data as &$video) {
            if ($video['id'] === $videoId) {
                $video = array_merge($video, $input);
                saveData($data);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Data updated successfully']);
                exit();
            }
        }
        http_response_code(404);
        echo json_encode(['message' => 'Video not found']);
        exit();
    }
    http_response_code(400);
    echo json_encode(['message' => 'ID not specified']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = getData();
    if (isset($_GET['id'])) {
        $videoId = $_GET['id'];
        foreach ($data as $key => $video) {
            if ($video['id'] === $videoId) {
                unset($data[$key]);
                saveData($data);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Data deleted successfully']);
                exit();
            }
        }
        http_response_code(404);
        echo json_encode(['message' => 'Video not found']);
        exit();
    }
    http_response_code(400);
    echo json_encode(['message' => 'ID not specified']);
    exit();
}

?>
