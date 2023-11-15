<?php
include_once("../../admin/includes/db.php");

class MySQLDB{
   private $connection;          // The mysql database connection   
   /* Class constructor */
   function __construct(){       
      //$this->connection = conecta();
      /* Make connection to database */
      /*$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());*/
   }

   /* Transactions functions */

   function begin(){
      $this->connection = conecta();
      $null = mysqli_query( $this->connection, "START TRANSACTION");
      return mysqli_query( $this->connection, "BEGIN");
   }

   function commit(){
      return mysqli_query( $this->connection, "COMMIT");
   }

   function rollback(){
      return mysqli_query( $this->connection, "ROLLBACK");
   }

   function transaction($q_array,$minimoLinhas=1){//minimo de linhas para ter certeza que a gravação foi feita
      $r=false;
      $retval = 1;
      $this->begin();
      foreach($q_array as $qa){
         if (!empty($qa['query'])) {
            $result = mysqli_query( $this->connection, $qa['query']);
            if(mysqli_affected_rows($GLOBALS["___mysqli_ston"]) == 0){ $retval = 0; }
         }
      }
      
      if($retval == 0){         
         $this->rollback();   
      }else{
         $this->commit();         
         $r=true;
         if($retval<$minimoLinhas){
            $r=false;
         }
      }
      @((is_null($___mysqli_res = mysqli_close($this->connection))) ? false : $___mysqli_res);
      return $r;
   }
}
?>
