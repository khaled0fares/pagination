<?php

require 'Paginator.php';
class Article {}
$db = require 'connection.php';

$pagination = new Paginator(
	$db,
	10
);


/*if( ! isset( $_GET['page'] ) ||  ! isset( $_GET['pages'] ) ) {
	header("Location: paginate.view.php?pages=1&recordsPerPage=10");
}*/
$pagination->table = "articles";
$pagination->model = "Article";
$pagination->setRecordsPerPage( $_GET['recordsPerPage'] ); 
$pagination->setPages( $_GET['pages'] );
$pagination->setOffset();
$pagination->setQuery( 
	"SELECT * FROM $pagination->table LIMIT $pagination->offset,$pagination->recordsPerPage"
);

$pagination->paginate();
//$n =  ceil($pagination->numberOfRecords()  / $pagination->recordsPerPage); 
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
