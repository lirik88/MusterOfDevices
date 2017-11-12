<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник контролеров</title>
  </head>
  <body>
  <h1>Справочник контролеров</h1>
  <p><a href="..">На главную</a></p>
  <p><a href="?add">Добавить нового контролера</a></p>
    <table>
      <?php if (!empty($controllers)): ?>
          <?php foreach ($controllers as $controller): ?>
            <tr>
              <form action="" method="post">
                <td>
                  <?= htmlentities($controller['name']); ?>
                </td>
	            <td>
                  <input type="hidden" name="id" value="<?= $controller['id']; ?>">
                  <input type="submit" name="action" value="Редактировать">
                  <input type="submit" name="action" value="Удалить">
                </td>
              </form>
            </tr>
          <?php endforeach; ?>
      <?php endif; ?>
    </table>
  </body>
</html>
