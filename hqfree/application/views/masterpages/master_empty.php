<?php
//header('Content-Type: application/json');
header("Content-Type: application/json; charset=UTF-8",true);
echo  json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
?>