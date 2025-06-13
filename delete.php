<?php
session_start(); // Start the session
global $db; // Use the global database connection
require 'db.php'; // Include the database connection file

$id = $_GET['id']; // Get the category ID from the URL

// Check if the user is logged in
if (isset($_SESSION['login']) && $_SESSION['login']) {
    // Prepare a query to fetch user details based on their email
    $userQuery = $db->prepare('SELECT * FROM users WHERE email = :email');
    $userQuery->bindParam('email', $_SESSION['email']); // Bind the email parameter
    $userQuery->execute(); // Execute the query
    $user = $userQuery->fetch(PDO::FETCH_ASSOC); // Fetch the user data

    // Check if the user is an admin
    if ($user['role'] === 'ROLE_ADMIN') {
        $productQuery = $db->prepare('SELECT * FROM products WHERE category_id = :id'); // Prepare a query to fetch products in the category
        $productQuery->bindParam('id', $id); // Bind the category ID parameter
        $productQuery->execute(); // Execute the query
        $products = $productQuery->fetchAll(PDO::FETCH_ASSOC); // Fetch all products in the category
        if (count($products) == 0) {
        // Prepare a query to delete the category
        $requerd = $db->prepare("DELETE FROM category WHERE id = :id"); // Corrected table name
        $requerd->bindParam(':id', $id); // Bind the category ID parameter
        $requerd->execute(); // Execute the delete query
        $_SESSION['message'] = 'Categorie succesvol verwijderd.'; // Set success message
    } else {
        $_SESSION['error'] = 'Categorie kan niet worden verwijderd omdat er producten aan zijn gekoppeld.'; // Set error message if products exist
    }
}
}
header('Location: index.php'); // Redirect to the index page
?>