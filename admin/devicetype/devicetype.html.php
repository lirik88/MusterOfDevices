<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Справочник приборов</title>
  </head>
  <body>
    <h1>Справочник приборов</h1>
    <p><a href="..">На главную</a></p>
    <p><a href="?add" accesskey="n">Добавить новый прибор</a></p>

    <?php if (!empty($types)): ?>
        <?php foreach ($types as $type): ?>
	        <p><?= $type['name'] ?></p>
		    <table>
		      <?php if (!empty($devicetypes)): ?>
		          <?php foreach ($devicetypes as $devicetype): ?>
			        <?php if ($devicetype['typeid'] === $type['id']): ?>
			            <tr>
			              <form action="" method="post">
			                <td>
			                  <span><?= htmlentities($devicetype['name']); ?>
				                  <?php if($devicetype['maxm'] !== '0') : ?>
					                  (<?= htmlentities($devicetype['minm']); ?> -
					                  <?= htmlentities($devicetype['maxm']); ?>)
				                  <?php endif; ?>
			                  </span>
			                </td>
				            <td>
			                  <input type="hidden" name="id" value="<?= $devicetype['id']; ?>">
			                  <input type="submit" name="action" value="Редактировать">
			                  <input type="submit" name="action" value="Удалить">
			                </td>
			              </form>
			            </tr>
				    <?php endif; ?>
		          <?php endforeach; ?>
		      <?php endif; ?>
		    </table>
	    <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
