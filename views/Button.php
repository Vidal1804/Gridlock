<?php
$location = $location ?? '/home';
$name = $name ?? "Home";
?>

<a href="<?= $location ?>"><button class="primary-btn nav-btn"><?= $name ?></button></a>