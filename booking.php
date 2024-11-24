<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "travelvista"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$hotel_id = $_GET['id'];

$sql = "SELECT name, address, number_of_rooms, price FROM hotels WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - <?php echo htmlspecialchars($hotel['name'] ?? ''); ?> - Travel Vista</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #35424a;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 20px;
            background: #ffffff;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            margin: 0 0 20px;
        }
        p {
            line-height: 1.6;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #35424a;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background: #454d55;
        }
        .error-message {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #35424a;
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Travel Vista</h1>
    </header>
    <main>
        <?php if (!$hotel): ?>
            <div class="error-message">
                <h2>Booking Unavailable</h2>
                <p>We are sorry, but you cannot book this hotel as it is not available.</p>
            </div>
        <?php else: ?>
            <h2>Booking for <?php echo htmlspecialchars($hotel['name']); ?></h2>
            <p>Address: <?php echo htmlspecialchars($hotel['address']); ?></p>
            <p>Price: $<?php echo htmlspecialchars($hotel['price']); ?> per night</p>        
            <p>Rooms available: <?php echo htmlspecialchars($hotel['number_of_rooms']); ?></p>        
            <form action="process_booking.php" method="POST">
                <input type="hidden" name="hotel_id" value="<?php echo htmlspecialchars($hotel_id); ?>">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="checkin_date">Check-in Date:</label>
                <input type="date" id="checkin_date" name="checkin_date" required>

                <label for="checkout_date">Check-out Date:</label>
                <input type="date" id="checkout_date" name="checkout_date" required>

                <label for="special_requests">Special Requests:</label>
                <textarea id="special _requests" name="special_requests" rows="4" cols="50"></textarea>

                <input type="submit" value="Book Now">
            </form>
        <?php endif; ?>
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