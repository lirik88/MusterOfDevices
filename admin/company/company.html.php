<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник предприятий</title>
  </head>
  <body>
    <h1>Справочник предприятий</h1>
    <p><a href="..">На главную</a></p>
    <p><a href="?add">Добавить новое предприятие</a></p>
    <table>
      <?php if (!empty($companies)): ?>
          <?php foreach ($companies as $company): ?>
            <tr>
              <form action="" method="post">
                <td>
                  <?= htmlentities($company['name']); ?>
                </td>
	            <td>
                  <input type="hidden" name="id" value="<?= $company['id']; ?>">
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
