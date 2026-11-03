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

// Helper to write a Firestore document
function createDoc($accessToken, $docPath, $fields) {
    $url = "https://firestore.googleapis.com/v1/$docPath";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['fields' => $fields]));
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "Writing $docPath => HTTP $code\n";
    if ($code >= 400) {
        echo "Error: $res\n";
    }
}

$dateStr = '2026-10-25';
$base = "projects/datlichkham-37558/databases/(default)/documents/LichHen/$dateStr";

// 1. Root LichHen/2026-10-25
createDoc($accessToken, $base, [
    'ngay' => ['timestampValue' => '2026-10-24T17:00:00Z'],
    'ngay_hien_thi' => ['stringValue' => '25/10/2026'],
    'ngay_tao' => ['timestampValue' => '2026-10-19T09:00:00Z']
]);

// 2. Ca: ca_sang, ca_chieu
createDoc($accessToken, "$base/ca/ca_sang", [
    'ca_id' => ['stringValue' => 'ca_sang'],
    'ten_ca' => ['stringValue' => 'Ca sáng'],
    'gio_bat_dau' => ['stringValue' => '07:30'],
    'gio_ket_thuc' => ['stringValue' => '12:00']
]);

createDoc($accessToken, "$base/ca/ca_chieu", [
    'ca_id' => ['stringValue' => 'ca_chieu'],
    'ten_ca' => ['stringValue' => 'Ca chiều'],
    'gio_bat_dau' => ['stringValue' => '13:30'],
    'gio_ket_thuc' => ['stringValue' => '17:00']
]);

// 3. BenhVien: BV001
$bvPathSang = "$base/ca/ca_sang/benh_vien/BV001";
createDoc($accessToken, $bvPathSang, [
    'benh_vien_id' => ['stringValue' => 'BV001'],
    'ten_benh_vien' => ['stringValue' => 'Bệnh viện Quân y 17']
]);

$bvPathChieu = "$base/ca/ca_chieu/benh_vien/BV001";
createDoc($accessToken, $bvPathChieu, [
    'benh_vien_id' => ['stringValue' => 'BV001'],
    'ten_benh_vien' => ['stringValue' => 'Bệnh viện Quân y 17']
]);

// Danh sách khoa và bệnh nhân mẫu ngày 25/10/2026
$danhSachMau = [
    // --- KHOA TIM (K001) ---
    [
        'ca' => 'ca_sang',
        'khoa_id' => 'K001',
        'ten_khoa' => 'KHOA TIM',
        'phong_kham_id' => 'BV001_K001_TIM01',
        'benh_nhan_id' => 'BN2510_01',
        'ho_ten' => 'NGUYỄN VĂN AN',
        'sdt' => '0901234567',
        'stt' => 1,
        'gio_kham' => '08:00',
        'trang_thai_id' => 1, // Chờ duyệt
        'gioi_tinh' => 'Nam',
        'nam_sinh' => '1985',
        'bac_si' => 'BS. CKII Lê Hoàng Nam'
    ],
    [
        'ca' => 'ca_sang',
        'khoa_id' => 'K001',
        'ten_khoa' => 'KHOA TIM',
        'phong_kham_id' => 'BV001_K001_TIM01',
        'benh_nhan_id' => 'BN2510_02',
        'ho_ten' => 'TRẦN THỊ MAI',
        'sdt' => '0912345678',
        'stt' => 2,
        'gio_kham' => '08:30',
        'trang_thai_id' => 2, // Đã xác nhận / duyệt
        'gioi_tinh' => 'Nữ',
        'nam_sinh' => '1978',
        'bac_si' => 'BS. CKII Lê Hoàng Nam'
    ],
    [
        'ca' => 'ca_chieu',
        'khoa_id' => 'K001',
        'ten_khoa' => 'KHOA TIM',
        'phong_kham_id' => 'BV001_K001_TIM01',
        'benh_nhan_id' => 'BN2510_03',
        'ho_ten' => 'LÊ HOÀNG PHÚC',
        'sdt' => '0938111222',
        'stt' => 3,
        'gio_kham' => '14:00',
        'trang_thai_id' => 1, // Chờ duyệt
        'gioi_tinh' => 'Nam',
        'nam_sinh' => '1992',
        'bac_si' => 'BS. CKII Lê Hoàng Nam'
    ],
    [
        'ca' => 'ca_chieu',
        'khoa_id' => 'K001',
        'ten_khoa' => 'KHOA TIM',
        'phong_kham_id' => 'BV001_K001_TIM01',
        'benh_nhan_id' => 'BN2510_04',
        'ho_ten' => 'PHẠM MINH QUANG',
        'sdt' => '0988777666',
        'stt' => 4,
        'gio_kham' => '15:15',
        'trang_thai_id' => 5, // Hoàn thành / đã khám
        'gioi_tinh' => 'Nam',
        'nam_sinh' => '1965',
        'bac_si' => 'BS. CKII Lê Hoàng Nam'
    ],

    // --- KHOA MẮT (K003) ---
    [
        'ca' => 'ca_sang',
        'khoa_id' => 'K003',
        'ten_khoa' => 'KHOA MẮT',
        'phong_kham_id' => 'BV001_K003_M001',
        'benh_nhan_id' => 'BN2510_05',
        'ho_ten' => 'VÕ THỊ HỒNG',
        'sdt' => '0977444333',
        'stt' => 1,
        'gio_kham' => '08:15',
        'trang_thai_id' => 1, // Chờ duyệt
        'gioi_tinh' => 'Nữ',
        'nam_sinh' => '1999',
        'bac_si' => 'BS. CKI Vũ Đình Tú'
    ],
    [
        'ca' => 'ca_sang',
        'khoa_id' => 'K003',
        'ten_khoa' => 'KHOA MẮT',
        'phong_kham_id' => 'BV001_K003_M001',
        'benh_nhan_id' => 'BN2510_06',
        'ho_ten' => 'ĐẶNG TUẤN KIỆT',
        'sdt' => '0908555777',
        'stt' => 2,
        'gio_kham' => '09:00',
        'trang_thai_id' => 2, // Đã duyệt
        'gioi_tinh' => 'Nam',
        'nam_sinh' => '2001',
        'bac_si' => 'BS. CKI Vũ Đình Tú'
    ],

    // --- KHOA NHI (K004) ---
    [
        'ca' => 'ca_sang',
        'khoa_id' => 'K004',
        'ten_khoa' => 'KHOA NHI',
        'phong_kham_id' => 'BV001_K004_NH01',
        'benh_nhan_id' => 'BN2510_07',
        'ho_ten' => 'BÉ NGUYỄN GIA HÂN',
        'sdt' => '0933888999',
        'stt' => 1,
        'gio_kham' => '09:30',
        'trang_thai_id' => 1, // Chờ duyệt
        'gioi_tinh' => 'Nữ',
        'nam_sinh' => '2020',
        'bac_si' => 'BS. CKI Nguyễn Lan Hương'
    ]
];

