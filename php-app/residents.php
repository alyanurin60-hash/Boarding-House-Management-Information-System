<?php
include 'config.php';

// Handle Create (Insert)
if (isset($_POST['add_resident'])) {
    $name = $_POST['resident_name'];
    $phone = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['origin_address'];
    $room_id = $_POST['room_id'] ? $_POST['room_id'] : "NULL";

    mysqli_query($conn, "INSERT INTO tb_resident (room_id, resident_name, phone_number, email, origin_address) VALUES ($room_id, '$name', '$phone', '$email', '$address')");
    if ($_POST['room_id']) {
        mysqli_query($conn, "UPDATE tb_room SET room_status = 'Occupied' WHERE room_id = $room_id");
    }
    header("Location: residents.php");
}

// Handle Delete
if (isset($_GET['delete_resident'])) {
    $id = $_GET['delete_resident'];
    mysqli_query($conn, "DELETE FROM tb_resident WHERE resident_id = $id");
    header("Location: residents.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boarding House - Resident Management</title>
</head>
<body>
    <h2>Boarding House Management System</h2>
    <p><a href="index.php">Manage Rooms</a> | <a href="residents.php"><b>Manage Residents</b></a></p>
    <hr>

    <h3>Add New Resident</h3>
    <form method="POST" action="">
        <input type="text" name="resident_name" placeholder="Full Name" required><br><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br><br>
        <input type="email" name="email" placeholder="Email Address"><br><br>
        <textarea name="origin_address" placeholder="Origin Address"></textarea><br><br>
        <select name="room_id">
            <option value="">-- Assign Room (Optional) --</option>
            <?php
            $available_rooms = mysqli_query($conn, "SELECT * FROM tb_room WHERE room_status = 'Available'");
            while($r = mysqli_fetch_assoc($available_rooms)) {
                echo "<option value='{$r['room_id']}'>Room {$r['room_number']} ({$r['room_type']})</option>";
            }
            ?>
        </select><br><br>
        <button type="submit" name="add_resident">Register Resident</button>
    </form>

    <h3>Active Resident List</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Room ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Origin Address</th>
            <th>Action</th>
        </tr>
        <?php
        $residents = mysqli_query($conn, "SELECT * FROM tb_resident");
        while ($row = mysqli_fetch_assoc($residents)) {
            $room_display = $row['room_id'] ? $row['room_id'] : "Not Assigned";
            echo "<tr>
                    <td>{$row['resident_id']}</td>
                    <td>{$room_display}</td>
                    <td>{$row['resident_name']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['origin_address']}</td>
                    <td><a href='residents.php?delete_resident={$row['resident_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
