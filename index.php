<?php
//index.php 1.0.0 Extract mejorado
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
//C:\xampp\htdocs\wwwsched
$sPathRoot = dirname(__FILE__);
//var_dump($sPathRoot);die;
$sPathRoot = str_replace("\\","/",$sPathRoot);
//$sPathRoot .= "/..";
$arPaths = [
    get_include_path(),
    "$sPathRoot/the_application",
    "$sPathRoot/vendor",
    "$sPathRoot/vendor/composer",
    "$sPathRoot/vendor/fpdf",
    "$sPathRoot/vendor/theframework",
    "$sPathRoot/vendor/theframework",
    ];
$sPathInclude = implode(PATH_SEPARATOR,$arPaths);
set_include_path($sPathInclude);

require_once "vendor/autoload.php";
require_once "components/autoload.php";

$oComp = new TheFramework\Components\ComponentScheduler();
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
        <!--view_list 1.1.0-->
        <div class="col-lg-12">
<?php
$oComp->run();
?>
        </div>
        <!--/view_list-->        
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