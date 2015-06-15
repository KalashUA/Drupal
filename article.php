<?php

require ('articleobj.php');
$obj=A::select();
// Задаємо заголовок сторінки.
$page_title = "{$obj->title} | Blog site";

// Підключаємо шапку сайту.
require('base/header.php');
?>

<!-- Виводимо статтю у тегах -->
<div class="article-once">
  <h1><?php print $obj->title; ?></h1>
  <div class="info-wrapp">
    <span class="timestamp"><?php print date('d/m/Y G:i', $obj->timestamp); ?></span>
    <? if($editor): ?>
      <a href="/edit.php?id=<?php print $obj->id; ?>">Редагувати</a>
      <a href="/delete.php?id=<?php print $obj->id; ?>">Видалити</a>
    <? endif; ?>
  </div>
  <div class="full-desc">
    <?php print $obj->full_desc; ?>
  </div>
</div>


<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
