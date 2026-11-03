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

// List root Khoa collection
$url = 'https://firestore.googleapis.com/v1/projects/datlichkham-37558/databases/(default)/documents/Khoa';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$res = curl_exec($ch);
curl_close($ch);
$data = json_decode($res, true);
echo "ROOT KHOA DOCS:\n";
foreach ($data['documents'] ?? [] as $d) {
    echo $d['name'] . "\n";
}

// Check BO85AxXqDMSB68hnYjzhYfPIxHC2/danh_sach
$url2 = 'https://firestore.googleapis.com/v1/projects/datlichkham-37558/databases/(default)/documents/Khoa/BO85AxXqDMSB68hnYjzhYfPIxHC2/danh_sach';
$ch = curl_init($url2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$res2 = curl_exec($ch);
curl_close($ch);
$data2 = json_decode($res2, true);
echo "\nBO85AxXqDMSB68hnYjzhYfPIxHC2/danh_sach COUNT: " . count($data2['documents'] ?? []) . "\n";
foreach ($data2['documents'] ?? [] as $d) {
    $f = $d['fields'] ?? [];
    echo $d['name'] . " -> " . ($f['tenKhoa']['stringValue'] ?? $f['ten_khoa']['stringValue'] ?? 'none') . "\n";
}

// Check dFmZHBjFNUT1eRzJjXp5/danh_sach
$url3 = 'https://firestore.googleapis.com/v1/projects/datlichkham-37558/databases/(default)/documents/Khoa/dFmZHBjFNUT1eRzJjXp5/danh_sach';
$ch = curl_init($url3);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$res3 = curl_exec($ch);
curl_close($ch);
$data3 = json_decode($res3, true);
echo "\ndFmZHBjFNUT1eRzJjXp5/danh_sach COUNT: " . count($data3['documents'] ?? []) . "\n";
foreach ($data3['documents'] ?? [] as $d) {
    $f = $d['fields'] ?? [];
    echo $d['name'] . " -> " . ($f['tenKhoa']['stringValue'] ?? $f['ten_khoa']['stringValue'] ?? 'none') . "\n";
}
