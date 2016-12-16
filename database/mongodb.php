<?php 


	/**
	* 
	*/
	class ClassMongodB
	{

		public $mongo;
 		
		function __construct()
		{
			try{

				$this->mongo = new \MongoDB\Driver\Manager( 'mongodb://localhost:27017/compare' );

			}catch( Exeption $e ) {
				print "Error!: " . $e->getMessage() . "<br/>";
			}
			
		}

		function INSERT( $collection, $data )
		{
			$bulk = new MongoDB\Driver\BulkWrite;

			$data[ '_id' ] =  new MongoDB\BSON\ObjectID;
			$bulk->insert( $data );

			try{

				$result = $this->mongo->executeBulkWrite( 'compare.' . $collection, $bulk );

			}catch (MongoDB\Driver\Exception\BulkWriteException $e) {
			    $result = $e->getWriteResult();

			    if ($writeConcernError = $result->getWriteConcernError()) :
			        printf("%s (%d): %s\n",
			            $writeConcernError->getMessage(),
			            $writeConcernError->getCode(),
			            var_export($writeConcernError->getInfo(), true)
			        );
			    endif;
			}

			return $result;
		}

		function QUERY( $collection, $filter = null, $options = null )
		{
			$data_filter = [];
			$data_options = [];

			if( isset( $filter[ 's' ] ) )
				$data_filter[ 'salesman' ] = $filter[ 's' ];

			if( isset( $filter[ 'l' ] ) )
				$data_options[ 'limit' ] = intval( $filter[ 'l' ] );


			$query = new MongoDB\Driver\Query( $data_filter, $data_options );

			$cursor = $this->mongo->executeQuery( 'compare.' . $collection, $query );

			return $cursor;

		}

		function DROP( $collection )
		{
			$bulk = new MongoDB\Driver\BulkWrite;
			$bulk->delete([]);

			try{

				$result = $this->mongo->executeBulkWrite( 'compare.' . $collection, $bulk );

				return $result->getDeletedCount();

			}catch (MongoDB\Driver\Exception\BulkWriteException $e) {
			    $result = $e->getWriteResult();

			    if ($writeConcernError = $result->getWriteConcernError()) :
			        printf("%s (%d): %s\n",
			            $writeConcernError->getMessage(),
			            $writeConcernError->getCode(),
			            var_export($writeConcernError->getInfo(), true)
			        );
			    endif;
			}

		}

	}



?>