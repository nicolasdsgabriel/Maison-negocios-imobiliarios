<?php

include('BD/config.php');

$id = $_POST['id']; //as variáveis recebem os valores através de post com o AJAX
$flagFav = $_POST['flagFav'];

$update = $pdo->prepare("UPDATE Catalogo SET flagFav = ? WHERE CatalogoID = ?");
$update->execute([$flagFav, $id]);


//include('BD/config.php');

//$id = $_GET['imID'];
//$flagFav = $_GET['flagFav'];

//$update = $pdo->prepare("UPDATE Imoveis SET flagFav = ? WHERE imID = ?");
//$update->bindParam(1, $flagFav);
//$update->bindParam(2, $id);
//$update->execute();
