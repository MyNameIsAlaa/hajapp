<?php

class Database
{

    // specify your own database credentials
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    public  $conn;

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }


    /**
     * create the Messages table
     * @return boolean returns true on success or false on failure
     */
    public function createTables()
    {
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS mofa_messages (
                id          INT AUTO_INCREMENT PRIMARY KEY,
                message     VARCHAR (200)        DEFAULT NULL,
                deleted     INT                  DEFAULT '0',
                created     DATETIME             DEFAULT NULL
            );";
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        try {
            $sql = "
            DROP TABLE IF EXISTS `mofa_accommodations`;
            CREATE TABLE IF NOT EXISTS mofa_accommodations (
                id            INT AUTO_INCREMENT PRIMARY KEY,
                city          VARCHAR (100)   DEFAULT NULL,
                location      VARCHAR (200)   DEFAULT NULL,
                lattitude     VARCHAR (100)   DEFAULT NULL,
                longitude     VARCHAR (100)   DEFAULT NULL,
                tel           VARCHAR (100)   DEFAULT NULL,
                created       DATETIME        DEFAULT NULL
            );
            
     INSERT INTO `mofa_accommodations` (`id`, `city`, `location`, `lattitude`, `longitude`, `tel`, `created`) VALUES
	(1,'Medina','ariott Medina, King Faisal Street, Opposite Madinah Governor Office','24.464531','39.603261','0123456',NULL),
	(2,'Mecca','Al Hawsawi Building, Aziziya - Off Sidqi St. Landmarks: Mercure Manazil Al Ain, Bank Saudi Fransi','21.413516','39.866764','0123456',NULL),
	(3,'Medina','Intercontinental Dar Al Hijra','24.473588','39.610755','0123456',NULL),
	(4,'Mina','Near 4196, Street 406, Al Mashair','21.410055','39.895196',NULL,NULL),
    (5,'Arafat','Near 3257, Street 8, Al Mashair','21.356709','39.982150',NULL,NULL),
    (6,'Madinah Mövenpick Hotel','Sharia Court Road Madinah Munawarah Madinah Munawarah Saudi Arabia','24.4637981','39.6115914',NULL,NULL)
    ;

UNLOCK TABLES;
            ";
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
}
