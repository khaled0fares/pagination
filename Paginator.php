<?php
class Paginator {
	public  $connection;
	public $articlesPerPage;
	public $pages;
	public $articles;

	protected $offset;
	protected $maxPerPage;

	public function __construct( $connection, $maxPerPage  = 5)
	{
		$this->positiveInt();
		$this->maxPerPage = $maxPerPage;
		$this->connection = $connection;
	}

	function query()
	{
		$this->offset =  ($this->pages - 1) * $this->articlesPerPage;
		$selectAllArticles  =
			$this->connection->prepare("SELECT * FROM articles LIMIT $this->offset,
				$this->articlesPerPage");

		$selectAllArticles->execute();
		return  $selectAllArticles->fetchAll( PDO::FETCH_CLASS, 'Article' );

	}
	function numberOfRecords(){
		$selectAllArticles  = $this->connection->prepare("SELECT COUNT(*) FROM articles");
		$selectAllArticles->execute();
		return (int) $selectAllArticles->fetchAll()[0][0];
	}

	function positiveInt()
	{
		$this->articlesPerPage   = (int) $this->articlesPerPage   >  0 ? (int) $this->articlesPerPage : 1;
		$this->pages  =  (int) $this->pages   >  0 ? (int) $this->pages : 1;
	}

	function setArticlesPerPage($articlesPerPage)
	{
		$this->articlesPerPage	 = $articlesPerPage > $this->numberOfRecords() ?
			$this->maxPerPage :	$articlesPerPage;
	}

	function setPages($pages)
	{
		$lastPagePossible =  ceil($this->numberOfRecords() / $this->articlesPerPage);
		$this->pages =  $lastPagePossible < (int) $pages  ? $lastPagePossible : (int)$pages;
	}
	function paginate()
	{
		$this->articles  = $this->query();
	}
}

