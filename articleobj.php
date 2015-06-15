<?php

	
class A {
	public $id;
	public $title;
	public $full_desc;
	public $timestamp;
	public $short_desc;
		
	public function __construct ($id, $title, $full_desc, $timestamp,$short_desc) {
		$this->id = $id;
		$this->title = $title;
		$this->full_desk = $full_desc;
		$this->timestamp = $timestamp;
		$this->short_desc= $short_desc;
	}
	
	public function select() {
		 require('base/db.php');
		try {
		 $stmt = $conn->prepare('SELECT id, title, full_desc, timestamp, short_desc FROM content WHERE id = :id');
	  // Додаємо плейсхолдер.
		  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);	
		  $stmt->execute();
		  // Витягуємо статтю з запиту.
		  $article = $stmt->fetch(PDO::FETCH_ASSOC);
		  return new A ($article ['id'], $article ['title'], $article ['full_desc'], $article ['timestamp'], $article ['short_desc']);
		} catch (PDOException $e) {
			print "ERROR: {$e->getMessage()}";
			require('base/footer.php');
			exit;
		}
	}
	public function add() {
		require('base/db.php');
		if (isset($_POST['submit'])) {
		try {
    $stmt = $conn->prepare('INSERT INTO content VALUES(NULL, :title, :short_desc, :full_desc, :timestamp)');

    // Обрізаємо усі теги у загловку.
    $stmt->bindParam(':title', strip_tags($_POST['title']));

    // Екрануємо теги у полях короткого та повного опису.
    $stmt->bindParam(':short_desc', htmlspecialchars($_POST['short_desc']));
    $stmt->bindParam(':full_desc', htmlspecialchars($_POST['full_desc']));

    // Беремо дату та час, переводимо у UNIX час.
    $date = "{$_POST['date']}  {$_POST['time']}";
    $stmt->bindParam(':timestamp', strtotime($date));
    // Виконуємо запит, результат запиту знаходиться у змінні $status.
    // Якщо $status рівне TRUE, тоді запит відбувся успішно.
    $status = $stmt->execute();

  } catch(PDOException $e) {
    // Виводимо на екран помилку.
    print "ERROR: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }

  // При успішному запиту перенаправляємо користувача на сторінку перегляду статті.
  if ($status) {
    // За допомогою методу lastInsertId() ми маємо змогу отрмати ІД статті, що була вставлена.
    header("Location: article.php?id={$conn->lastInsertId()}");
    exit;
  }
  else {
    // Вивід повідомлення про невдале додавання матеріалу.
    print "Запис не був доданий.";
  }
}
	
		
	
	

}
	public function edit(){
	self::select();
	if (isset($_POST['submit'])) {

  try {
    $stmt = $conn->prepare('UPDATE content SET title= :title, short_desc= :short_desc, full_desc= :full_desc, timestamp= :timestamp WHERE id=     :id');

    // Обрізаємо усі теги у загловку.
    $stmt->bindParam(':title', strip_tags($_POST['title']));

    // Екрануємо теги у полях короткого та повного опису.
    $stmt->bindParam(':short_desc', htmlspecialchars($_POST['short_desc']));
    $stmt->bindParam(':full_desc', htmlspecialchars($_POST['full_desc']));
    // Беремо дату та час, переводимо у UNIX час.
    $date = "{$_POST['date']}  {$_POST['time']}";
    $stmt->bindParam(':timestamp', strtotime($date));
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    // Виконуємо запит, результат запиту знаходиться у змінні $status.
    // Якщо $status рівне TRUE, тоді запит відбувся успішно.
    $status = $stmt->execute();

  } catch(PDOException $e) {
    // Виводимо на екран помилку.
    print "ERROR: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }

  // При успішному запиту перенаправляємо користувача на сторінку перегляду статті.
  if ($status) {
    // За допомогою методу lastInsertId() ми маємо змогу отрмати ІД статті, що була вставлена.
      header("Location: article.php?id={$_POST['id']}");
    exit;
  }
  else {
    // Вивід повідомлення про невдале додавання матеріалу.
    print "Запис не був доданий.";
  }
}
	}
	public function delete () {
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
	}
}


$obj=A::select();
print $obj->title;

