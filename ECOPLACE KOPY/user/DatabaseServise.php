
      
      <?php
     class DatabaseService{
        private $connection = NULL;
        
        public function __construct(){
            $this->connection = new mysqli('localhost','root',NULL,'registrashion'); 
            if (!$this->connection){
                throw new Exception('Connection to db failed');
            }            
        }

        public function __destruct(){
            $this->connection->close();
        }
      
      public function getUserPhoto($login){
            $queryString = "SELECT `photo` FROM `places` WHERE `1` = '{$login}'";
            $queryExecutionResult = $this->connection->query($queryString);
            $executionStatus = boolval($queryExecutionResult);
            return ['status' => $executionStatus, 'data' => $executionStatus ? mysqli_fetch_assoc($queryExecutionResult) : mysqli_error($this->connection)];




        }
        public function getUserProfile($login){
            $queryString = "SELECT `login` FROM `users` WHERE `1` = '{$login}'";
            $queryExecutionResult = $this->connection->query($queryString);
            $executionStatus = boolval($queryExecutionResult);
            return ['status' => $executionStatus, 'data' => $executionStatus ? mysqli_fetch_assoc($queryExecutionResult) : mysqli_error($this->connection)];
        }
    