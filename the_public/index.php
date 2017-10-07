<?php
//index.php 2.0.0
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
//C:\xampp\htdocs\wwwsched\the_public
$sPathPublic = dirname(__FILE__);
//var_dump($sPathPublic);die;
$sPathPublic = str_replace("\\","/",$sPathPublic);
$sPathProject = "$sPathPublic/..";
$arPaths = [
    get_include_path(),
    "$sPathProject",
    "$sPathProject/the_application",
    "$sPathProject/the_application/boot",
    "$sPathProject/the_application/behaviours",
    "$sPathProject/the_application/components",
    "$sPathProject/the_application/controllers",
    "$sPathProject/the_application/helpers",
    "$sPathProject/the_application/models",
    "$sPathProject/the_application/views",
    "$sPathProject/the_application/views/element",
    "$sPathProject/the_application/views/reactjs",
    //VENDOR
    "$sPathProject/the_vendor",//tiene el autoload de composer
    ];
$sPathInclude = implode(PATH_SEPARATOR,$arPaths);
set_include_path($sPathInclude);

require_once "the_vendor/autoload.php";//atuload para composer
require_once "boot/bootstrap.php";//the_application/boot/bootsrap.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Scheduler</title>
    <meta name="description" content="Job Scheduler">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
<div id="divMain" class="container-fluid">
    <!--elem_navbar 1.0.3-->
    <div class="header clearfix">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" rel="nofollow" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="nofollow" href="https://github.com/eacevedof/prj_phpscheduler">Github</a>
                </li>
            </ul>
        </nav>
        <h3 class="text-muted">Php Scheduler</h3>
    </div>
    <!--/elem_navbar-->     
    <div class="row">
        <div class="col-lg-12">
            <br/>
<?php
$oComp->run();
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