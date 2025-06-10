<?php

function selectData($table, $mysqli, $where = '', $select = '*', $order = '')
{
    $sql = "SELECT $select FROM `$table` 
            $where $order";
    return $mysqli->query($sql);
}

function deleteData($table, $mysqli, $where)
{
    $sql = "DELETE FROM `$table` WHERE $where";
    return $mysqli->query($sql);
}
