<?php
$page_title = 'Delete article';
require('base/db.php');
if (isset($_GET['id'])) 

        try {
            $stmt = $conn->prepare('DELETE FROM content WHERE id= :id');
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);	
            $stmt->execute();
        } 
        catch(PDOException $e) {
            print "ERROR: {$e->getMessage()}";
            require('base/footer.php');
            exit;
        }

require('base/header.php');
?>
<h2>Your article with ID:<?php print $_GET['id'];?> was deleted and you may <a href="/">return to main page<a></h2>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
