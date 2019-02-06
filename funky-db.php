<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-23
# Page: funky-db.php 
##########################################################

class DB_Sql {

  /* public: connection parameters */
  private $host = DATABASE_HOST;
  private $user = DATABASE_USER;
  private $pass = DATABASE_PASSWORD;
  private $dbname = DATABASE_NAME;

  private $dbh;
  private $error;
  private $stmt;

 #
 ################################
 #

  public function __construct(){

  	# Set DSN
	$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      
	# Set options
	$options = array(
	    PDO::ATTR_PERSISTENT => true, 
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);

	# Create a new PDO instanace
	try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
 
  } # end public construct

 #
 ################################
 #

 public function query($query){

    $this->stmt = $this->dbh->prepare($query);

 } # end query function

 #
 ################################
 #

 public function bind($param, $value, $type = null){

	if (is_null($type)) {

	  switch (true) {
	    case is_int($value):
	      $type = PDO::PARAM_INT;
	      break;
	    case is_bool($value):
	      $type = PDO::PARAM_BOOL;
	      break;
	    case is_null($value):
	      $type = PDO::PARAM_NULL;	
	      break;
	    default:
	      $type = PDO::PARAM_STR;
	  }

	} 

  $this->stmt->bindValue($param, $value, $type);
 
 } # end bind function

 #
 ################################
 #

 public function execute(){

    return $this->stmt->execute();

 } # end execute function

 #
 ################################
 #

 public function resultset(){

    $this->execute();

    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

 } # end resultset functions

 #
 ################################
 #

 public function single(){

    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);

 } # end single function

 #
 ################################
 #

 public function rowCount(){

    return $this->stmt->rowCount();

 } # end rowcount function

 #
 ################################
 #

 public function lastInsertId(){

    return $this->dbh->lastInsertId();

 } # end lastinsert function

 #
 ################################
 #

 public function beginTransaction(){

    return $this->dbh->beginTransaction();

 } # end beginTransaction function

 #
 ################################
 #

 public function endTransaction(){

    return $this->dbh->commit();

 } # end endTransaction function

 #
 ################################
 #

 public function cancelTransaction(){

    return $this->dbh->rollBack();

 } # end cancelTransaction function

 #
 ################################
 #

 public function debugDumpParams(){

    return $this->stmt->debugDumpParams();

 } # end debugDumpParams function

} # end class

##########################################################
?>