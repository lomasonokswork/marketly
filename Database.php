<?php

class Database
{
    private $pdo;

    public function __construct($config)
    {
        $dsn = "mysql:" . http_build_query($config, arg_separator: ";");
        $this->pdo = new PDO($dsn);
    }


    public function query($sql, $params = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

}
?>