<?php
function removeLine($filePath, $needle) {
    $lines = file($filePath);
    $out = [];
    foreach ($lines as $line) {
        if (strpos($line, $needle) === false) {
            $out[] = $line;
        }
    }
    file_put_contents($filePath, implode('', $out));
}

// 1. In letan_trangchu_screen_c1.dart
removeLine('a:/do an chuyende lttd/lib/screens/letan_c1/letan_trangchu_screen_c1.dart', 'kiemTraVaSeedLichKhamFirestore');
echo "Updated letan_trangchu_screen_c1.dart\n";
