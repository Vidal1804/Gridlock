<?php
$location = $location ?? '/home';
$name = $name ?? "Home";
$image = $image ?? "/public/resources/dashboard.png";
$current_page = $current_page ?? '';

$isActive = (strpos($current_page, $location) === 0);
?>

<a href="<?= $location ?>" class="nav-button-container">
    <img src="<?= $image ?>" style="max-width: 20px; max-height: 20px;">
    <p class="<?php if($isActive){echo "open-text";} else{echo "nav-text";} ?>"><?= $name ?></p>
</a>