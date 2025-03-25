<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
    text-align: center;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
    background: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
    border-radius: 10px;
}

h1 {
    color: #333;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: #333;
    color: white;
}

td img {
    width: 100px;
    height: auto;
    border-radius: 5px;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    background: #ff4c4c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #cc0000;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
        <p>Your detected helmet violations are listed below:</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="Violation Image"></td>
                    <td><?= htmlspecialchars($row['date']); ?></td>
                    <td><?= htmlspecialchars($row['location']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>

<?php $conn->close(); ?>