<?php
require 'Article.php';
$connection =  require 'connection.php';

function query($connection, $offset, $articlesPerPage)
{

	$selectAllArticles  = $connection->prepare("SELECT * FROM articles LIMIT $offset, $articlesPerPage");
	$selectAllArticles->execute();
  return  $selectAllArticles->fetchAll( PDO::FETCH_CLASS, 'Article' );

}


function numberOfRecords($connection){
	$selectAllArticles  = $connection->prepare("SELECT COUNT(*) FROM articles");
	$selectAllArticles->execute();
	return (int) $selectAllArticles->fetchAll()[0][0];
}

function positiveInt($string)
{
	return  (int) $string   >  0 ? (int) $string : 1;
}

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

function limitPages($connection, $pages, $articlesPerPage)
{
	$lastPagePossible =  ceil(numberOfRecords($connection) / $articlesPerPage);
	return $lastPagePossible < $pages  ? $lastPagePossible : $pages;
}

function limitArticles($connection, $articlesPerPage, $maxPerPage)
{
	return 	$articlesPerPage > numberOfRecords($connection) ? $maxPerPage : $articlesPerPage;
}


return  paginate(
	$connection,
	$_GET['pages'],
	$_GET['articlesPerPage']
);
