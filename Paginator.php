<?php
class Paginator {
	public  $connection;
	public $recordsPerPage;
	public $pages;
	public $records;
	public $offset;
	public $mapper;

	protected $query;
	protected $defaultPerPage;

	public function __construct( $connection, $defaultPerPage  = 5 )
	{
		$this->positiveInt();
		$this->defaultPerPage = $defaultPerPage;
		$this->connection = $connection;
	}

	function numberOfRecords(){
		$selectAllRecords  = $this->connection->prepare( "SELECT COUNT(*) FROM articles" );
		$selectAllRecords->execute();
		return (int) $selectAllRecords->fetchAll()[0][0];
	}


	function positiveInt()
	{
		$this->recordsPerPage   = (int) $this->recordsPerPage   >  0 ? (int) $this->recordsPerPage : 1;
		$this->pages  =  (int) $this->pages   >  0 ? (int) $this->pages : 1;
	}

	function setRecordsPerPage($recordsPerPage)
	{
		$this->recordsPerPage	 =
			(int) $recordsPerPage > $this->numberOfRecords() || (int) $recordsPerPage <=  0 			
			?
			$this->defaultPerPage :	(int)$recordsPerPage;
	}

	function setPages($pages)
	{
		$lastPagePossible =  ceil($this->numberOfRecords() / $this->recordsPerPage);
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
	
	function setOffset(){
		$this->offset =  ($this->pages - 1) * $this->recordsPerPage;
	}
	function query()
	{
		$this->setOffset();
		$selectAllRecords  =
			$this->connection->prepare($this->query);

		$selectAllRecords->execute();
		return  $selectAllRecords->fetchAll( PDO::FETCH_CLASS, $this->mapper );

	}

	function paginate()
	{
		$this->records  = $this->query();
	}
}

