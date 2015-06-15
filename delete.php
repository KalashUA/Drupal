<?php
require('base/header.php');
$page_title = 'Delete article';

if(isset($_GET['id'])) { 
print 'Are yo sure want to delete artcle wis ID:'.$_GET['id'];
?>

<form action="?" method="post">
<button type="submit" name="confirm_del" value="1">ДА</button>
<button type="submit" name="confirm_del" value="0">НЕТ</button>
<input type="hidden" name="id" value="<?php print $_GET['id']; ?> ">
</form>
<?php
}
if(isset($_POST['confirm_del'])){
    if($_POST['confirm_del']==1){
		require ('articleobj.php');
       	A::delete($_POST ['id']);
		print '<h2>Your article was deleted and you may <a href="/">return to main page<a></h2>';
    }else{
        print 'Your article was safed';
    }
}

// Підключаємо футер сайту.
require('base/footer.php');
?>
