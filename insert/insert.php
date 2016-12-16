<?php

	include_once ( '../database/mongodb.php' );
	include_once ( '../database/mysql.php' );

	/**
	* 
	*/
	class ClassInsert 
	{
		protected $file;
		protected $database;
		
		function __construct( $database )
		{ 
			$this->file = getcwd() . "/client.csv";

			if ( $database == 'mysql' ) :
				$this->database = new MysqlPDO();
			else :
				$this->database = new ClassMongodB();
			endif;

			
			$this->read_file();
		}


		function read_file()
		{

			ini_set('max_execution_time', 3000);

			$handle = fopen( $this->file , 'r');

			$total_duration = 0;

			$item = 0;

			$inital_time = date( "d/m/Y H:i:s" );

			while ( ( $data = fgetcsv( $handle, 0, "," ) ) !== FALSE ) :

				$item = $item + 1;

				if ( $data[0] == "id" )
					continue;

				$data_insert = $this->correct_array( $data );

				$starttime = microtime(true);

				$this->database->INSERT( 'client', $data_insert, $item );

				$endtime = microtime(true);
				$duration = $endtime - $starttime;

				$total_duration = $total_duration + $duration;

				if ( $item == 200000 )
					break;

			endwhile;	

			$final_time = date( "d/m/Y H:i:s" );

			$results_inserts = [ "date_time" => date( "Y-m-d H:i:s" ) , "total_itens" => $item, "total_duration" => $total_duration, "database" => $this->database ];

			echo "TOTAL ITENS " . $item . "<br>";
			echo "HORARIO INICIAL " . $inital_time . "<br>";
			echo "HORARIO FINAL " . $final_time . "<br>";
			echo "FIM " . $total_duration;
		}

		function correct_array( $array )
		{
			$return[ 'idclient' ] = ( isset( $array[ 0 ] ) ) ? $array[ 0 ] : '';
			$return[ 'name' ]     = ( isset( $array[ 1 ] ) ) ? utf8_encode( iconv('UTF-8', 'ISO-8859-1//IGNORE', $array[ 1 ] ) ) : '';
			$return[ 'address' ]  = ( isset( $array[ 2 ] ) ) ? utf8_encode( iconv('UTF-8', 'ISO-8859-1//IGNORE', $array[ 2 ] ) ) : '';
			$return[ 'city' ]     = ( isset( $array[ 3 ] ) ) ? utf8_encode( iconv('UTF-8', 'ISO-8859-1//IGNORE', $array[ 3 ] ) ) : '';
			$return[ 'number' ]   = ( isset( $array[ 4 ] ) ) ? $array[ 4 ] : '';
			$return[ 'salesman' ] = ( isset( $array[ 5 ] ) ) ?  $array[ 5 ] : '';

			return $return;
		}
	}
?>