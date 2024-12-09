<?php
// Include the database and user classes
include 'database.php';
include 'user.php';

// Create a new instance of the Database class
$database = new Database();
$db = $database->getConnection();

// Create an instance of the User class
$user = new User($db);

// Check if matric is provided in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch the user details based on matric
    $userDetails = $user->getUser($matric);

    // If user not found, redirect or show an error
    if (!$userDetails) {
        echo "User not found!";
        exit;
    }

    // Handle form submission for updating user
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $role = $_POST['role'];

        // Update user information
        $updateResult = $user->updateUser($matric, $name, $role);

        // Check if the update was successful
        if ($updateResult === true) {
            echo "<p style='color: green;'>User updated successfully.</p>";
        } else {
            echo "<p style='color: red;'>Error: $updateResult</p>";
        }
    }
} else {
    echo "Matric parameter is missing!";
    exit;
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>

    <h2 style="text-align: center;">Update User</h2>

    <!-- Display the update form -->
    <form method="post" style="max-width: 400px; margin: 0 auto;">
        <label for="matric">Matric:</label><br>
        <input type="text" name="matric" id="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>" readonly><br><br>

        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required><br><br>

        <label for="role">Role:</label><br>
        <select name="role" id="role" required>
            <option value="Lecturer" <?php echo ($userDetails['role'] == 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
            <option value="Student" <?php echo ($userDetails['role'] == 'Student') ? 'selected' : ''; ?>>Student</option>
        </select><br><br>

        <input type="submit" value="Update" style="margin-right: 10px;">
        <a href="insert.php" style="text-decoration: none; padding: 2px;">Cancel</a>
    </form>

</body>
</html>
