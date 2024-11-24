<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "travelvista"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$city = $_POST['city'];

$sql = "SELECT id, name, address, price, number_of_rooms FROM hotels WHERE city = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels in <?php echo htmlspecialchars($city); ?> - Travel Vista</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            margin: 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        li:last-child {
            border-bottom: none;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #007BFF;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .no-hotels {
            color: #FF0000;
        }
    </style>
</head>
<body>
    <header>
        <h1>Travel Vista</h1>
    </header>
    <main>
        <h2>Hotels in <?php echo htmlspecialchars($city); ?></h2>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <strong><a href="booking.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></a></strong><br>
                        Address: <?php echo htmlspecialchars($row['address']); ?><br>
                        Price: $<?php echo htmlspecialchars($row['price']); ?> per night<br>
                        Available Rooms: <?php echo htmlspecialchars($row['number_of_rooms']); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="no-hotels">No hotels found in <?php echo htmlspecialchars($city); ?>.</p>
        <?php endif; ?>
        <a href="index.php">Search Again</a>
    </main>
    <footer>
        <p>&copy; 2024 Travel Vista. All Rights Reserved.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>