<?php
require_once(LIB_PATH_INC . DS . "config.php");

class MySqli_DB
{

    //Declaración de variables
    private $con;
    public $query_id;

    /*--------------------------------------------------------------*/
    /* Método constructor
    /*--------------------------------------------------------------*/
    function __construct()
    {
        $this->db_connect();
    }

    /*--------------------------------------------------------------*/
    /* Función para abrir la conexión a la base de datos
    /*--------------------------------------------------------------*/
    public function db_connect()
    {
        $this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        if (!$this->con) {
            die(" Database connection failed:" . mysqli_connect_error());
        } else {
            $select_db = $this->con->select_db(DB_NAME);
            if (!$select_db) {
                die("Failed to Select Database" . mysqli_connect_error());
            }
        }
    }
    /*--------------------------------------------------------------*/
    /* Función para cerrar la conexión a la base de datos
    /*--------------------------------------------------------------*/

    public function db_disconnect()
    {
        if (isset($this->con)) {
            mysqli_close($this->con);
            unset($this->con);
        }
    }
    /*--------------------------------------------------------------*/
    /* Función para consultas en mysqli
    /*--------------------------------------------------------------*/
    public function query($sql)
    {

        if (trim($sql != "")) {
            $this->query_id = $this->con->query($sql);
        }
        if (!$this->query_id)

            die("Ha ocurrido un error en esta consulta :<pre> " . $sql . "</pre>");

        return $this->query_id;
    }

    /*--------------------------------------------------------------*/
    /* Función para el asistente de consultas simplificadas de mysqli
    /*--------------------------------------------------------------*/
    public function fetch_array($statement)
    {
        return mysqli_fetch_array($statement);
    }
    public function fetch_object($statement)
    {
        return mysqli_fetch_object($statement);
    }
    public function fetch_assoc($statement)
    {
        return mysqli_fetch_assoc($statement);
    }
    public function num_rows($statement)
    {
        return mysqli_num_rows($statement);
    }
    public function insert_id()
    {
        return mysqli_insert_id($this->con);
    }
    public function affected_rows()
    {
        return mysqli_affected_rows($this->con);
    }
    /*--------------------------------------------------------------*/
    /* Función para eliminar escapes de carácteres especiales
    /* en una cadena para usar en una declaración SQL
    /*--------------------------------------------------------------*/
    public function escape($str)
    {
        return $this->con->real_escape_string($str);
    }
    /*--------------------------------------------------------------*/
    /* Función para un bucle while para utilizar en las consultas
    /*--------------------------------------------------------------*/
    public function while_loop($loop)
    {
        global $db;
        $results = array();
        while ($result = $this->fetch_array($loop)) {
            $results[] = $result;
        }
        return $results;
    }
}

$db = new MySqli_DB();
