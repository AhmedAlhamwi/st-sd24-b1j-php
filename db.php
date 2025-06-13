<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=vegetables', 'root', '');
} catch (PDOException $e){
    die('Error! ' . $e->getMessage());
}
?>