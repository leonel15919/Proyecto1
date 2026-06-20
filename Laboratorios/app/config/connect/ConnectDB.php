<?php
    namespace App\Laboratorios\Config\Connect;

    use PDO;
    use PDOException; 

    abstract class ConnectDB {

        
        private $conex;

        public function __construct() {
            
            $this->getConnection();
        }

        
        protected function getConnection(): PDO {

            
            try {

                
                $this->conex = new PDO("mysql:host=localhost;dbname=laboratoriosdb", "root", "");
                
                
                $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            } catch (PDOException $e) {

                
                die('ERROR DE CONEXIÓN: No se ha podido conectar con la base de datos. ' . $e->getMessage());
            }

            
            return $this->conex;
        }
    }
?>