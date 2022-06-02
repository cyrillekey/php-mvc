<?php
namespace app\core;

use PDO;

class Database{

    public PDO $pdo;
    public function __construct(array $config)
    {
        $dsn=$config['dsn'];
        $user=$config['user'];
        $password=$config['password'];
        $this->pdo = new PDO($dsn,$user,$password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    }
    public function applyMigrations(){
        $newMigrations=[];
        $this->createMigrationTable();
       $applied_migrations= $this->getAppliedMigrations();
        $files=scandir(Application::$ROOT_DIR.'./migrations');
        $toApplyMigrations=array_diff($files,$applied_migrations);
        foreach($toApplyMigrations as $migration){
            if($migration==='.' || $migration===".."){
                continue;
            }
            require_once Application::$ROOT_DIR."./migrations/$migration";
            $classname=(pathinfo($migration,PATHINFO_FILENAME));
            $instance=new $classname;
            $this->log("Applying migration $migration\n");
            $instance->up();
            $this->log("Applied migration $migration\n");
            $newMigrations[]=$migration;
        }
        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            echo "All migrations are apllied\n";
        }
    }
    public function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,migration VARCHAR(255),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)ENGINE=INNODB;");
    }
    public function getAppliedMigrations(){
       $stmt= $this->pdo->prepare("SELECT migration from migrations");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function saveMigrations(array $migrations)
    {   var_dump($migrations);
           $migrations=implode(",",array_map(fn($n)=>"('$n')",$migrations));
        $stmt=$this->pdo->prepare("INSERT INTO migrations (migration) values $migrations");
        $stmt->execute();
        
    }
    public function log($var )
    {
        echo '['.date('Y-m-d H:i:s').'] '.$var;
    }
}
?>