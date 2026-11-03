<?php
$serviceAccount = json_decode(file_get_contents('c:/wamp/www/week6/datlichkham-37558-firebase-adminsdk-fbsvc-6c52905fb8.json'), true);
$privateKey = $serviceAccount['private_key'];
$clientEmail = $serviceAccount['client_email'];

function b64($d) { return rtrim(strtr(base64_encode($d), '+/', '-_'), '='); }

$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$claims = ['iss' => $clientEmail, 'scope' => 'https://www.googleapis.com/auth/datastore', 'aud' => 'https://oauth2.googleapis.com/token', 'exp' => time() + 3600, 'iat' => time()];
$jwt = b64(json_encode($header)) . '.' . b64(json_encode($claims));
openssl_sign($jwt, $sig, $privateKey, 'SHA256');
$signed = $jwt . '.' . b64($sig);

$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $signed]));
$res = curl_exec($ch);
curl_close($ch);
$token = json_decode($res, true)['access_token'];

// Query collectionGroup lich_hen
$url = 'https://firestore.googleapis.com/v1/projects/datlichkham-37558/databases/(default)/documents:runQuery';
$query = [
    'structuredQuery' => [
        'from' => [
            ['collectionId' => 'lich_hen', 'allDescendants' => true]
        ]
    ]
];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP $code\n";
$data = json_decode($res, true);
if (is_array($data)) {
    echo "Results count: " . count($data) . "\n";
    foreach ($data as $item) {
        if (isset($item['document'])) {
            echo $item['document']['name'] . "\n";
            $fields = $item['document']['fields'] ?? [];
            echo "  ho_ten: " . ($fields['ho_ten']['stringValue'] ?? 'null') . " | ten_khoa: " . ($fields['ten_khoa']['stringValue'] ?? 'null') . " | ngay: " . ($fields['ngay_hien_thi']['stringValue'] ?? 'null') . "\n";
        } else {
            echo "Non-doc item: " . json_encode($item) . "\n";
        }
    }
} else {
    echo $res . "\n";
}
