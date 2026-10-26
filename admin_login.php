
<?php
session_start();

// የዳታቤዝ ግንኙነት
$conn = new mysqli("localhost", "root", "", "yptc_ethics_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // አድሚኑን በዳታቤዝ ውስጥ መፈለግ
    $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "የተሳሳተ የተጠቃሚ ስም ወይም የይለፍ ቃል!";
    }
}
?>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የአድሚን መግቢያ - YPTC Ethics Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans Ethiopic', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-200">
        <div class="text-center mb-6">
            <div class="bg-blue-900 text-amber-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto text-2xl mb-3 shadow">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">የአድሚን መግቢያ (Admin Login)</h2>
            <p class="text-xs text-gray-500 mt-1">ይርጋዓለም ፖሊ ቴክኒክ ኮሌጅ የስነ-ምግባር ፖርታል</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 text-xs p-3 rounded-lg mb-4 text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="admin_login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">የተጠቃሚ ስም (Username)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <input type="text" name="username" required placeholder="admin" class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-blue-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">የይለፍ ቃል (Password)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-blue-900">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-xl text-xs shadow-md transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>ወደ ሲስተም ግባ</span>
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="index.html" class="text-xs text-blue-900 hover:underline font-semibold">
                <i class="fa-solid fa-arrow-left"></i> ወደ መነሻ ገጽ ተመለስ
            </a>
        </div>
    </div>

</body>
</html>