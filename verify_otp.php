
<?php
$phone = $_GET['phone'] ?? '';
$debug_otp = $_GET['otp'] ?? '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $entered_otp = $_POST['otp'];

    $conn = new mysqli("localhost", "root", "", "yptc_ethics_portal");
    $stmt = $conn->prepare("SELECT * FROM otp_verifications WHERE phone = ? AND otp = ?");
    $stmt->bind_param("ss", $phone, $entered_otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ኮዱ ትክክል ከሆነ በቀጥታ ወደ ጥቆማ ማቅረቢያው ክፍል ይመራዋል
        header("Location: index.html?logged=true#services");
        exit();
    } else {
        $error = "ያስገቡት ማረጋገጫ ኮድ ትክክል አይደለም። እባክዎ እንደገና ይሞክሩ።";
    }
}
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>ኮድ ማረጋገጫ (OTP Verify)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Noto Sans Ethiopic', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
        <h2 class="text-xl font-bold text-navy-900 mb-2">የዋትስአፕ ማረጋገጫ ኮድ ያስገቡ</h2>
        <p class="text-xs text-gray-500 mb-4">ወደ ስልክ ቁጥር <b><?php echo htmlspecialchars($phone); ?></b> የተላከውን ኮድ ያስገቡ።</p>
        
        <?php if (!empty($debug_otp)): ?>
            <div class="bg-amber-50 border border-amber-300 text-amber-800 p-3 rounded-xl text-xs mb-4">
                ማሳሰቢያ (Test OTP): <b><?php echo $debug_otp; ?></b>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-700 p-3 rounded-xl text-xs mb-4"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="verify_otp.php" method="POST" class="space-y-4">
            <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <input type="text" name="otp" required placeholder="4 ዲጂት ኮድ ያስገቡ" class="w-full p-3 rounded-xl border text-center text-lg tracking-widest focus:outline-none focus:border-amber-500">
            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 rounded-xl text-xs shadow-lg hover:bg-blue-800">ኮዱን አረጋግጥ</button>
        </form>
    </div>
</body>
</html>