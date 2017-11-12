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
        <label for="typeid">Тип прибора: </label>
        <select name="typeid" id="typeid">
            <option value="">Выберите тип</option>
            <?php foreach ($types as $type): ?>
            <option value="<?= htmlentities($type['id']); ?>"<?php
                  if ($type['id'] == $typeid)
                  {
                    echo ' selected';
                  }
                  ?>><?= htmlentities($type['name']); ?></option>
            <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="name">Название прибора:
	        <input type="text" name="name" id="name" value="<?= htmlentities($name); ?>">
        </label>
      </div>
      <div>
        <label for="intervalm">Межповерочный интервал:
	        <input type="text" name="intervalm" id="intervalm" value="<?= htmlentities($intervalm); ?>">
        </label>
      </div>
	    <div>
		    <label for="minm">Нижняя граница измерения:
			    <input type="text" name="minm" id="minm" value="<?= htmlentities($minm); ?>">
		    </label>
	    </div>
	    <div>
		    <label for="maxm">Верхняя граница измерения:
			    <input type="text" name="maxm" id="maxm" value="<?= htmlentities($maxm); ?>">
		    </label>
	    </div>
	    <div>
		    <label for="unitid">Единица измерения: </label>
		    <select name="unitid" id="unitid">
			    <option value="">Выберите единицу измерения</option>
			    <?php foreach ($units as $unit): ?>
				    <option value="<?= htmlentities($unit['id']); ?>"<?php
				    if ($unit['id'] == $unitid)
				    {
					    echo ' selected';
				    }
				    ?>><?= htmlentities($unit['name']); ?></option>
			    <?php endforeach; ?>
		    </select>
	    </div>
	    <div>
		    <label for="manufacturerid">Производитель: </label>
		    <select name="manufacturerid" id="manufacturerid">
			    <option value="">Выберите производителя</option>
			    <?php foreach ($manufacturers as $manufacturer): ?>
				    <option value="<?= htmlentities($manufacturer['id']); ?>"<?php
				    if ($manufacturer['id'] == $manufacturerid)
				    {
					    echo ' selected';
				    }
				    ?>><?= htmlentities($manufacturer['name']); ?></option>
			    <?php endforeach; ?>
		    </select>
	    </div>
	    <div>
		    <input type="hidden" name="id" value="<?= htmlentities($id); ?>">
		    <input type="submit" value="<?= htmlentities($button); ?>">
	    </div>
    </form>
    <p><a href="../manufacturer/">Добавить производителя</a></p>
  </body>
</html>
