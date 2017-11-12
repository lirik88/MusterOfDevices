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
        <label for="companyid">Предприятие: </label>
        <select name="companyid" id="companyid">
            <option value="">Выберите предприятие</option>
            <?php foreach ($companies as $company): ?>
            <option value="<?= htmlentities($company['id']); ?>"<?php
                  if ($company['id'] == $companyid)
                  {
                    echo ' selected';
                  }
                  ?>><?= htmlentities($company['name']); ?></option>
            <?php endforeach; ?>
        </select>
      </div>
	    <div>
		    <label for="devicetypeid">Название прибора: </label>
		    <select name="devicetypeid" id="devicetypeid">
			    <option value="">Выберите название прибора</option>
			    <?php foreach ($devicetypes as $devicetype): ?>
				    <option value="<?= htmlentities($devicetype['id']); ?>"<?php
				    if ($devicetype['id'] == $devicetypeid)
				    {
					    echo ' selected';
				    }
				    ?>>
					    <?= htmlentities($devicetype['name']); ?>
					    <?php if($devicetype['typeid'] !== '2') : ?>
						    (<?= htmlentities($devicetype['minm']); ?>-
						    <?= htmlentities($devicetype['maxm']); ?>)
					    <?php endif; ?>
				    </option>
			    <?php endforeach; ?>
		    </select>
	    </div>
	    <div>
	      <label for="number">Номер прибора:
	        <input type="text" name="number" id="number" value="<?= htmlentities($number); ?>">
        </label>
      </div>
	    <div>
	      <label for="lastdate">Дата последней поверки:
	        <input type="date" name="lastdate" id="lastdate" value="<?= htmlentities($lastdate); ?>">
        </label>
      </div>
	    <div>
		    <label for="note">Примечание:
			    <textarea rows="1" cols="40" name="note" id="note"><?= htmlentities($note); ?></textarea>
		    </label>
	    </div>
	    <div>
		    <input type="hidden" name="id" value="<?= htmlentities($id); ?>">
		    <input type="submit" value="<?= htmlentities($button); ?>">
	    </div>
    </form>
    <p><a href="..">На главную</a></p>
  </body>
</html>
