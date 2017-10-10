<?php
	require_once 'db_config.php';
	/**
	 * singleton to connect db.
	 */
	class SqlManager {
		private static $instance = null; // Hold the class instance.
		private $conn; // The connection to db

		/**
		 * The db connection is established in the private constructor.
		 */
		private function __construct() {
			try {
				$this->conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD); // creating db connection
			} catch(PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
			}
		}

		/**
		 * Gets the instance of the SqlManager
		 * @return SqlManager gets the single instance
		 */
		public static function getInstance() {
			if(!self::$instance)
			{
				self::$instance = new SqlManager();
			}

			return self::$instance;
		}

		/**
		 * Gets the connection to the db
		 * @return PDO connection to the db
		 */
		public function getConnection() {
			return $this->conn;
		}
	}

	/*
		---connect to db example---
		$instance = DB_CONN::getInstance(); // gets instance of class
		$conn = $instance->getConnection();	// gets connection from instance
	*/
?>
