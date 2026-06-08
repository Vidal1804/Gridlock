<?php
$location = $location ?? '/home';
$name = $name ?? "Home";
$image = $image ?? "/public/resources/dashboard.png";
$current_page = $current_page ?? '';
?>

<a href="<?= $location ?>" class="nav-button-container">
    <img src="<?= $image ?>" style="max-width: 20px; max-height: 20px;">
    <p class="<?php if($current_page === $location){echo "open-text";} else{echo "nav-text";} ?>"><?= $name ?></p>
</a>