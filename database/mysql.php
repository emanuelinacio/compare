<?php 

	class MysqlPDO
	{

		const HOST_LOCAL = "localhost";
		const USER_LOCAL = "root";
		const PASS_LOCAL = "";
		const DB_LOCAL   = "compare";

		public $pdo;
 		
		function __construct()
		{
			try{

				$this->pdo = new PDO( 'mysql:host=' . self::HOST_LOCAL . ';dbname=' . self::DB_LOCAL .';charset=utf8', self::USER_LOCAL, self::PASS_LOCAL, array( PDO::ATTR_PERSISTENT => true ) );

			}catch( Exeption $e ) {
				echo "Error!: " . $e->getMessage() . "<br/>";
			}
			
		}

		public function INSERT( $table, $itemtoinsert, $item )
		{

		    $sql = "INSERT INTO $table ( idclient ,name ,address ,city ,number ,salesman ) 
		    	VALUES ( :idclient ,:name ,:address ,:city ,:number ,:salesman )";

		    $pdo_exec = $this->pdo->prepare( $sql ); 
		    $pdo_exec->bindParam(':idclient', $itemtoinsert[ 'idclient' ] );
		    $pdo_exec->bindParam(':name', $itemtoinsert[ 'name' ] );
		    $pdo_exec->bindParam(':address', $itemtoinsert[ 'address' ] );
		    $pdo_exec->bindParam(':city', $itemtoinsert[ 'city' ] );
		    $pdo_exec->bindParam(':number', $itemtoinsert[ 'number' ] );
		    $pdo_exec->bindParam(':salesman', $itemtoinsert[ 'salesman' ] );

		    $return = $pdo_exec->execute();

		    	if ( ! $return ) :
					print_r($pdo_exec->errorInfo());
					var_dump( $itemtoinsert );
					var_dump( $item );
					exit;
		    		return false;
		    	endif;

	        return true;   
		}

		public function QUERY( $table, $filter = null, $options = null )
		{

			$sql = "SELECT * FROM " . $table;

			if ( isset( $filter[ 's' ] ) ) :
				$sql = "SELECT * FROM " . $table . " WHERE salesman = :salesman";
			endif;

			if ( isset( $filter[ 'l' ] ) ) :
				$sql = "SELECT * FROM " . $table . " LIMIT " . $filter[ 'l' ];
			endif;

			if ( ( isset( $filter[ 's' ] ) ) && ( isset( $filter[ 'l' ] ) ) ) :
				$sql = "SELECT * FROM " . $table . " WHERE salesman = :salesman LIMIT " . $filter[ 'l' ];
			endif;


		    $pdo_exec = $this->pdo->prepare( $sql );

		    if ( isset( $filter[ 's' ] ) )
		    	$pdo_exec->bindParam(':salesman', $filter[ 's' ], PDO::PARAM_INT);

	    	$result = $pdo_exec->execute();


		    if ( ! $result )
		    	return false;

		    return $pdo_exec->fetchAll();
		}

		public function DROP( $table )
		{
			$sql = "DELETE FROM " . $table;

		    $pdo_exec = $this->pdo->prepare( $sql );    

		    $result = $pdo_exec->execute();

		    return $result;
		}

	}


?>