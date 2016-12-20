<?php

require 'Paginator.php';
require 'Article.php';

$connection = require 'connection.php';

$pagination = new Paginator(
	$connection,
	10
);

$pagination->setRecordsPerPage($_GET['articlesPerPage']);
$pagination->setPages($_GET['pages']);
$pagination->mapper = "Article";
$pagination->setOffset();
$pagination->setQuery( "SELECT * FROM articles LIMIT $pagination->offset,$pagination->recordsPerPage" );
$pagination->paginate();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php foreach ($pagination->records as $record):  ?>
	<h3><?= $record->title; ?></h3>
<?php endforeach ?>
</body>
</html>
