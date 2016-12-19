<?php
require 'Article.php';
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

function limitArticles($connection, $articlesPerPage, $maxPerPage)
{
	return 	$articlesPerPage > numberOfRecords($connection) ? $maxPerPage : $articlesPerPage;
}

function limitPages($connection, $pages, $articlesPerPage)
{
	$lastPagePossible =  ceil(numberOfRecords($connection) / $articlesPerPage);
	return $lastPagePossible < $pages  ? $lastPagePossible : $pages;
}

