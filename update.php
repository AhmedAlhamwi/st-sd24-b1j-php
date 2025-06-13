<?php 
require 'db.php'; // Include the database connection file
global $db; // Use the global database connection
$id = $_GET['id']; // Get the category ID from the URL

// Prepare a query to fetch the category details based on the ID
$selectQuery = $db->prepare('SELECT * FROM category WHERE id = :id');
$selectQuery->bindParam('id', $id); // Bind the category ID parameter
$selectQuery->execute(); // Execute the query
$category = $selectQuery->fetch(PDO::FETCH_ASSOC); // Fetch the category data

const NAME_ERROR = "Vul een naam in"; // Define a constant for error message

// Check if the form is submitted
if (isset($_POST['submit'])) {    
    $errors = []; // Initialize an array for errors    
    $inputs = []; // Initialize an array for inputs    
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS); // Sanitize the input

    // Check if the name input is empty
    if (empty($name)) {        
        $errors['name'] = NAME_ERROR; // Add error message if name is empty    
    } else {        
        $inputs['name'] = $name; // Store the sanitized name    
    }    

    // If there are no errors, proceed to update the category
    if (count($errors) === 0) {        
        // Prepare a query to update the category name
        $query = $db->prepare('UPDATE category SET name = :name WHERE id = :id');        
        $query->bindParam('name', $inputs['name']); // Bind the name parameter        
        $query->bindParam('id', $id); // Bind the category ID parameter        
        $query->execute(); // Execute the update query        
        header('Location: index.php'); // Redirect to the index page after update    
    }
}
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
<form method="post">    
    <label for="name">Naam: </label>    
    <input type="text" id="name" name="name" value="<?= $category['name'] ?? '' ?>"> <!-- Pre-fill the input with the current category name -->
    <div><?= $errors['name'] ?? '' ?></div> <!-- Display error message if any -->
    <button name="submit">Verzenden</button> <!-- Submit button -->
</form>
</body>
</html>
