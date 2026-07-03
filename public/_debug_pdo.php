<?php
header('Content-Type: text/plain');
var_export(extension_loaded('pdo'));
echo "\n";
var_export(extension_loaded('pdo_mysql'));
echo "\n";
var_export(PDO::getAvailableDrivers());
echo "\n";
