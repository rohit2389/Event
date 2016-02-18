<?php
	require_once('connection.php');
	require_once('auth.php');
 	// session_start();
	$errmsg_arr = array();

if (isset($_REQUEST['add'])) {
		$event_name = $_POST['event_name'];
		$event_start = $_POST['event_start'];
		$event_end = $_POST['event_end'];
		$user_name = $_POST['typeahead'];
		$user_id = searchUserID($user_name, $conn);
		if($user_id <= 0){
				$errmsg_arr[] = "username does not exist please enter valid user name.";
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				$_SESSION['status'] = 'error';
				session_write_close();
				header("location: dashboard.php");
				exit();
		}else{
				// event validation
				eventValidation($event_start, $event_end);

			    // event exist or not
				$events = eventExist($event_start, $event_end, $conn);

				if($events){
				 		// event already exist
				 		$errmsg_arr[] = "Event already exist please update your datetime.";
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								$_SESSION['status'] = 'error';
								session_write_close();
								header("location: dashboard.php");
								exit();
				}else{
				 		// add new event
				 		$event_id = addEvent($event_start, $event_end, $event_name, $user_id, $conn);
				 		if($event_id){
				 		$errmsg_arr[] = "Event added successfully. Event id is". $event_id;
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								$_SESSION['status'] = 'success';
								session_write_close();
								header("location: dashboard.php");
								exit();
				 		}else{
				 			//some thing went wrong while adding new event
				 			$errmsg_arr[] = "Something went wrong.";
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								$_SESSION['status'] = 'error';
								session_write_close();
								header("location: dashboard.php");
								exit();
				 		}
				}
		}
// event edit
}elseif (isset($_REQUEST['edit'])) {
		$event_name = $_POST['event_name'];
		$event_start = $_POST['event_start'];
		$event_end = $_POST['event_end'];
		$user_id = $_POST['user_id'];
		$event_id = $_POST['event_id'];

		//event datetime validation
		eventValidation($event_start, $event_end);

		//event exist
		$events = eventExist($event_start, $event_end, $conn);
		if($events){
	 		$errmsg_arr[] = "Updation failed! Event already exist please update your datetime.";
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					$_SESSION['status'] = 'error';
					session_write_close();
					header("location: dashboard.php");
					exit();
	 	}else{
				$affected_rows = updateEvent($event_name, $event_start, $event_end, $user_id, $event_id, $conn);
				    if($affected_rows <= 0){
				    	$errmsg_arr[] = "Updation failed! please later.";
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							$_SESSION['status'] = 'error';
							session_write_close();
							header("location: dashboard.php");
							exit();
				    }else{
				    	$errmsg_arr[] = $affected_rows ."Event is updated";
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							$_SESSION['status'] = 'success';
							session_write_close();
							header("location: dashboard.php");
							exit();
				    }
		}
}elseif (isset($_GET['delete'])){
		$deleteEvent = deleteEvent($_SESSION['SESS_USER_ID'], $_GET['delete'], $conn);
			if($deleteEvent <= 0){
					$errmsg_arr[] = "You can't delete this event";
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							$_SESSION['status'] = 'error';
							session_write_close();
							header("location: dashboard.php");
							exit();
				}else{
					$errmsg_arr[] = "Event deleted";
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							$_SESSION['status'] = 'success';
							session_write_close();
							header("location: dashboard.php");
							exit();
				}

}else{
	header("location: notfound.html");
}
function eventValidation($event_start, $event_end)
	{
	$datediff = date("Y-m-d H:i:s", strtotime($event_start ."+30 minutes"));
		date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d H:i:s', time());

        //event start and end datetime should not be passed
        if($event_start < $date or $event_end < $date){
        	$errmsg_arr[] = "Datetime already passed please update your datetime";
                $_SESSION['status'] = 'error';
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
				header("location: dashboard.php");
				exit();
		//event end should be greater than end start datetime
        }elseif ($event_start > $event_end) {
        	$errmsg_arr[] = "Event start datetime should not be greater than plaese update datetime";
                $_SESSION['status'] = 'error';
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
				header("location: dashboard.php");
				exit();
		//min event duration should be 30 min
        }elseif($datediff > $event_end){
        	$errmsg_arr[] = "Event should not be less than 30 min";
                $_SESSION['status'] = 'error';
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
				header("location: dashboard.php");
				exit();
        }
	}
function deleteEvent($user_id, $event_id, $conn)
	{
		if($_SESSION['SESS_USER_ROLE'] == 'Tutor'){
			$stmt =  $conn->prepare("DELETE FROM events WHERE event_id ='$event_id'");
		}else{
			$stmt =  $conn->prepare("DELETE FROM events WHERE event_id ='$event_id' AND user_id = '$user_id'");
		}
	    $stmt->execute();
	    $affected_rows = $stmt->rowCount();
	    return $affected_rows;
	}

function updateEvent($event_name, $event_start, $event_end, $user_id, $event_id, $conn)
	{
		$stmt =  $conn->prepare("UPDATE events SET event = '$event_name', event_start = '$event_start', event_end = '$event_end' WHERE event_id = '$event_id' AND user_id = '$user_id'");
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
	}


function addEvent($event_start, $event_end, $event_name, $user_id, $conn)
	{
		$sql = "INSERT INTO events (event, event_start, event_end, user_id)
    	VALUES ('$event_name', '$event_start','$event_end', '$user_id')";
    	$conn->exec($sql);
    	$event_id = $conn->lastInsertId();
    	return $event_id;
	    	
	}

function eventExist($event_start, $event_end, $conn)
	{
		$sql = "select * from events
                WHERE event_start BETWEEN '$event_start' AND '$event_end'
                OR
                event_end BETWEEN '$event_start' AND '$event_end'
                OR
                event_start <= '$event_start' AND  event_end >= '$event_end'";
        $stmt = $conn ->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num_rows = count($rows);
        return $num_rows;
    }

 function searchUserID($user_name, $conn)
	{
		$sql = "select user_id from user
                WHERE user_name = '$user_name'";
        $stmt = $conn ->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user_id = $rows['user_id'];
    }
?>
