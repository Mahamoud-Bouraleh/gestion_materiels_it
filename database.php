<?php  

    class database {

    private static $dbhost = "localhost";
    private static $dbName = "materiels_it";
    private static $dbuser = "root";
    private static $dbuserpassword = "";

    private static $connection = null ;


    public static function connect ()
     {

        try{

          self::  $connection = new pdo("mysql:host=" .self::$dbhost .";dbname=" .self::$dbName,self::$dbuser,self::$dbuserpassword ) ;
    
        }
    
        catch(PDOException $e)
        {
            die($e-> getMessage());
        }

         return self::$connection ;

     }

     public static function disconnect()
     {
        self::$connection = null ;
     }
    

}

    
    

?>