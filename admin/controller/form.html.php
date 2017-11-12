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
        <label for="name">Фамилия: <input type="text" name="name"
            id="name" value="<?= htmlentities($name); ?>"></label>
      </div>
      <div>
        <label for="email">Email: <input type="text" name="email"
            id="email" value="<?= htmlentities($email); ?>"></label>
      </div>
      <div>
        <input type="hidden" name="id" value="<?= htmlentities($id); ?>">
        <input type="submit" value="<?= htmlentities($button); ?>">
      </div>
    </form>
  </body>
</html>
