<?php
// Include the database and user classes
include 'database.php';
include 'user.php';

// Check if the matric parameter is provided in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);

    // Call the deleteUser method to delete the user by matric
    $deleteResult = $user->deleteUser($matric);

    // Close the connection
    $db->close();

    // Check if the user was deleted successfully
    if ($deleteResult === true) {
        // Redirect back to the user list or any other page after successful deletion
        header("Location: user_list.php?message=User deleted successfully");
        exit(); // Ensure no further code is executed
    } else {
        // If deletion failed, show an error message
        echo "<p style='color: red;'>Error: $deleteResult</p>";
    }
} else {
    // If matric parameter is missing, show an error
    echo "<p style='color: red;'>Matric parameter is missing!</p>";
}
?>
