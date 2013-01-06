<?php

interface IDBWrapper
{
    /**
     * inserts new object(s)
     * @param $objectName
     * @param $object
     */
    public function addObject($objectName, $object);

    /**
     * deletes all objects from table with name of $objectName
     * @param $objectName
     */
    public function deleteObjects($objectName);

    /**
     * deletes object(s) from table with name $objectName
     * and with specified $ids
     * @param $objectName
     * @param $ids
     */
    public function deleteObjectsByID($objectName, $ids);

    /**
     * returns value with specified $id<br>
     * from dictionary with name specified by $dictName
     * @param $dictName - - name of the dictionary
     * @param $id id of the value from dictionary
     * @return dictionary value as string
     */
    public function getDictValue($dictName, $id);

    /**
     * returns list of available values<br>
     * for dictionary with name specified by $dictName
     * @param $dictName - - name of the dictionary
     * @return dictionary values as array of strings
     */
    public function getDictValues($dictName);

    /**
     * returns object with $id
     * @param $id
     */
    public function getObject($objectName, $id);

    /**
     * returns array of objects from $table
     * @param $table
     */
    public function getObjects($objectName);

    /**
     * sets values from $values array<br>
     * to dictionary with name specified by $dictName
     * @param $dictName - - name of the dictionary
     * @param $values - - name of the value
     */
    public function setDictValues($dictName, $values);

    /**
     * updates existing object(s)
     * @param $objectName
     * @param $object
     */
    public function updateObject($objectName, $object);
}

?>