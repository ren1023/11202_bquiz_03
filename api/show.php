<?php include_once "db.php";


$row=$Movie->find($_POST['id']);
$row['sh']=($row['sh']==1)?0:1;
$Movie->save($row);

?>