<?
function get_master_details($pkid){
    $database = new database();
    global $table;

    $query="select * from ".$table['master']." where pkid=$pkid";
    $result=$database->query($query);
    $rs_array=$result->fetchRow();

    return $rs_array;
}
?>