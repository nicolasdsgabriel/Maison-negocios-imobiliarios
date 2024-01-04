<?php
session_start();
require('BD/config.php');
$cliente = $_SESSION['cliente_id'];
$id = $_GET['imovel']; //as variáveis recebem os valores através de post com o AJAX
$flagFav = 1;

$update = $pdo->prepare("INSERT INTO Catalogo (flagFav, imID, clienteID) VALUES (?, ?, ?)");

if($update->execute([$flagFav, $id, $cliente])){
    header("Location: index.php");
}
//include('BD/config.php');

//$id = $_GET['imID'];
//$flagFav = $_GET['flagFav'];

//$update = $pdo->prepare("UPDATE Imoveis SET flagFav = ? WHERE imID = ?");
//$update->bindParam(1, $flagFav);
//$update->bindParam(2, $id);
//$update->execute();
?>