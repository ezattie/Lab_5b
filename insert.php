<?php
// Include the database and user classes
include 'database.php';
include 'user.php';

// Create an instance of the Database class and get the connection
$database = new Database();
$db = $database->getConnection();

// Create an instance of the User class
$user = new User($db);

// Register the user using POST data if POST is used
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $createResult = $user->createUser($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role']);
}

// Fetch all users for display
$sql = "SELECT matric, name, role FROM users";
$result = $db->query($sql);

// Close the database connection (do it at the end)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-btns a {
            margin-right: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .action-btns a.delete {
            background-color: #dc3545;
        }
        .action-btns a.update {
            background-color: #28a745;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">User List</h2>
    
    <?php
    if (isset($createResult)) {
        // Display success or error message from user creation
        if ($createResult === true) {
            echo "<p style='text-align: center; color: green;'>User created successfully.</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error: $createResult</p>";
        }
    }
    ?>
    
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['matric']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td class='action-btns'>";
                    echo "<a href='update.php?matric=" . urlencode($row['matric']) . "' class='update'>Update</a>";
                    echo "<a href='delete.php?matric=" . urlencode($row['matric']) . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
// Close the database connection
$db->close();
?>
