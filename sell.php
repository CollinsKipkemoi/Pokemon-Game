<?php
$cardAndUser = $_GET["id"];
include_once("./storage.php");
$card = explode(" ", $cardAndUser)[0];
$userId = explode(" ", $cardAndUser)[1];
$cards = new Storage(new JsonIO("./pokemon.json"));
$users = new Storage(new JsonIO("./userData.json"));
$userData = $users->findById($userId);
foreach ($userData["cards"] as $key => $value) {
 if($value['id'] === $card){
    $userData["amount"] += $value["price"] * 0.9;
    $value["owner"] = "admin";
    $cards -> add($value);
    unset($userData["cards"][$key]);
    $users->update($userId, $userData);
    header("Location: ./index.php");
 }
}

?>