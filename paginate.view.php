<?php

$pagination = require 'paginate.php';
$articles  =  $pagination['articles'];
$pages =  $pagination['pages'];
$max=  $pagination['articlesPerPage'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php foreach ($articles as $article):  ?>
	<h3><?= $article->title; ?></h3>
<?php endforeach ?>
</body>
</html>
