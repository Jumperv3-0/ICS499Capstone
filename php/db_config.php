<?php
	/**
	 * These are the database login details
	 */
	define("HOST", "localhost");     // The host you want to connect to.
	define("USER", "root");    // The database username.
	define("PASSWORD", "");    // The database password.
	define("DATABASE", "ics499");    // The database name.

	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");

	define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!


	/**
	 * singleton to connect db.
	 */
	class SqlManager{
		private static $instance = null; // Hold the class instance.
		private $conn;

		/**
		 * The db connection is established in the private constructor.
		 */
		private function __construct() {
			try {
				$this->conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
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
		$instance = DB_CONN::getInstance();
		$conn = $instance->getConnection();
		var_dump($conn);
	*/








	/**
	 * Creates and gets connection to db
	 */
	class DB_CONN_mine {
		private $conn = null;
		private static $instance = null;

		/**
		 * Private constructor that creates connection to db
		 */
		protected function __construct() {
			try {
				$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
				// set the PDO error mode to exception
				//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo "Connected successfully";
			}
			catch(PDOException $e)
			{
					echo "Connection failed: " . $e->getMessage();
 			}
		}

		private function __clone(){} // prevents cloning

		private function __wakeup(){} // prevents unserializing

		/**
		 * Static method that gets the connection to the db
		 * @return PDO connection to db
		 */
		public static function getInstance() {
			if (!self::$instance) {
				self::$instance = new DB_CONN();
			}
			return self::$instance;
		}

		public function getConnection()
		{
    	return $this->conn;
  	}

	}
?>
