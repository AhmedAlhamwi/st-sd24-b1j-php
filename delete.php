<?php
require_once 'db.php';
$id = $_GET['id'];
$requerd = $db->prepare("DELETE FROM catagory WHERE id = :id");
$requerd->bindParam(':id', $id);
$requerd->execute();
header('Location: index.php');
?>