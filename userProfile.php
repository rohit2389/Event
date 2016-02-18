<?php 
    require_once('connection.php');
    session_start();
?>
 <!DOCTYPE html>
 <html>
 <head>
     <title></title>
     <style>
        /* USER PROFILE PAGE */
         .img-hover img {
                -webkit-transition: all .3s ease; /* Safari and Chrome */
                -moz-transition: all .3s ease; /* Firefox */
                -o-transition: all .3s ease; /* IE 9 */
                -ms-transition: all .3s ease; /* Opera */
                transition: all .3s ease;
            }
            .img-hover img:hover {
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-transform:translateZ(0) scale(1.20); /* Safari and Chrome */
                -moz-transform:scale(1.20); /* Firefox */
                -ms-transform:scale(1.20); /* IE 9 */
                -o-transform:translatZ(0) scale(1.20); /* Opera */
                transform:translatZ(0) scale(1.20);
            }

         .card {
            margin-top: 20px;
            padding: 30px;
            background-color: rgba(214, 224, 226, 0.2);
            -webkit-border-top-left-radius:5px;
            -moz-border-top-left-radius:5px;
            border-top-left-radius:5px;
            -webkit-border-top-right-radius:5px;
            -moz-border-top-right-radius:5px;
            border-top-right-radius:5px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .card.hovercard {
            position: relative;
            padding-top: 0;
            overflow: hidden;
            text-align: center;
            background-color: #fff;
            background-color: rgba(255, 255, 255, 1);
        }
        .card.hovercard .card-background {
            height: 130px;
        }
        .card-background img {
            -webkit-filter: blur(25px);
            -moz-filter: blur(25px);
            -o-filter: blur(25px);
            -ms-filter: blur(25px);
            filter: blur(25px);
            margin-left: -100px;
            margin-top: -200px;
            min-width: 130%;
        }
        .card.hovercard .useravatar {
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
        }
        .card.hovercard .useravatar img {
            width: 100px;
            height: 100px;
            max-width: 100px;
            max-height: 100px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.5);
        }
        .card.hovercard .card-info {
            position: absolute;
            bottom: 14px;
            left: 0;
            right: 0;
        }
        .card.hovercard .card-info .card-title {
            padding:0 5px;
            font-size: 20px;
            line-height: 1;
            color: #262626;
            background-color: rgba(255, 255, 255, 0.5);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .card.hovercard .card-info {
            overflow: hidden;
            font-size: 12px;
            line-height: 20px;
            color: #737373;
            text-overflow: ellipsis;
        }
        .card.hovercard .bottom {
            padding: 0 20px;
            margin-bottom: 17px;
        }
        .btn-pref .btn {
            -webkit-border-radius:0 !important;
        }


     </style>
     <script>
        $(document).ready(function() {
        $(".btn-pref .btn").click(function () {
            $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
            $(this).removeClass("btn-default").addClass("btn-primary");   
        });
        });
     </script>
 </head>
 <body>
<div class="col-lg-12 col-xl-12 col-sm-12 col-xs-12 ">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="./images/avtar_img/avtar.jpg">
            
        </div>
        <div class="useravatar img-hover">
            <img alt="" src="./images/avtar_img/avtar.jpg">
        </div>
        <div class="card-info"> <span class="card-title"><?php echo $_SESSION['SESS_USER_NAME']; ?></span>

        </div>
    </div>
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Details</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                <div class="hidden-xs">Event Details</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                <div class="hidden-xs">Contact Details</div>
            </button>
        </div>
    </div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <h3>Personal Details</h3>
        </div>
        <div class="tab-pane fade in" id="tab2">
          <h3>Event Details</h3>
        </div>
        <div class="tab-pane fade in" id="tab3">
          <h3>Contact Details<br>
          </h3>
        </div>
      </div>
    </div>
    
    </div>
    </body>
 </html>
            
    