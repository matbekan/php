<?php 
    
    class Baza{
        
        const server = "localhost";
        const baza = "iwa_2014_vz_projekt";
        const korisnik = "iwa_2014";
        const lozinka = "foi2014";
        
        private function connectDB(){
            $connection = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
            $connection->set_charset("utf8");
            
            return $connection;
        }
        
        private function closeDB($connection){
            mysqli_close($connection);
        }
        
        function selectDB($query){
            $connection = self::connectDB();
            $result = $connection->query($query);
            
            if (!$result){
                $result = null;
            }
            
            self::closeDB($connection);
            return $result;
        }
        
        function updateDB($query){
            $connection = self::connectDB();
            $result = $connection->query($query);
            
            self::closeDB($connection);
            return $result;
        }
        
    }

?>