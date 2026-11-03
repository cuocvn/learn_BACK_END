<?php
$serviceAccount = json_decode(file_get_contents('c:/wamp/www/week6/datlichkham-37558-firebase-adminsdk-fbsvc-6c52905fb8.json'), true);
$privateKey = $serviceAccount['private_key'];
$clientEmail = $serviceAccount['client_email'];

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$now = time();
$claims = [
    'iss' => $clientEmail,
    'scope' => 'https://www.googleapis.com/auth/datastore',
    'aud' => 'https://oauth2.googleapis.com/token',
    'exp' => $now + 3600,
    'iat' => $now
];

$jwt = base64UrlEncode(json_encode($header)) . '.' . base64UrlEncode(json_encode($claims));
openssl_sign($jwt, $signature, $privateKey, 'SHA256');
$signedJwt = $jwt . '.' . base64UrlEncode($signature);

$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => $signedJwt
]));
$res = curl_exec($ch);
curl_close($ch);
$tokenData = json_decode($res, true);
$accessToken = $tokenData['access_token'];

// Query collectionGroup: lich_hen
$query = [
    'structuredQuery' => [
        'from' => [
            ['collectionId' => 'lich_hen', 'allDescendants' => true]
        ],
        'limit' => 5
    ]
];

$ch = curl_init('https://firestore.googleapis.com/v1/projects/datlichkham-37558/databases/(default)/documents:runQuery');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
$queryRes = curl_exec($ch);
curl_close($ch);

$items = json_decode($queryRes, true);
echo "CollectionGroup lich_hen total results: " . count($items) . "\n";
foreach ($items as $item) {
    if (!empty($item['document'])) {
        echo "Document Path: " . $item['document']['name'] . "\n";
        echo json_encode($item['document']['fields'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n\n";
    }
}
