<?php
//
//class Database2 {
//    private $db;
//
//    public function __construct() {
//        try {
//            $this->db = new PDO('mysql:host=' . $GLOBALS['databaseConfig']->server
//                . ';dbname=' . $GLOBALS['databaseConfig']->name,
//                $GLOBALS['databaseConfig']->login,
//                $GLOBALS['databaseConfig']->password, array()); //PDO::ATTR_PERSISTENT => true
//            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            $this->db->exec("set names utf8");
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//    }
//
//
//    /**
//     * Выполняет запрос к БД и получает результат
//     * @param $sql
//     * @param string $type
//     * @return array|mixed
//     */
//    public function query($sql, $type = '') {
//        $result = $this->db->query($sql);
//        switch ($type) {
//            case 'rowCount':
//                return $result->rowCount();
//            case 'column':
//                return $result->fetchAll(PDO::FETCH_COLUMN);
//            case 'fetch':
//                return $result->fetch(PDO::FETCH_ASSOC);
//            default:
//                return $result->fetchAll(PDO::FETCH_ASSOC);
//        }
//    }
//
//    /**
//     * Возвращает названия столбцов из таблицы
//     * @param $table
//     * @return array
//     */
//    public function getColumns($table) {
//        $names = [];
//        $columns = $this->db->query("SHOW COLUMNS FROM $table");
//        foreach ($columns as $column) {
//            $names[] = $column['Field'];
//        }
//        return $names;
//    }
//
//    /**
//     * Возвращает последний id
//     * @return string
//     */
//    public function lastInsertId() {
//        return $this->db->lastInsertId();
//    }
//}


class Database {
    private $_connection;
    private static $_instance; //The single instance

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct() {
        try {
            $this->_connection = new PDO('mysql:host=' . $GLOBALS['databaseConfig']->server
                . ';dbname=' . $GLOBALS['databaseConfig']->name,
                $GLOBALS['databaseConfig']->login,
                $GLOBALS['databaseConfig']->password, array(PDO::MYSQL_ATTR_FOUND_ROWS => true)); //PDO::ATTR_PERSISTENT => true
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_connection->exec("set names utf8");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Get connection
    public function getConnection() {
        return $this->_connection;
    }

    /**
     * Выполняет запрос к БД и получает результат
     * @param $sql
     * @param string $type
     * @return array|mixed
     */
    public static function query($sql, $type = '') {
        $result = Database::getInstance()->getConnection()->query($sql);
        switch ($type) {
            case 'rowCount':
                return $result->rowCount();
            case 'column':
                return $result->fetchAll(PDO::FETCH_COLUMN);
            case 'fetch':
                return $result->fetch(PDO::FETCH_ASSOC);
            case 'withCount':
                return (object)array(
                    'rowCount' => $result->rowCount(),
                    'result' => $result->fetchAll(PDO::FETCH_ASSOC)
                );
            case 'withCountFetch':
                return (object)array(
                    'rowCount' => $result->rowCount(),
                    'result' => $result->fetch(PDO::FETCH_ASSOC)
                );
            case 'asResult':
                return $result;
            default:
                return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }


    /**
     * Возвращает названия столбцов из таблицы
     * @param $table
     * @return array
     */
    public static function getColumns($table) {
        $names = [];
        $columns = Database::getInstance()->getConnection()->query("SHOW COLUMNS FROM $table");
        foreach ($columns as $column) {
            $names[] = $column['Field'];
        }
        return $names;
    }

    /**
     * Возвращает последний id
     * @return string
     */
    public static function lastInsertId() {
        return Database::getInstance()->getConnection()->lastInsertId();
    }
}
