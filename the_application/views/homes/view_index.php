<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Scheduler</title>
    <meta name="description" content="Job Scheduler">
<?php
include("elem_analytics.php");
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
<div id="divMain" class="container-fluid">
<?php
//include("elem_navbar.php");
?>   
    <div class="row">
        <div class="col-lg-12">
            <br/>
<?php
$oCompSched->run();
?>
        </div>
    </div>
    <p class="text-center">
<!--elem_totop-->
        <span class="hidden">
            <a href="#divMain" class="well well-sm">
                <i class="glyphicon glyphicon-chevron-up"></i> Back to Top
            </a>
        </span>
<!--/elem_totop-->        
    </p>
</div>
<!--elem_footer 1.0.0-->
<footer class="footer">
    <div class="container">
        <ul class="list-inline">
            <li class="list-inline-item">
                <a rel="nofollow"  class="btn btn-block" href="/"> 
                    <span class="fa fa-home"></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a rel="nofollow" class="btn btn-block btn-social btn-github" href="https://github.com/eacevedof/prj_phpscheduler"> 
                    <span class="fa fa-github"></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a rel="nofollow"  href="https://twitter.com/eacevedof" class="btn btn-block btn-social btn-twitter"> 
                    <span class="fa fa-twitter"></span>
                </a>
            </li>
        </ul>
    </div>
</footer>
</body>
</html>