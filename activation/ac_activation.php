<?php
require_once('../connection.php');
$user_id = $_GET['user_id'];
session_start();
$errmsg_arr = array();

try {
    $sql = 'select user_id, firstname, password, email, status from user where user_id="'.$user_id.'"';
    $stmt = $conn ->prepare($sql);
    $stmt ->execute();
    $row_count = $stmt->rowCount();
    $result = $stmt -> fetchAll();
    
        if($row_count > 0){
            foreach ($result as $row) {
                $status = $row['status'];
            }
            if($status == 'Inactive'){
                    $row_count = activateAccount($user_id, $conn);
                    if($row_count > 0){
                        $stmt = $conn ->prepare('select u.user_id, u.user_name, u.password, u.email, u.status, r.role from user as u, role as r where u.user_id="'.$user_id.'" AND u.user_id = r.user_id');
                        $stmt ->execute();
                        $row_count = $stmt->rowCount();
                            $result = $stmt -> fetchAll();
    
                            if($row_count > 0){
                                // session
                                session_regenerate_id();
                                foreach ($result as $row) {
                                    $_SESSION['SESS_USER_ROLE'] = ($row['role']);
                                    $_SESSION['SESS_USER_ID'] = ($row['user_id']);
                                    $_SESSION['SESS_USER_USERNAME'] = $row['user_name'];
                                    $_SESSION['SESS_USER_EMAIL'] =$row['email'];
                                    $_SESSION['sess_start_time'] = time();
                                }
                                session_write_close();
                                header("location: ../dashboard.php");
                            }
                        
                    }
                

            }else{
                $errmsg_arr[] = "This account is already activated.";
                    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                    $_SESSION['status'] = 'error';
                    session_write_close();
                    header("location: ../index.php");
                    exit();
            }
        
        }else{
            header("location: ../notfound.html");
                    exit();
        }
    }

catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

function activateAccount($user_id, $conn){
    $sql = "UPDATE user SET status='Active' WHERE user_id=".$user_id."";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row_count = $stmt->rowCount();
        return $row_count;
}

?>