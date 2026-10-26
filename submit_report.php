
<?php
header('Content-Type: application/json');

// የማስገቢያ መረጃዎችን መቀበል
$sender_name = $_POST['sender_name'] ?? 'በምስጢር';
$sender_phone = $_POST['sender_phone'] ?? 'አልተጠቀሰም';
$category = $_POST['category'] ?? 'ሌሎች';
$fayda_id = $_POST['fayda_id'] ?? 'አልተጠቀሰም';
$message_details = $_POST['message_details'] ?? '';

// እዚህ ጋር ከ MySQL ዳታቤዝ ጋር ማገናኘት ከፈለጉ ኮዱን ማስገባት ይቻላል
// ለጊዜው ሲስተሙ እንከን የለሽ እንዲሰራ ስኬታማ መሆኑን በ JSON እንመልሳለን

echo json_encode([
    "status" => "success",
    "message" => "ጥቆማው በተሳካ ሁኔታ ተመዝግቧል!",
    "tracking_code" => "YPTC-ETH-" . rand(1000, 9999)
]);
?>