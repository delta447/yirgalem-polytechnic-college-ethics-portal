
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "yptc_ethics_portal";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("ዳታቤዝ መገናኘት አልቻለም");
}

$result = $conn->query("SELECT * FROM reports ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የአስተዳዳሪ ዳሽቦርድ (Admin Dashboard) - YPTC Ethics Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Noto Sans Ethiopic', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="bg-navy-900 text-white shadow-md sticky top-0 z-50 border-b border-navy-800" style="background-color: #0b1d3a;">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <div class="bg-amber-500 text-navy-900 p-2 rounded-lg font-bold">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-sm sm:text-base">የአስተዳዳሪ ዳሽቦርድ (Admin Dashboard)</h1>
                    <p class="text-xs text-gray-300">ይርጋዓለም ፖሊ ቴክኒክ ኮሌጅ - የስነ-ምግባርና ፀረ-ሙስና ቢሮ</p>
                </div>
            </div>
            <div>
                <a href="login.html" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow">
                    <i class="fa-solid fa-right-from-bracket"></i> ውጣ (Logout)
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-navy-900 flex items-center gap-2" style="color: #0b1d3a;">
                        <i class="fa-solid fa-list-check text-amber-500"></i> የቀረቡ ጥቆማዎችና አቤቱታዎች ዝርዝር
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">በተጠቃሚዎች የተላኩ የሙስና ጥቆማ መረጃዎች እና የፋይዳ መታወቂያ እዚህ ይታያሉ።</p>
                </div>
                <button onclick="location.reload();" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow" style="background-color: #0b1d3a;">
                    <i class="fa-solid fa-rotate-right"></i> አድስ (Refresh)
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-navy-900 text-white text-xs" style="background-color: #0b1d3a;">
                            <th class="p-3.5 rounded-l-xl">ተ.ቁ</th>
                            <th class="p-3.5">ሙሉ ስም</th>
                            <th class="p-3.5">ስልክ ቁጥር</th>
                            <th class="p-3.5">የፋይዳ መታወቂያ</th>
                            <th class="p-3.5">የጥቆማ ዓይነት</th>
                            <th class="p-3.5">ዝርዝር መግለጫ</th>
                            <th class="p-3.5 rounded-r-xl">ቀንና ሰዓት</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-xs">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3.5 font-bold text-gray-700"><?php echo $row['id']; ?></td>
                                    <td class="p-3.5 font-bold text-navy-900"><?php echo htmlspecialchars($row['full_name'] ?? ''); ?></td>
                                    <td class="p-3.5 font-medium text-gray-600"><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                                    <td class="p-3.5 font-semibold text-blue-700"><?php echo htmlspecialchars($row['fayda_id'] ?? 'አልተጠቀሰም'); ?></td>
                                    <td class="p-3.5">
                                        <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full font-bold">
                                            <?php echo htmlspecialchars($row['report_type'] ?? ''); ?>
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-gray-600 max-w-xs truncate" title="<?php echo htmlspecialchars($row['description'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($row['description'] ?? ''); ?>
                                    </td>
                                    <td class="p-3.5 text-gray-500"><?php echo htmlspecialchars($row['created_at'] ?? ''); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500 font-medium">
                                    <i class="fa-regular fa-folder-open text-3xl mb-2 text-gray-400 block"></i>
                                    ምንም ጥቆማ ወይም አቤቱታ አልገባም አሁን ላይ።
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <footer class="bg-navy-900 text-white text-center py-4 text-xs mt-auto border-t border-navy-800" style="background-color: #0b1d3a;">
        <p>© 2026 ይርጋዓለም ፖሊ ቴክኒክ ኮሌጅ - የስነ-ምግባርና ፀረ-ሙስና መከታተያ ቢሮ። መብቱ በህግ የተጠበቀ ነው።</p>
    </footer>

</body>
</html>
<?php $conn->close(); ?>