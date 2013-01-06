<?php

require_once 'DBWrapper.php';
require_once 'DBTypes.php';
require_once 'Debugger.php';

DBG::setLevel(DBG::enabled);
$dbw = DBWrapper::instance('localhost', 'tores', 'root', 'n15174326dc');

$object = new Pracownik(array(
NULL,'usis','506036763','632','zajebiste',NULL));

$dbw->addObject(Objects::Pracownik, $object);

$objects = $dbw->getObjects(Objects::Pracownik);

?>