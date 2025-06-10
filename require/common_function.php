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

function updateData($table, $mysqli, $data, $where)
{
    $sql = "UPDATE `$table` SET ";
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "`$key` = '$value'";
    }
    $sql .= implode(", ", $updates);
    $wheres = [];
    $sql .= " WHERE ";
    foreach ($where as $key => $value) {
        $wheres[] = "`$key` = '$value'";
    }
    $sql .= implode(", ", $wheres);
    return $mysqli->query($sql);
}

function insertData($table, $mysqli, $values)
{
    $column = [];
    $value = [];
    foreach ($values as $key => $item) {
        $column[] = "`" . $key . "`";
        $value[] = "'" . $item . "'";
    }
    $colums = implode(', ', $column);
    $values = implode(', ', $value);
    $sql  = "INSERT INTO `$table` 
            ($colums)
            VALUES
            ($values)";
    return $mysqli->query($sql);
}
