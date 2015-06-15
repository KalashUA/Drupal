<?php
// Задаємо заголовок сторінки.
$page_title = 'Edit article';

require('base/header.php');

// Якщо на сторінку зайшов НЕ редактор, тоді даємо у відповідь статус 403 та пишемо повідомлення.
if (!$editor) {
  header('HTTP/1.1 403 Unauthorized');
  print 'Доступ заборонено.';
  // Підключаємо футер та припиняємо роботу скрипта.
  require('base/footer.php');
  exit;
}
require ('articleobj.php');
A::edit();
$obj=A::select();

?>

<!-- Пишемо форму, метод ПОСТ, форма відправляє данні на цей же скрипт. -->
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">

  <div class="field-item">
    <label for="title">Заголовок</label>
    <input type="text" name="title" id="title" required maxlength="255" value="<?php print $obj->title; ?>">
</div>

  <div class="field-item">
    <label for="short_desc">Короткий зміст</label>
    <textarea name="short_desc" id="short_desc" required maxlength="600"><?php print $obj->short_desc; ?></textarea>
  </div>

  <div class="field-item">
    <label for="full_desc">Повний зміст</label>
    <textarea name="full_desc" id="full_desc" required><?php print $obj->full_desc; ?></textarea>
  </div>

  <div class="field-item">
    <label for="date">День створення</label>
    <input type="date" name="date" id="date" required value="<?php print date('Y-m-d', $obj->timestamp)?>">
    <label for="time">Час створення</label>
    <input type="time" name="time" id="time" required value="<?php print date('G:i', $obj->timestamp)?>">
  </div>
  <input type="hidden" name="id" value="<?php print $obj->id; ?>">
  <input type="submit" name="submit" value="Зберегти">

</form>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
