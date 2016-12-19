<?php
require 'helper.php';
$connection =  require 'connection.php';

function paginate($connection, $pages, $articlesPerPage, $maxPerPage  = 5)
{
	$articlesPerPage =  limitArticles($connection, positiveInt($articlesPerPage), $maxPerPage);
	$pages =  limitPages($connection, positiveInt($pages), $articlesPerPage);
	$offset =  ($pages - 1) * $articlesPerPage;
	$articles  = query($connection, $offset, $articlesPerPage);

	return [
		"articlesPerPage"=> $articlesPerPage,
		"pages"=> $pages,
		"articles"=> $articles
	];
}

return  paginate(
	$connection,
	$_GET['pages'],
	$_GET['articlesPerPage']
);
