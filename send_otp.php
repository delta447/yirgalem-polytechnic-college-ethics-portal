
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "yptc_ethics_portal";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("ዳታቤዝ መገናኘት አልቻለም: " . $conn->connect_error);
}

// አሮጌዎቹን ቴብሎች ሙሉ በሙሉ ማጥፋት
$conn->query("DROP TABLE IF EXISTS otp");
$conn->query("DROP TABLE IF EXISTS otp_verifications");

// ትክክለኛውን ቴብል መፍጠር
$conn->query("CREATE TABLE otp_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = trim($_POST['phone']);
    if (!empty($phone)) {
        $otp = rand(1000, 9999); // የ 4 ዲጂት ማረጋገጫ ኮድ
        
        // በትክክለኛው ቴብል (otp_verifications) ላይ ማስገባት
        $stmt = $conn->prepare("INSERT INTO otp_verifications (phone, otp) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $phone, $otp);
            $stmt->execute();
            $stmt->close();
        }

        // ወደ ማረጋገጫው ገጽ መምራት
        header("Location: verify_otp.php?phone=" . urlencode($phone) . "&otp=" . $otp);
        exit();
    }
}
?>