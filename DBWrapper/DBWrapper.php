<?php

require_once 'IDBWrapper.php';
require_once 'DBWrapperHelper.php';
require_once 'Debugger.php';

final class DBWrapper implements IDBWrapper
{
    public function addObject($objectName, $object)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($objectName, $object));

        if (!is_array($object))
        {
            $object = array($object);
        }

        foreach ($object as $row)
        {
            $values = $row->getSetAttributes();

            DBWHlp::insertRow($this->pdo, $objectName, $values);
        }

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($objectName, $object));
    }

    public function deleteObjects($objectName)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $objectName);

        DBWHlp::deleteAll($this->pdo, $objectName);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $objectName);
    }

    public function deleteObjectsByID($objectName, $ids)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($objectName, $ids));

        DBWHlp::deleteByID($this->pdo, $objectName, $ids);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($objectName, $ids));
    }

    public function getDictValue($dictName, $id)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($dictName, $id));

        return DBWHlp::selectColumnByID($this->pdo, 'nazwa', $dictName, $id);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($dictName, $id));
    }

    public function getDictValues($dictName)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $dictName);

        $result = DBWHlp::selectColumn($this->pdo, 'nazwa', $dictName);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $result);

        return $result;
    }

    public function getObject($objectName, $id)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($objectName, $id));

        $result = DBWHlp::selectAllByID($this->pdo, $objectName, $id);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $result);

        return $result;
    }

    public function getObjects($objectName)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $objectName);

        $result = DBWHlp::selectAll($this->pdo, $objectName);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $result);

        return $result;
    }

    /**
     * * returns interface to DBWrapper singleton
     * @param $host - - server host name
     * @param $dbname - - db name
     * @param $user - - db user name
     * @param $password - - db user password
     * @return IDBWrapper cast of DBWrapper object
     */
    public static function instance($host = NULL, $dbname = NULL, $user = NULL, $password = NULL)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($host, $dbname, $user));

        if (!isset(self::$dbwrapper))
        {
            self::$dbwrapper = new DBWrapper($host, $dbname, $user, $password);
        }

        $cast = DBWrapper::castIDBWrapper(self::$dbwrapper);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array(self::$dbwrapper, $cast));

        return $cast;
    }

    public function setDictValues($dictName, $values)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($dictName, $values));

        DBWHlp::insertRow($this->pdo, $dictName, $values);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $dictName);
    }

    public function updateObject($objectName, $object)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($objectName, $object));

        if (!is_array($object))
        {
            $object = array($object);
        }

        foreach ($object as $row)
        {
            $values = $row->getSetAttributes();

            $id = $values['id'];
            unset($values['id']);

            DBWHlp::update($this->pdo, $objectName, $values, $id);
        }

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($objectName, $object));
    }

    /**
     * casts DBWrapper to IDBWrapper
     * @param IDBWrapper $dbw
     * @return IDBWrapper cast of DBWrapper object
     */
    private static function castIDBWrapper(IDBWrapper $dbw)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'cast:', $dbw);
        return $dbw;
    }

    private function DBWrapper($host, $dbname, $user, $password)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($host, $dbname, $user, $password));

        $host = 'mysql:host='.$host;
        $dsn = $host.';charset=utf8';

        $conn = new PDO($dsn, $user, $password);
        $sqlFileName = $dbname.'.sql';

        $this->initDB($sqlFileName, $conn);

        $dbname = 'dbname='.$dbname;
        $dsn = $host.';'.$dbname.';charset=utf8';

        $this->pdo = new PDO($dsn, $user, $password);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($dsn, $conn, $sqlFileName, $this->pdo));
    }

    private function initDB($sqlFileName, $conn)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($sqlFileName, $conn));

        $sqlQuery = @fread(@fopen($sqlFileName, 'r'), @filesize($sqlFileName));

        $queries = explode(';', $sqlQuery);

        foreach ($queries as $query)
        {
            $conn->exec($query);
        }

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $queries);
    }

    private $pdo;
    private static $dbwrapper;
}

?>