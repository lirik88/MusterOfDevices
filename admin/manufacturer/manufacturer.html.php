<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник контролеров</title>
  </head>
  <body>
    <h1>Справочник производителей приборов</h1>
    <p><a href="../devicetype/">В справочник приборов</a></p>
    <p><a href="?add">Добавить производителя прибора</a></p>
    <ul>
      <?php if (!empty($manufacturers)): ?>
          <?php foreach ($manufacturers as $manufacturer): ?>
            <li>
              <form action="" method="post">
                <div>
                  <?= htmlentities($manufacturer['name']); ?>
                  <input type="hidden" name="id" value="<?= $manufacturer['id']; ?>">
                  <input type="submit" name="action" value="Редактировать">
                  <input type="submit" name="action" value="Удалить">
                </div>
              </form>
            </li>
          <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </body>
</html>
