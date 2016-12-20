<?php

require 'Paginator.php';
require 'Article.php';

$connection = require 'connection.php';

$pagination = new Paginator(
	$connection,
	10
);

$pagination->table = "articles";
$pagination->setRecordsPerPage($_GET['recordsPerPage']);
$pagination->setPages($_GET['pages']);
$pagination->setOffset();
$pagination->setQuery( 
	"SELECT * FROM $pagination->table LIMIT $pagination->offset,$pagination->recordsPerPage"
);
$pagination->mapper = "Article";
var_dump( $pagination );
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
