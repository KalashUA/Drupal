<?php
$page_title = 'Delete article';
require ('articleobj.php');
A::delete();
require('base/header.php');
?>
<h2>Your article with ID:<?php print $_GET['id'];?> was deleted and you may <a href="/">return to main page<a></h2>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
