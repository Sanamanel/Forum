<?php

$host = getenv('SQLSERVER');

$user = getenv('DBUSER');

$password = getenv('DBPASS');

$database = getenv('DBNAME');

class DBController
{

    //private $host = $host;

    //private $user = getenv('DBUSER');

    //private $password = getenv('DBPASS');

    //private $database = getenv('DBNAME');

    private static $conn;

    function __construct()
    {
        $this->conn = mysqli_connect($host, $user, $password, $database);
        $this->conn->set_charset('utf8mb4');
        $this->conn->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");// Connecting to a database
    }

    public static function getConnection()
    {
        if (empty($this->conn)) {
            new Database();
        }
    }

    function getDBResult($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (! empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        $result = $sql_statement->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if (! empty($resultset)) {
            return $resultset;
        }
    }

    function updateDB($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (! empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
    }

    function bindParams($sql_statement, $params)
    {
        $param_type = "";
        foreach ($params as $query_param) {
            $param_type .= $query_param["param_type"];
        }
        
        $bind_params[] = & $param_type;
        foreach ($params as $k => $query_param) {
            $bind_params[] = & $params[$k]["param_value"];
        }
        
        call_user_func_array(array(
            $sql_statement,
            'bind_param'
        ), $bind_params);
    }
}
