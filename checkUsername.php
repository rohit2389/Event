<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="./js/jquery-2.2.0.js"></script>

</head>
<body>
<div id="registration-form">
  <label for="username">Enter Username :
  <input name="username" type="text" id="username" maxlength="15" required/> <span id="user-result"></span>
  </label>
</div>

</body>

<script type="text/javascript">
$(document).ready(function() {
    var x_timer;    
    $("#username").keyup(function (e){
        clearTimeout(x_timer);
        var user_name = $(this).val();
        x_timer = setTimeout(function(){
        	if(user_name != ''){
        		check_username_ajax(user_name);
        	}else{
        		
        	}
            
        }, 1000);
    }); 

function check_username_ajax(username){
    $("#user-result").html('<img src="ajax-loader.gif" />');
    $.post('available.php', {'username':username}, function(data) {
      $("#user-result").html(data);
    });
}
});
</script>

</html>
