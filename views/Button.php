<?php
$location = $location ?? '/home';
$name = $name ?? "Home";
$image = $image ?? "/public/resources/dashboard.png";
?>

<a href="<?= $location ?>" class="nav-button-container">
    <img src="<?= $image ?>" style="max-width: 20px; max-height: 20px">
    <p class="nav-text"><?= $name ?></p>
</a>