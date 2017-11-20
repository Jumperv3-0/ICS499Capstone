<?php
  require_once 'db_config.php';
  /**
  * singleton to connect db.
  */
  class SqlManager {
    private static $instance = null; // Hold the class instance.
    private $conn, $query, $error, $result, $numItemsReturned;

    /**
    * The db connection is established in the private constructor.
    */
    private function __construct() {
      try {
        $this->conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD); // creating db connection
        $this->error = false;
        $this->numItemsReturned = 0;
      } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
    }

    /**
    * Gets the instance of the SqlManager
    * @return SqlManager gets the single instance
    */
    public static function getInstance() {
      if(!isset(self::$instance)) {
        self::$instance = new SqlManager();
      }
      return self::$instance;
    }

    /**
    *
    */
    public function query($sql, $params = array()) {
      $this->error = false;
      if ($this->query = $this->conn->prepare($sql)) {
        $index = 1;
        if (count($params) > 0) {
          foreach($params as $param) {
            $this->query->bindValue($index, $param);
            $index++;
          }
        }
        if ($this->query->execute()) {
          $this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
          $this->numItemsReturned = $this->query->rowCount();
        } else {
          // NOTE: for debugging
          // print_r($this->query->errorInfo());
          $this->error = true;
        }
      }
      return $this;
    }

    /**
    * Gets the result from the last query executed
    * @return array Objects from database
    */
    public function getResult() {
      return $this->result;
    }

    /**
    * Gets true if there was an error while executing query
    * otherwise returns false.
    * @return boolean true if there was an error, else false
    */
    public function getError() {
      return $this->error;
    }

    /**
    * Gets the number of rows from executing a query
    * @return integer number of rows returned by query
    */
    public function getCount() {
      return $this->numItemsReturned;
    }
  }

  /*
  ---connect to db example---
  $db = SqlManager::getInstance(); // gets instance of class
  $db->query("SELECT * FROM users WHERE user_id > ? AND fname != ?", array('0','gary'));	// execute sql query with ? replaced with strings in array
  $db->getCount(); // get the number of rows returned
  $db->getResult(); // get array of result
  $db->getError(); // returns true if quary did not run else false
  /**/
?>
