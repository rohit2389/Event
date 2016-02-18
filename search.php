<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysql_connect("localhost","root","");
    $db=mysql_select_db("user_management",$con);
    $query=mysql_query("select * from user where user_name LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['user_name'];
    }
    echo json_encode($array);
?>