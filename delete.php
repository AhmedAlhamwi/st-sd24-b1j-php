<?php
session_start();
global $db;
require 'db.php';
$id = $_GET['id'];

if (isset($_SESSION['login']) && $_SESSION['login']) {
    $userQuery = $db->prepare('SELECT * FROM users WHERE email = :email');
    $userQuery->bindParam('email', $_SESSION['email']);
    $userQuery->execute();
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);
    if ($user['role'] !== 'ROLE_ADMIN') {
        $requerd = $db->prepare("DELETE FROM catagory WHERE id = :id");
        $requerd->bindParam(':id', $id);
        $requerd->execute();
        $_SESSION['message'] = 'Categorie succesvol verwijderd.';
    }
}
header('Location: index.php');
?>