<?php
include 'config.php';

// Handle Create (Insert)
if (isset($_POST['add_room'])) {
    $room_num = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['monthly_price'];
    mysqli_query($conn, "INSERT INTO tb_room (room_number, room_type, monthly_price) VALUES ('$room_num', '$room_type', '$price')");
    header("Location: index.php");
}

// Handle Delete
if (isset($_GET['delete_room'])) {
    $id = $_GET['delete_room'];
    mysqli_query($conn, "DELETE FROM tb_room WHERE room_id = $id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boarding House - Room Management</title>
</head>
<body>
    <h2>Boarding House Management System</h2>
    <p><a href="index.php"><b>Manage Rooms</b></a> | <a href="residents.php">Manage Residents</a></p>
    <hr>

    <h3>Add New Room</h3>
    <form method="POST" action="">
        <input type="text" name="room_number" placeholder="Room Number" required>
        <input type="text" name="room_type" placeholder="Room Type" required>
        <input type="number" name="monthly_price" placeholder="Monthly Price" required>
        <button type="submit" name="add_room">Save Room</button>
    </form>

    <h3>Room List</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Monthly Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $rooms = mysqli_query($conn, "SELECT * FROM tb_room");
        while ($row = mysqli_fetch_assoc($rooms)) {
            echo "<tr>
                    <td>{$row['room_id']}</td>
                    <td>{$row['room_number']}</td>
                    <td>{$row['room_type']}</td>
                    <td>{$row['monthly_price']}</td>
                    <td>{$row['room_status']}</td>
                    <td><a href='index.php?delete_room={$row['room_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
