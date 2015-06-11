<?php

// Підключаємо хедер сайту.
require('base/header.php');
// Підключаємо файл БД, адже нам необхідно вибрати статті.
require('base/db.php');
$items    = array();
 
// Число вообще всех элементов ( без LIMIT ) по нужным критериям.
$allItems = 0;
 
// HTML - код постраничной навигации.
$html     = NULL;
 
// Количество элементов на странице. 
// В системе оно может определяться например конфигурацией пользователя: 
$limit    = 2;
 
// Количество страничек, нужное для отображения полученного числа элементов:
$pageCount = 0;
 
// Содержит наш GET-параметр из строки запроса. 
// У первой страницы его не будет, и нужно будет вместо него подставить 0!!!
$start    = isset($_GET['start'])   ? intval($_GET['start']) : 0 ;

try {

  // Вибираємо усі з необхідними полями статті та поміщаємо їх у змінну $articles.
  $stmt = $conn->prepare('SELECT id, title, short_desc, timestamp FROM content ORDER BY timestamp DESC LIMIT :start, :limit');
  $stmt->bindParam(':start', $start, PDO::PARAM_INT);	
  $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);	

  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  // Виводимо на екран помилку.
  print "ERROR: {$e->getMessage()}";
  // Закриваємо футер.
  require('base/footer.php');
  // Зупиняємо роботу скрипта.
  exit;
}

?>
<!-- Вітальне повідомленя на головній сторінці. -->
<h1> Welcome to blog site!</h1>
<!-- Виводимо статті у тегах -->
<div class="articles-list">

  <?php if (empty($articles)): ?>
    <!-- У випадку, якщо статтей немає - виводимо повідомлення. -->
    Статті відсутні.
  <?php endif; ?>
  <?php foreach ($articles as $article): ?>
    <div class="article-item">

      <h2><a href="/article.php?id=<?php print $article['id']; ?>"><?php print $article['title']; ?></a></h2>

      <div class="description">
        <?php print $article['short_desc']; ?>
      </div>

      <div class="info">
        <div class="timestamp">
          <!-- Вивід відформатованої дати створення. -->
          <?php print date('d/m/Y G:i', $article['timestamp']); ?>
        </div>
        <div class="links">
          <a href="/article.php?id=<?php print $article['id']; ?>">Читати далі</a>
          <!-- Посилання доступні тільки для редактора. -->
           <?php if ($editor): ?>
            <a href="/edit.php?id=<?php print $article['id']; ?>">Редагувати</a>
            <a href="/delete.php?id=<?php print $article['id']; ?>">Видалити</a>
           
          <?php endif; ?>
        </div>
      </div>

    </div>
    <hr>
  <?php endforeach; ?>

  <div class="paginator">
        <?php $sql = 'SELECT' . '  COUNT(*) AS `count` ' . 'FROM ' . '  `content` ';
 
        $stmt     = $conn->query($sql);
        $allItems = $stmt->fetch(PDO::FETCH_OBJ)->count;

        // Здесь округляем в большую сторону, потому что остаток
        // от деления - кол-во страниц тоже нужно будет показать
        // на ещё одной странице.
        $pageCount = ceil( $allItems / $limit);

        // Начинаем с нуля! Это даст нам правильные смещения для БД
        for( $i = 0; $i < $pageCount; $i++ ) {    
            // Здесь ($i * $limit) - вычисляет нужное для каждой страницы  смещение, 
            // а ($i + 1) - для того что бы нумерация страниц начиналась с 1, а не с 0
            $html .= '<li><a href="index.php?' . '&start=' . ($i * $limit)  . '">' . ($i + 1)  . '</a></li>';
        }

        // Собственно выводим на экран:
        print '<ul class="pagination">' . $html . '</ul>';
        ?>
 
  </div>

</div>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
