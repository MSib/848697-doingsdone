<h2 class="content__main-heading">На странице произошли следующие ошибки:</h2>
<ul>
<?php foreach($error_page as $err_value):?>
    <li class="main-navigation__list-item-link"><?=$err_value?></li>
<?php endforeach; ?>
</ul>
