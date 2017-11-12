<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?= htmlentities($pageTitle); ?></title>
  </head>
  <body>
    <h1><?= htmlentities($pageTitle); ?></h1>
    <form action="?<?= htmlentities($action); ?>" method="post">
      <div>
        <label for="name">Название предприятия: <input type="text" name="name"
            id="name" value="<?= htmlentities($name); ?>"></label>
      </div>
      <div>
        <label for="controllerid">контролер:</label>
        <select name="controllerid" id="controllerid">
            <option value="">Выберите контролера</option>
              <?php foreach ($controllers as $controller): ?>
                  <option value="<?= htmlentities($controller['id']); ?>"<?php
                  if ($controller['id'] == $controllerid)
                  {
                    echo ' selected';
                  }
                  ?>><?= htmlentities($controller['name']); ?></option>
              <?php endforeach; ?>
        </select>
      </div>
      <div>
        <input type="hidden" name="id" value="<?= htmlentities($id); ?>">
        <input type="submit" value="<?= htmlentities($button); ?>">
      </div>
    </form>
  </body>
</html>
