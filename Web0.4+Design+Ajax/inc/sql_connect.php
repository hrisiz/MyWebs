<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}


error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
$web['connection'] = 'sqlsrv';

$web['dbhost'] = 'WIN-QCJ6LL1IJDS';

$web['database'] = 'MuOnline';

$web['dbuser'] = 'sa';

$web['dbpassword'] = 'Psihopat1';

try {
    $grizismudb = new PDO($web['connection'].":Server=".$web['dbhost'].";Database=".$web['database'], $web['dbuser'], $web['dbpassword']);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}