<?php

Class Banco
{

    private $database;
    private $host;
    private $username;
    private $password;
    private $charset;
    private $pdo;
    private $options;
    private $dsn;

    //singleton
    public static $LOG = array();
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new Banco();
        return self::$instance;
    }


    private function __construct()
    {
        $config = include ABSPATH_CONFIG . '/config.php';
        $this->config = $config['connection'][$config['default']];

        extract($this->config);
        $this->database = $database;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->setPDO();
    }


    private function setPDO()
    {
        switch ($this->config['driver']) {
            case 'mysql':
                $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset;
                $names = $names = "set names '$this->charset'" . (!is_null($this->collation) ? " collate '$this->collation'" : '');
                $this->options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset //$names
                );
                break;
            // case 'postgress':
            // $this->dsn = 'mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset;
            // $this->options =  array(
            // 	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // 	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // 	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$this->charset
            // 	);
            // break;
        }
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $i) {
            print "Erro: <code>" . $i->getMessage() . "</code>";
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Executa uma query no banco de dados
     * @param  string $query [description]
     * @param  array $bindings [description]
     * @return [object]         [retorna um unico elemento da consulta efetuada]
     */
    public function query($query, $bindings = array())
    {
        $this->addLogSql($query, $bindings);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Executa uma query no banco de dados
     * @param  string $query [description]
     * @param  array $bindings [description]
     * @return array            [retorna um array da consulta efetuada]
     */
    public function queryAll($query, $bindings = array())
    {
        $this->addLogSql($query, $bindings);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Executa uma query no banco de dados
     * @param  [type] $query    [description]
     * @param  array $bindings [description]
     * @return [type]           [description]
     */
    public function delete($query, $bindings = array())
    {
        $this->addLogSql($query, $bindings);
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($bindings);
    }

    /**
     * Run an insert statement against the database.
     *
     * @param  string $query
     * @param  array $bindings
     * @return bool
     */
    public function insert($query, $bindings = array())
    {
        $this->addLogSql($query, $bindings);
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($bindings);
    }

    /**
     * Run an update statement against the database.
     *
     * @param  string $query
     * @param  array $bindings
     * @return bool
     */
    public function update($query, $bindings = array())
    {
        $this->addLogSql($query, $bindings);
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($bindings);
    }

    private function addLogSql($query, $binding = array())
    {
        $sql = $this->emulateSql($query, $binding);
        array_push(self::$LOG, array('query' => $query, 'binding' => $binding, 'sql' => $sql));
    }

    /**
     * Returns the emulated SQL string
     *
     * @param $raw_sql
     * @param $parameters
     * @return mixed
     */
    private function emulateSql($raw_sql, $parameters)
    {
        $keys = array();
        $values = $parameters;
        foreach ($parameters as $key => $value) {
            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                if (strpos($key, ':') !== false)
                    $keys[] = '/' . $key . '/';
                else
                    $keys[] = '/:' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }
            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            } elseif (is_array($value)) {
                $values[$key] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }
        $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);
        return $raw_sql;
    }

    /**
     * retorna o ultimo id inserido no banco
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}