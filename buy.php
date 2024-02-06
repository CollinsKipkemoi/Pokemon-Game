<?php
$cardAndUser = $_GET["info"];
$card = explode(" ", $cardAndUser)[0];
$user = explode(" ", $cardAndUser)[1];
include_once("./storage.php");
$cards = new Storage(new JsonIO("./pokemon.json"));
$users = new Storage(new JsonIO("./userData.json"));
$cardData = $cards->findById($card);
$cardData["id"] = $card;
$userData = null;
$userId = null;
foreach($users->findAll() as $key => $value){
    if($value["username"] === $user){
        $userData = $value;
        $userId = $key;
        break;
    }
}
if($userData === null){
    header("Location: index.php");
    exit;
}
if($cardData === null ){
    header("Location: index.php");
    exit;
}
if($userData["amount"] < $cardData["price"]){
    header("Location: index.php");
    exit;
} else{
    $userData["amount"] -= $cardData["price"];
    $cards -> update($card, $cardData);
    // add the card to the user's cards
    $userData["cards"][] = $cardData;
    if ($userId !== null) {
        $users->update($userId, $userData);
    }
    $cards->delete($card);
    header("Location: index.php");
    exit;
}
?>