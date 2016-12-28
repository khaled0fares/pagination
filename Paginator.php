<?php

class Paginator {
	public $recordsPerPage;
	public $pages;
	public $records;
	public $offset;
	public $table;
	public $model;
	public $numberOfAllRecords;

	protected $query;
	protected $defaultPerPage;
	protected  $connection;

	public function __construct( $connection, $defaultPerPage  = 5 )
	{
		$this->positiveInt();
		$this->defaultPerPage = $defaultPerPage;
		$this->connection = $connection;
	}

	public function numberOfRecords($query)
	{
		$selectAllRecords  = $this->connection->prepare( $query );
		$selectAllRecords->execute();
		$this->numberOfAllRecords = (int) $selectAllRecords->fetchAll()[0][0];
	}


	function positiveInt()
	{
		$this->recordsPerPage   = (int) $this->recordsPerPage >  0 ? (int) $this->recordsPerPage : 1;
		$this->pages  =  (int) $this->pages   >  0 ? (int) $this->pages : 1;
	}

	function setRecordsPerPage($recordsPerPage)
	{
		$this->recordsPerPage	 =
			(int) $recordsPerPage > $this->numberOfAllRecords || (int) $recordsPerPage <=  0 			
			?
			$this->defaultPerPage :	(int)$recordsPerPage;
	}

	function setPages($pages)
	{
		$lastPagePossible =  ceil($this->numberOfAllRecords / $this->recordsPerPage);
		$pages =  (int) $pages;
		if( $pages <= 0 ){
			$this->pages = 1;
			return;
		} 

		if ( $pages > $lastPagePossible ) {
			$this->pages =  $lastPagePossible; 
			return;
		} 

		$this->pages =  $pages;
	}

	function setQuery( $query )
	{
		$this->query  = $query;	
	}

	function setOffset($offset = null)
	{
		$this->offset = isset($offset) ? $offset :   ($this->pages - 1) * $this->recordsPerPage;
	}

	function numberOfPages(){

		return ceil($this->numberOfAllRecords  / $this->recordsPerPage); 
	}

	function query()
	{
		$this->setOffset();
		$selectAllRecords  =
			$this->connection->prepare($this->query);

		$selectAllRecords->execute();
		return  $selectAllRecords->fetchAll( PDO::FETCH_CLASS, $this->model );

	}

	function paginate()
	{
		$this->records  = $this->query();
	}
}

