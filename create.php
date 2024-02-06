<?php
include_once("storage.php");
$cards = new Storage(new JsonIO("./pokemon.json"));
$users = new Storage(new JsonIO("./userData.json"));
$adminData = $users->findById('admin');

$name = $_POST["name"] ?? "";
$type = $_POST["type"] ?? "";
$hp = $_POST["hp"] ?? "";
$attack = $_POST["attack"] ?? "";
$defense = $_POST["defense"] ?? "";
$price = $_POST["price"] ?? "";
$image = $_POST["image"] ?? "";
$description = $_POST["description"] ?? "";

$errors = [];
if (isset($_POST)) {
    if ($name === "") {
        $errors["name"] = "Name is required";
    }
    if ($type === "") {
        $errors["type"] = "Type is required";
    }
    if ($hp === "") {
        $errors["hp"] = "HP is required";
    }
    if ($attack === "") {
        $errors["attack"] = "Attack is required";
    }
    if ($defense === "") {
        $errors["defense"] = "Defense is required";
    }
    if ($price === "") {
        $errors["price"] = "Price is required";
    }
    if ($image === "") {
        $errors["image"] = "Image URL is required";
    }
    if ($description === "") {
        $errors["description"] = "Description is required";
    }
}
if (count($errors) === 0) {
    $card = [
        "name" => $name,
        "type" => $type,
        "hp" => intval($hp),
        "attack" => intval($attack),
        "defense" => intval($defense),
        "price" => intval($price),
        "image" => $image,
        "description" => $description,
        'owner' => 'admin',
        'id' => uniqid()
    ];
    $cards->add($card);
    $adminData['cards'][] = $card;
    $users->update('admin', $adminData);
    header("location: index.php");
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        h2 {
            margin-top: 20px;
            text-align: center;
            color: rgb(81, 125, 129);
            ;
        }
    </style>
    <title>Create A New Card</title>
</head>

<body>
    <div class="title">
        <div class="first">
            <h1><a href="index.php">IKémon > NewCard</a></h1>
        </div>
        <div class="sign">

            <button><a href="index.php">Home</a> </button>
        </div>
    </div>
    <h2>Create a new card</h2>
    <form class="create" method="post" action="create.php" novalidate>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Card name" value = <?=$name ?? ''?>>
        <?= !empty($_POST) && isset($errors['name']) ? "<p class='error'>" . $errors['name'] . "</p>" : "" ?>
        <label for="type">Type</label>
        <select name="type" id="type">
            <option value="fire">Fire</option>
            <option value="water">Water</option>
            <option value="grass">Grass</option>
            <option value="electric">Electric</option>
            <option value="normal">Normal</option>
            <option value="poison">Poison</option>
            <option value="bug">Bug</option>
            <option value="fairy">Fairy</option>
        </select>
        <?= !empty($_POST) && isset($errors['type']) ? "<p class='error'>" . $errors['type'] . "</p>" : "" ?>
        <label for="hp">HP</label>
        <input type="number" name="hp" id="hp" placeholder="hp" value=<?=$hp ?? ''?>>
        <?= !empty($_POST) && isset($errors['hp']) ? "<p class='error'>" . $errors['hp'] . "</p>" : "" ?>
        <label for="attack">Attack</label>
        <input type="number" name="attack" id="attack" placeholder='attack' value=<?=$attack ?? ''?>>
        <?= !empty($_POST) && isset($errors['attack']) ? "<p class='error'>" . $errors['attack'] . "</p>" : "" ?>
        <label for="defense">Defense</label>
        <input type="number" name="defense" id="defense" placeholder="defense" value=<?=$defense ?? ''?>>
        <?= !empty($_POST) && isset($errors['defense']) ? "<p class='error'>" . $errors['defense'] . "</p>" : "" ?>
        <label for="price">Price</label>
        <input type="number" name="price" id="price" placeholder="price" value=<?=$price ?? ''?>>
        <?= !empty($_POST) && isset($errors['price']) ? "<p class='error'>" . $errors['price'] . "</p>" : "" ?>
        <label for="description">Description</label>
        <input type="text" name="description" id="description" placeholder="description" value=<?=$description ?? ''?>>
        <?= !empty($_POST) && isset($errors['description']) ? "<p class='error'>" . $errors['description'] . "</p>" : "" ?>
        <label for="image">Image</label>
        <input type="text" name="image" id="image" placeholder="Image URL" value=<?=$image ?? ''?>>
        <?= !empty($_POST) && isset($errors['image']) ? "<p class='error'>" . $errors['image'] . "</p>" : "" ?>
        <input type="submit" value="Create">
    </form>
</body>

</html>