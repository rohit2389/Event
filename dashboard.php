<?php 
    require_once('auth.php');
    require_once('connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/jquery.datetimepicker.css"/>
    <link href='./css/fullcalendar.css' rel='stylesheet' />
    <link href='./css/fullcalendar.print.css' rel='stylesheet' media='print' />
<style type="text/css">
body{
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
span.twitter-typeahead {
    width: 100%;
    }
.bs-example{
    font-family: sans-serif;
    position: relative;
    margin: 50px;
}
.typeahead, .tt-query, .tt-hint {
    height: 30px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
}
.typeahead {
    background-color: #FFFFFF;
}
.tt-query {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
    color: #D8D4D4;
}
.tt-dropdown-menu {
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    margin-top: 12px;
    padding: 8px 0;
    width: 100%;
}
.tt-suggestion {
    line-height: 24px;
    padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
    background-color: #0097CF;
    color: #FFFFFF;
}
.tt-suggestion p {
    margin: 0;
}</style>

</head>

<body>
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        UserManagement
                    </a>
                </li>
                <li>
                    <a href="http://localhost/stu_log/dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a class="sidebar-nav-page-load" href="calendar.php">Events</a>
                </li>
                <li>
                    <a class="sidebar-nav-page-load" href="GoogleForm.html">Profile</a>
                </li>
                <li>
                    <a class="sidebar-nav-page-load" href="TypeForm.html">Notification</a>
                </li>
            </ul>
        </div>
        <!-- /#top menubar-wrapper -->
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><span id="menu-toggle" class="glyphicon glyphicon-transfer"></span></a>
            </div>
              <div class="navbar-nav navbar-right">
                <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['SESS_USER_USERNAME']; ?> </a>
                <a class="navbar-brand" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
              </div>
          </div>
        </nav>

        <div id="page-content-wrapper"> 

                <?php
                if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
                    if($_SESSION['status'] == 'success'){
                        echo '<div class="alert alert-success">';
                    }elseif ($_SESSION['status'] == 'error') {
                        echo '<div class="alert alert-danger">';
                    }
                    foreach($_SESSION['ERRMSG_ARR'] as $msg) {
                      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>',$msg,'</div>';
                    }
                      unset($_SESSION['ERRMSG_ARR']);
                      unset($_SESSION['status']);
                  }
                ?>


              <button type="button" class="btn btn-danger fa fa-plus" data-toggle="modal" data-target="#addEvent">&nbsp;Add New Event</button>

                <div class="table-responsive">
                <div class="panel panel-primary">
              <!-- Add modal -->
                <div class="modal fade" id="addEvent" role="dialog">
                    <div class="modal-dialog">
                        <form action="event-exec.php" id="add-event" method="post" name="add-event">
                          <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Event</h4>
                            </div>
                            <div class="modal-body">

                            <div class="row">                      
                                <div class="form-group col-sm-4">Event Name</div>
                                <div class='col-sm-7'>
                                    <input type="text" class="form-control" name="event_name" placeholder="Event Name" />
                                </div>
                                <div class="form-group col-sm-1"></div>
                            </div>

                            <div class="row">                      
                                <div class="form-group col-sm-4">Event Start</div>
                                <div class='col-sm-7'>
                                    <input type="text" class="form-control datetimepicker" name="event_start" placeholder="yyyy/mm/dd hh:mm:ss" />
                                </div>
                                <div class="form-group col-sm-1"></div>
                            </div>

                            <div class="row">                      
                                <div class="form-group col-sm-4">Event End</div>
                                <div class='col-sm-7'>
                                    <input type="text" class="form-control datetimepicker" name="event_end" placeholder="yyyy/mm/dd hh:mm:ss"/>
                                </div>
                                <div class="form-group col-sm-1"></div>
                            </div>
                            
                            <div class="row">      
                                    <div class="form-group col-sm-4">User ID</div>
                                        <div class='col-sm-7'>
                                <?php if($_SESSION['SESS_USER_ROLE'] =='Tutor'){
                                    ?>
                                    <input type="text" name="typeahead" class="form-control typeahead" autocomplete="off" spellcheck="false" placeholder="User Name">
                                    </div>
                                <?php }
                                else{
                                ?>
                                    <input type="text" class="form-control" name="typeahead" value="<?php echo $_SESSION['SESS_USER_USERNAME'];?>" readonly/>
                                </div>
                                <div class="form-group col-sm-1"></div>
                                <?php 
                                }?>
                            </div>                 
                              

                            </div>
                            <div class="modal-footer">
                              <div class="form-group">
                                <button type="button" class="btn btn-danger fa fa-reply" data-dismiss="modal"> Close</button>
                                <button type="submit" class="btn btn-primary fa fa-check" name="add"> Add Event</button>
                              </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>

              <!-- End of Add modal -->
                <div class="panel-body">
                <table class="table table-striped"id="example">

                <tr>
                    <?php 

                    if($_SESSION['SESS_USER_ROLE'] == 'Student'){?> <th>event id</th> 
                    <?php
                    }else{ ?>
                    <th>User id</th>
                    <?php } ?>

                    <th>Event</th>
                    <th>Event Start</th>
                    <th>Event End</th>
                    <th>Action</th>
                </tr>
                    <?php
                    
                    if($_SESSION['SESS_USER_ROLE'] == 'Student'){
                         $stmt = $conn ->prepare('select event_id, event, event_start, event_end from events where user_id ="'.$_SESSION['SESS_USER_ID'].'"');
                    }else{
                          $stmt = $conn ->prepare('select event_id, user_id, event, event_start, event_end from events');
                    }
                       
                        $stmt -> execute();
                        $result = $stmt -> fetchAll();
                        foreach ($result as $row) {
                            $id = $row['event_id']
                    ?>
                        <tr>
                        <?php if($_SESSION['SESS_USER_ROLE'] == 'Student'){?> <th><?php echo $row['event_id']?></th> 
                        <?php
                        }else{ ?>
                        <th><?php echo $row['user_id']?></th>
                        <?php } ?>
                        <td><?php echo $row['event']?></td>
                        <td><?php echo $row['event_start']?></td>
                        <td><?php echo $row['event_end']?></td>
                        <td style="width:100px">
                            <div class="btn-group">
                              <a href="#editEvent<?php echo $id; ?>" type="button" class="btn btn-default fa fa-edit" data-toggle="modal"></a>
                              <a href="#deleteEvent<?php echo $id; ?>" type="button" class="btn btn-danger fa fa-trash-o" data-toggle="modal"></a>
                            </div>
                            <!-- delete modal -->
                              <div class="modal fade" id="deleteEvent<?php echo $id;?>" id="delete"role="dialog">
                                <div class="modal-dialog">
                                    <form action="event-exec.php" id="event_form" method="post" name="event_form">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Event[ ID: <?php echo $id; ?>]</h4>
                                        </div>
                                        <div class="modal-body">
                                        Are you sure want to delete this event??
                                        </div>
                                        <div class="modal-footer">
                                          <div class="form-group">
                                            <button type="button" class="btn btn-default fa fa-reply" data-dismiss="modal"> Close</button>
                                            <a href="event-exec.php?delete=<?php echo $id;?>" type="submit" class="btn btn-danger fa fa-close"> Delete Event</a>
                                          </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                              </div>
                              <!-- End of delete modal -->

                              <!-- Edit modal -->
                              <div class="modal fade" id="editEvent<?php echo $id; ?>" role="dialog">
                                <div class="modal-dialog">
                                <form action="event-exec.php" id="edit-event" method="post" name="event_form">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Event</h4>
                                    </div>
                                    <div class="modal-body">
                                   <?php 
                                        $stmt = $conn ->prepare('select event_id, user_id, event, event_start, event_end from events where event_id = "'.$id.'"');                                                       
                                        $stmt -> execute();
                                        $result = $stmt -> fetchAll();
                                        foreach ($result as $row) {
                                        ?>
                                        <div class="row">                      
                                            <div class="col-sm-4"></div>
                                            <div class='col-sm-7'>
                                                <input type="hidden" value="<?php echo $row['event_id']; ?>" name="event_id"/>
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>

                                        <div class="row">                      
                                            <div class="form-group col-sm-4">Event Name</div>
                                            <div class='col-sm-7'>
                                                <input type="text" value="<?php echo $row['event']; ?>" class="form-control" name="event_name" placeholder="Event Name" />
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                        </div>

                                        <div class="row">                      
                                            <div class="form-group col-sm-4">Event Start</div>
                                            <div class='col-sm-7'>
                                                <input type="text" value="<?php echo $row['event_start']; ?>" class="form-control datetimepicker" name="event_start" placeholder="yyyy/mm/dd hh:mm:ss" />
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                        </div>

                                        <div class="row">                      
                                            <div class="form-group col-sm-4">Event End</div>
                                            <div class='col-sm-7'>
                                                <input type="text" value="<?php echo $row['event_end']; ?>" class="form-control datetimepicker" name="event_end" placeholder="yyyy/mm/dd hh:mm:ss"/>
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                        </div>

                                        <div class="row">                      
                                            <div class="form-group col-sm-4">User ID</div>
                                            <div class='col-sm-7'>
                                                <input type="text" value="<?php echo $_SESSION['SESS_USER_USERNAME']; ?>" class="form-control" name="user_id" value="<?php echo $_SESSION['SESS_USER_USERNAME'];?>" readonly/>
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                        </div>
                                        <?php }?>

                                    </div>
                                    <div class="modal-footer">
                                      <div class="form-group">
                                        <button type="button" class="btn btn-danger fa fa-reply" data-dismiss="modal"> Close</button>
                                        <button type="submit" class="btn btn-primary fa fa-check" name="edit"> Edit Event</button>
                                      </div>
                                    </div>
                                    </div>
                                </form>
                                </div>
                              </div>
                              <!-- End of edit modal -->
                        </td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>

            </div>
            </div>
            </div>
       
        </div>
    </div>
    
    <script src="js/jquery-2.2.0.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src='./js/moment.min.js'></script>
    <script src="js/jquery.datetimepicker.full.js"></script>
    <script src='./js/fullcalendar.min.js'></script>
    <script src="js/typeahead.min.js"></script>
    <script>
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search.php?key=%QUERY',
        limit : 10
        });
    });
    </script>

    <script>
    $(document).ready(function(){
        $.datetimepicker.setLocale('en');

        $('.datetimepicker').datetimepicker({
        dayOfWeekStart : 1,
        lang:'en'
        });
        $('.datetimepicker').datetimepicker({step:10});
      
    });
    </script>

 <script>
    
    $(function(){
        $("#edit-event").validate({
        onkeyup: function(element){this.element(element);},    
        rules: {
            event_id: "required",
            event_name: "required",
            event_start: "required",
            event_end: "required",
            user_id: "required"
        },
        
        messages: {
            event_id: "Please enter event ID",
            event_name: "Please enter event name",
            event_end: "Please enter event start datetime",
            event_end: "Please enter event end datetime",
            user_id: "Please enter user name",
        }
        });

        $("#add-event").validate({
        onkeyup: function(element){this.element(element);},    
        rules: {
            event_name: "required",
            event_start: "required",
            event_end: "required",
            user_id: "required"
        },
        
        messages: {
            event_name: "Please enter event name",
            event_start: "Please enter event start datetime",
            event_end: "Please enter event end datetime",
            user_id: "Please enter user name",
        }
        });

        $(".sidebar-nav-page-load").click(function(e){
            e.preventDefault(); //To prevent the default anchor tag behaviour
            var url = this.href;
            $("#page-content-wrapper").load(url);
        });

        $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
        });
     });

  </script>
</body>
</html>
    
