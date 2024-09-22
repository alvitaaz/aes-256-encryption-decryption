<?php
include 'db.php';

echo "<div class='section'><h3>Activity Log</h3><table><tr style='background-color: #f2f2f2;'><th style='padding: 12px 15px;'>Timestamp</th><th style='padding: 12px 15px;'>Action</th></tr>";

$username = $_SESSION['username'];
$sql = "SELECT * FROM activity_log WHERE username = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "Prepare failed: " . $conn->error;
    exit();
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='padding: 8px 15px;'>{$row['timestamp']}</td><td style='padding: 8px 15px;'>";
    if (isset($row['activity_description']) && !empty($row['activity_description'])) {
        echo htmlspecialchars($row['activity_description']);
    } else {
        echo "No action recorded";
    }
    echo "</td></tr>";
}
$stmt->close();

echo "</table></div>";
   