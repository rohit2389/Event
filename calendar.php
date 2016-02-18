<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' /><!-- 
<link href='./css/fullcalendar.css' rel='stylesheet' />
<link href='./css/fullcalendar.print.css' rel='stylesheet' media='print' /> -->
<!-- <script src='./js/lib/moment.min.js'></script>
<script src='./js/lib/jquery.min.js'></script>
<script src='./js/fullcalendar.min.js'></script> -->
<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: "http://localhost/stu_log/events.php"
        });
        
    });

</script>
<style>

   

    #calendar {
        max-width: 750px;
        margin: 0 auto;
    }

</style>
</head>
<body>

    <div id='calendar'></div>

</body>
</html>
