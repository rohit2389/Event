<?php
 $json = array();
 $requete = "SELECT event_id, event_start, event_end FROM events ORDER BY event_id";
 
 try {
 $db = new PDO('mysql:host=localhost;dbname=user_management', 'root', '');
 } catch(Exception $e) {
 exit('unable to connect database.');
 }
 $result = $db->query($requete) or die(print_r($bdd->errorInfo()));
 $events = $result->fetchAll(PDO::FETCH_ASSOC);
 $temp1 = [];
 foreach ($events as $event) {
 		$temp['id'] =$event['event_id'];
 		$temp['start'] =$event['event_start'];
 		$temp['end'] =$event['event_end'];
 		$temp1[] =	$temp;
 }
 echo json_encode($temp1);
 
?>