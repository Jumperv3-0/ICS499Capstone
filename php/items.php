<?php
    require_once 'init.php';
    require_once 'Objects.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php PageBuilder::getTitle() ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>

<body>
	<header>
		<?php
            $pageBuilder = new ItemsPage();
            $pageBuilder->getHeader();
        ?>
	</header>


<div class="container">
<form>
  <div class="form-group">
    <label for="search">search items</label>
	<select>
  <option value="clothes">Clothes</option>
  <option value="cars">Cars</option>
  <option value="furnture">Furnture</option>
  <option value="toys">Toys</option>
</select>
    <input type="text" class="form-control" id="search">
	<button type="button" class="btn btn-default">Search</button>
  </div>
  </form>

<ul class="list-group">
  <li class="list-group-item">First item</li>
  <li class="list-group-item">Second item</li>
  <li class="list-group-item">Third item</li> </ul>
</div>



	<footer>
		<?php
			PageBuilder::getFooter();
		?>
	</footer>
	</body>
</html>
