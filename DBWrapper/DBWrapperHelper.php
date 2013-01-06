<?php

require_once 'Debugger.php';

class DBWHlp
{
    public static function deleteAll($pdo, $table)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $table);

        $statement = 'DELETE FROM '.$table;

        $pdo->exec($statement);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $statement);
    }

    public static function deleteByID($pdo, $table, $ids)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($table, $ids));

        self::delete($pdo, $table, $ids);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', 'ok');
    }

    public static function insertRow($pdo, $table, $row)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($table, $row));

        if (!is_array(reset($row)))
        {
            $row = array($row);
        }

        foreach ($row as $values)
        {
            self::insert($pdo, $table, $values);
        }

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($table, $row));
    }

    public static function selectAll($pdo, $from)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $from);

        $pdostatement = self::select($pdo, '*', $from);

        $values = $pdostatement->fetchAll(PDO::FETCH_CLASS, $from);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $values);

        return $values;
    }

    public static function selectAllByID($pdo, $from, $ids)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($from, $ids));

        $pdostatement = self::selectWhereIn($pdo, '*', $from, $ids);

        $values = $pdostatement->fetchAll(PDO::FETCH_CLASS, $from);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $values);

        return $values;
    }

    public static function selectColumn($pdo, $which, $from)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($which, $from));

        $pdostatement = self::select($pdo, $which, $from);

        $values = $pdostatement->fetchAll(PDO::FETCH_COLUMN);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $values);

        return $values;
    }

    public static function selectColumnByID($pdo, $which, $from, $ids)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($which, $from, $ids));

        $pdostatement = self::selectWhereIn($pdo, $which, $from, $ids);

        $values = $pdostatement->fetchAll(PDO::FETCH_COLUMN);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $values);

        return $values;
    }

    public static function update($pdo, $table, $values, $id)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($table, $values, $id));

        if (!is_array($id))
        {
            $id = array($id);
        }

        $statement = 'UPDATE '.$table.' SET ';

        foreach ($values as $prop => $val)
        {
            $statement .= $prop.'=\''.$val.'\',';
        }

        $statement = substr_replace($statement, " ", -1);

        $prepared = self::prepareArgs($id);

        $statement .= 'WHERE id IN ('.$prepared.')';

        $pdostatement = $pdo->prepare($statement);
        $pdostatement->execute($id);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($statement, $pdostatement->errorInfo()));
    }

    private static function delete($pdo, $from, $ids)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($from, $ids));

        if (!is_array($ids))
        {
            $ids = array($ids);
        }

        $args = self::prepareArgs($ids);

        $statement = 'DELETE FROM '.$from.' WHERE id IN('.$args.')';

        $pdostatement = $pdo->prepare($statement);
        $pdostatement->execute($ids);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $statement);
    }

    private static function insert($pdo, $table, $values)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($table, $values));

        $args = self::prepareArgs($values);
        $names = self::prepareArgsNames($values);

        $statement = 'INSERT INTO '.$table.'('.$names.') VALUES('.$args.')';

        $values = self::normalizeValues($values);
        $pdostatement = $pdo->prepare($statement);
        $pdostatement->execute($values);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', array($statement, $pdostatement->errorInfo()));
    }

    private static function normalizeValues($values)
    {
        if (!is_array($values))
        {
            $values = array($values);
        }

        $vals = array();

        foreach ($values as $prop => $val)
        {
            array_push($vals, $val);
        }

        return $vals;
    }

    private static function prepareArgs($args)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $args);

        if (!is_array($args))
        {
            $args = array($args);
        }

        $prepared = '';

        foreach ($args as $arg)
        {
            $prepared = $prepared.'?,';
        }

        $prepared = substr_replace($prepared, "", -1);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $prepared);

        return $prepared;
    }

    private static function prepareArgsNames($args)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', $args);

        if (!is_array($args))
        {
            $args = array($args);
        }

        $prepared = '';

        foreach ($args as $prop => $val)
        {
            $prepared .= $prop.',';
        }

        $prepared = substr_replace($prepared, "", -1);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $prepared);

        return $prepared;
    }

    private static function select($pdo, $which, $from)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($which, $from));

        $statement = 'SELECT '.$which.' FROM '.$from;

        $pdostatement = $pdo->query($statement);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $statement);

        return $pdostatement;
    }

    private static function selectWhereIn($pdo, $what, $from, $in)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', array($what, $from, $in));

        if (!is_array($in))
        {
            $in = array($in);
        }

        $args = self::prepareArgs($in);

        $statement = 'SELECT '.$what.' FROM '.$from.' WHERE id IN('.$args.')';
        $pdostatement = $pdo->prepare($statement);

        $pdostatement->execute($in);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', $statement);

        return $pdostatement;
    }
}

?>