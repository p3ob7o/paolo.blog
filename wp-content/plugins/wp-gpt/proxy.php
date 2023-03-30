<?php

require_once dirname(__FILE__) . '/../../../wp-load.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['error' => 'Invalid request method.']));
}

$api_key = get_option('gpt_api_key');
if (!$api_key) {
    http_response_code(500);
    echo json_encode(array('error' => 'API key not set'));
    exit;
}

$api_url = 'https://api.openai.com/v1/completions';

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
];

$post_data = file_get_contents('php://input');
$json_data = json_decode($post_data, true);
$openai_data = array(
    'model' => 'gpt-4',
    'prompt' => $json_data['prompt'],
    'context' => $json_data['context'],
    'max_tokens' => 200,
    'temperature' => 0.8,
    'n' => 1,
    'stop' => null,
);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($openai_data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
