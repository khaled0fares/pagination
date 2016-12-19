<?php

require 'Paginator.php';
require 'Article.php';

$connection = require 'connection.php';

$pagination = new Paginator($connection, 10);
$pagination->setArticlesPerPage($_GET['articlesPerPage']);
$pagination->setPages($_GET['pages']);
$pagination->paginate();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php foreach ($pagination->articles as $article):  ?>
	<h3><?= $article->title; ?></h3>
<?php endforeach ?>
</body>
</html>
