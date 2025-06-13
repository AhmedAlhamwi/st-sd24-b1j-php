<?php
session_start(); // Start the session to access session variables
require 'db.php'; // Include the database connection file
global $db; // Use the global database connection

// Check if the user is logged in
if (isset($_SESSION['login']) && $_SESSION['login']) {
    // Prepare a query to fetch user details based on their email
    $userQuery = $db->prepare('SELECT * FROM users WHERE email = :email');
    $userQuery->bindParam('email', $_SESSION['email']); // Bind the email parameter
    $userQuery->execute(); // Execute the query
    $user = $userQuery->fetch(PDO::FETCH_ASSOC); // Fetch the user data
}

// Prepare a query to fetch all categories
$query = $db->prepare('SELECT * FROM category');
$query->execute(); // Execute the query

$categories = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all categories

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   <?php if (isset($_SESSION['message'])): // Check if there is a message to display ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?> <!-- Display the message -->
        </div>
        <?php unset($_SESSION['message']); // Clear the message after displaying it ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): // Check if there is an error to display ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?> <!-- Display the error -->
        </div>
        <?php unset($_SESSION['error']); // Clear the error after displaying it ?>
    <?php endif; ?>
    

    <h1>Categories</h1>
    <a href="insert.php">Category toevoegen</a> <!-- Link to add a new category -->
    <table>
        <thead>
        <tr>
            <th scope="col">Categorie</th>
            <th scope="col">Producten</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): // Loop through each category ?>
            <tr>
                <td><?= $category['name'] ?></td> <!-- Display category name -->
                <td><a href="products.php?id=<?= $category['id'] ?>">Producten</a></td> <!-- Link to products in the category -->
                <?php if (isset($user) && $user['role'] === 'ROLE_ADMIN'): // Check if the user is an admin ?>
                    <td><a href="update.php?id=<?= $category['id'] ?>">update</a></td> <!-- Link to update the category -->
                    <td><a href="delete.php?id=<?= $category['id'] ?>">delete</a></td> <!-- Link to delete the category -->
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
