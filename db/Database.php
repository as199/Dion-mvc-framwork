<?php


namespace atpro\phpmvc\db;


use atpro\phpmvc\Application;

class Database
{
    public \PDO $pdo;
    /**
     * Database constructor.
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$_ROOT_DIR.'/migrations');
        $toApplyMigrations =  array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration){
            if($migration === '.' || $migration === '..'){
                continue;
            }
            require_once Application::$_ROOT_DIR.'/migrations/'.$migration;
            $className=  pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            echo "All migrations are applied";
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations ( id INT AUTO_INCREMENT PRIMARY KEY, migration varchar(255), created_at TIMESTAMP DEFAULT CURRENT_TIME ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
      $statement =  $this->pdo->prepare("SELECT migration from migrations");
      $statement->execute();
      return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations( array $migrations)
    {

       $str = implode (",",array_map(fn($m)=>"('$m')", $migrations));

       $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
       $statement->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
}