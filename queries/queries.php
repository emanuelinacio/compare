<?php

	include_once ( '../database/mongodb.php' );
	include_once ( '../database/mysql.php' );
	/**
	* 
	*/
	class ClassQueries
	{
		
		protected $query;
		protected $database;
		
		function __construct( $database )
		{ 

			$this->query = 'client';

			if ( $database == 'mysql' ) :
				$this->database = new MysqlPDO();
			else :
				$this->database = new ClassMongodB();
			endif;

			$this->do_query();
		}

		function do_query()
		{
			$results = $this->database->QUERY( $this->query, $_REQUEST );

			$return_array = [];

			$itens = 0;

			foreach ( $results as $document ) :
				$itens = $itens + 1;
			    $return_array[] = $document;
			endforeach;

			$this->print_json( $return_array );

		}

		function print_json( $array_result )
		{

			echo json_encode( $array_result );
			exit;

		}

	}
?>