foreach ($danhSachMau as $item) {
    $ca = $item['ca'];
    $kId = $item['khoa_id'];
    $pkId = $item['phong_kham_id'];
    $bnId = $item['benh_nhan_id'];
    $lhId = "LH20261025_" . $bnId;

    // Khoa doc
    $khoaPath = "$base/ca/$ca/benh_vien/BV001/khoa/$kId";
    createDoc($accessToken, $khoaPath, [
        'khoa_id' => ['stringValue' => $kId],
        'ten_khoa' => ['stringValue' => $item['ten_khoa']]
    ]);

    // Phong kham doc
    $pkPath = "$khoaPath/phong_kham/$pkId";
    createDoc($accessToken, $pkPath, [
        'phong_kham_id' => ['stringValue' => $pkId],
        'so_benh_nhan_toi_da' => ['integerValue' => 30],
        'so_lich_hen' => ['integerValue' => 5]
    ]);

    // Benh nhan doc
    $bnPath = "$pkPath/benh_nhan/$bnId";
    createDoc($accessToken, $bnPath, [
        'benh_nhan_id' => ['stringValue' => $bnId],
        'ho_ten' => ['stringValue' => $item['ho_ten']],
        'so_dien_thoai' => ['stringValue' => $item['sdt']],
        'so_lich_hen' => ['integerValue' => 1]
    ]);

    // Lich hen doc (trong subcollection lich_hen của đúng cấu trúc Firebase)
    $lhPath = "$bnPath/lich_hen/$lhId";
    createDoc($accessToken, $lhPath, [
        'id' => ['stringValue' => $lhId],
        'benh_nhan_id' => ['stringValue' => $bnId],
        'ho_ten' => ['stringValue' => $item['ho_ten']],
        'so_dien_thoai' => ['stringValue' => $item['sdt']],
        'benh_vien_id' => ['stringValue' => 'BV001'],
        'khoa_id' => ['stringValue' => $kId],
        'ten_khoa' => ['stringValue' => $item['ten_khoa']],
        'phong_kham_id' => ['stringValue' => $pkId],
        'ca_id' => ['stringValue' => $ca],
        'ngay_hen' => ['timestampValue' => '2026-10-24T17:00:00Z'], // UTC for 2026-10-25
        'ngay_dat' => ['timestampValue' => '2026-10-24T17:00:00Z'],
        'ngay_hien_thi' => ['stringValue' => '25/10/2026'],
        'gio_du_kien' => ['stringValue' => $item['gio_kham']],
        'gio_kham' => ['stringValue' => $item['gio_kham']],
        'so_thu_tu' => ['integerValue' => $item['stt']],
        'trang_thai_id' => ['integerValue' => $item['trang_thai_id']],
        'bac_si' => ['stringValue' => $item['bac_si']],
        'gioi_tinh' => ['stringValue' => $item['gioi_tinh']],
        'nam_sinh' => ['stringValue' => $item['nam_sinh']],
        'ma_qr' => ['stringValue' => 'QR_' . $lhId],
        'ngay_tao' => ['timestampValue' => '2026-10-19T09:00:00Z'],
        'ngay_cap_nhat' => ['timestampValue' => '2026-10-19T09:00:00Z']
    ]);

    // Đồng thời lưu bản sao vào collection 'BenhNhan' để hỗ trợ tra cứu QR
    createDoc($accessToken, "projects/datlichkham-37558/databases/(default)/documents/BenhNhan/$bnId", [
        'uid' => ['stringValue' => $bnId],
        'ho_ten' => ['stringValue' => $item['ho_ten']],
        'so_dien_thoai' => ['stringValue' => $item['sdt']],
        'gioi_tinh' => ['stringValue' => $item['gioi_tinh']],
        'nam_sinh' => ['stringValue' => $item['nam_sinh']],
        'ngay_sinh' => ['stringValue' => '01/01/' . $item['nam_sinh']]
    ]);
}

echo "\n=> ĐÃ TẠO THÀNH CÔNG DỮ LIỆU LỊCH HẸN NGÀY 25/10/2026 ĐÚNG CẤU TRÚC FIREBASE!\n";
