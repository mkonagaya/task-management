<?php
require_once("Task.php");
require_once("Request.php");

$task = new Task;
$records = $task->getRecords();

$request = new Request;
$is_done = $request->getQueryValue('is_done');
$category = $request->getQueryValue('category');
$order = $request->getQueryValue('order');

$all_attr = $is_done === "all" ? "checked" : "";
$complete_attr = $is_done === "complete" ? "checked" : "";
$incomplete_attr = $is_done === "incomplete" ? "checked" : "";

$category_all_attr = $category === "category-all" ? "checked" : "";
$work_attr = $category === "work" ? "checked" : "";
$hobby_attr = $category === "hobby" ? "checked" : "";

$asc_attr = $order === "asc" ? "checked" : "";
$desc_attr = $order === "desc" ? "checked" : "";

$min_date = date("Y-m-d");

$complete = $value['is_done'] === false ? "incomplete" : "complete";

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>task</title>
  <link rel="stylesheet" href="task.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
</head>

<body>
  <div class="registration">
    <form action="create.php" method="post">
      <div class="registration-deta">
        <input type="date" name="date" required min="<?php echo $min_date ?>">
      </div>
      <div class="registration-checkbox">
        <input type="radio" name="category" value="work" id="category-work" require>
        <label for="category-work" class="radio-text">work</label>
        <input type="radio" name="category" value="hobby" id="category-hobby" require>
        <label for="category-hobby" class="radio-text">hobby</label>
      </div>
      <div class="registration-textarea">
        <textarea name="content" id="" cols="30" rows="10" required></textarea>
      </div>
      <div class="registration-button">
        <input type="hidden" name="order" value="<?php echo $order ?>">
        <button type="submit" class="button registration-button button-decoration">OK</button>
      </div>
    </form>
  </div>

  <div class="search">
    <form action="index.php" method="get">
      <div class="search-complete">
        <input type="radio" name="is_done" value="all" id="all" class="radio-btn" <?php echo $all_attr; ?>>
        <label for="all" class="radio-text">all</label>
        <input type="radio" name="is_done" value="complete" id="complete" class="radio-btn" <?php echo $complete_attr; ?>>
        <label for="complete" class="radio-text">complete</label>
        <input type="radio" name="is_done" value="incomplete" id="incomplete" class="radio-btn" <?php echo $incomplete_attr; ?>>
        <label for="incomplete" class="radio-text">incomplete</label>
      </div>
      <div class="search-category">
        <input type="radio" name="category" value="category-all" id="category-all" class="radio-btn" <?php echo $category_all_attr; ?>>
        <label for="category-all" class="radio-text">all</label>
        <input type="radio" name="category" value="work" id="work" class="radio-btn" <?php echo $work_attr; ?>>
        <label for="work" class="radio-text">work</label>
        <input type="radio" name="category" value="hobby" id="hobby" class="radio-btn" <?php echo $hobby_attr; ?>>
        <label for="hobby" class="radio-text">hobby</label>
      </div>
      <div class="search-order">
        <input type="radio" name="order" value="asc" id="asc" class="radio-btn" <?php echo $asc_attr; ?>>
        <label for="asc" class="radio-text">↓</label>
        <input type="radio" name="order" value="desc" id="desc" class="radio-btn" <?php echo $desc_attr; ?>>
        <label for="desc" class="radio-text">↑</label>
      </div>
      <button type="submit" class="button search-button button-decoration"><i class="fas fa-search"></i></button>
    </form>
  </div>
  <img src="img/daruma.jpeg" alt="だるま" class="task-top-img">
  <?php foreach ($records as $key => $value) : ?>
    <div class="task-wrapper">
     
      <div class="content <?php if ((bool)$value['is_done'] === false) : ?>incomplete<?php else : ?>complete<?php endif; ?> 
        <?php echo $value['category'] ?>">

        <p> <?php //echo htmlspecialchars($value['category']); 
            ?> </p>
        <p> <?php echo htmlspecialchars($value['date']); ?> </p>
        <p> <?php echo nl2br(htmlspecialchars($value['content'])); ?></p>

        <?php if ((bool)$value['is_done'] === false) : ?>
          <form action="complete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
            <input type="hidden" name="is_done" value="<?php echo $is_done ?>">
            <input type="hidden" name="category" value="<?php echo $category ?>">
            <input type="hidden" name="order" value="<?php echo $order ?>">
            <button type="submit" class="button-decoration"><i class="far fa-square"></i></button>
            
          </form>
        <?php else : ?>
          <form action="incomplete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
            <input type="hidden" name="is_done" value="<?php echo $is_done ?>">
            <input type="hidden" name="category" value="<?php echo $category ?>">
            <input type="hidden" name="order" value="<?php echo $order ?>">
            <button type="submit" class="button-decoration"><i class="far fa-check-square"></i></button>
            <p><i class="far fa-circle"></i></p>
            <p class="cercle">はなまる！</p>
          </form>
        <?php endif; ?>

        <form action="delete.php" method="post">
          <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
          <input type="hidden" name="order" value="<?php echo $order ?>">
          <button type="submit" class="button-decoration"><i class="fas fa-times"></i></button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</body>

</html>