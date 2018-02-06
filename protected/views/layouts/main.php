<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>MBP Dashboard</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/morris.css" rel="stylesheet">
        <!-- autosugestion-->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/autocomplete.css">
        <!-- Custom Fonts -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Css Mbp -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/stylesMbp.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Css jquery confirm -->
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    </head>
    <body>
        <?php
            if(!Yii::app()->user->isGuest):
        ?>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">MBP Dashboard </a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="http://mindblowingproductions.com"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo Yii::app()->user->getState('nombreUsuario');?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/changePassword"><i class="fa fa-gear fa-fw"></i> Change password</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <?php
                            if(Yii::app()->user->getState('codeRole')=="SUPERADMIN"):
                        ?>
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="#"><i class="fa fa-industry fa-fw"></i> Company Manager<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/company/registercompany"><i class="fa fa-database fa-fw"></i>Register company information</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/company/showEditcompany"><i class="fa fa-edit fa-fw"></i>Show/Edit company information</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/importfile"><i class="fa fa-file-excel-o fa-fw"></i>Load information from file</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-group fa-fw"></i> User Manager <span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/registerUser"><i class="fa fa-edit fa-fw"></i>Register user</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li>
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/audit"><i class="fa fa-user-secret fa-fw"></i>Audit</a>
                                </li>
                            </ul>
                        <?php endif;?>
                        <?php
                            if(Yii::app()->user->getState('codeRole')=="RECORDER"):
                        ?>
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="#"><i class="fa fa-industry fa-fw"></i> Company Manager<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/company/registercompany"><i class="fa fa-database fa-fw"></i>Register company information</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/company/showEditcompany"><i class="fa fa-edit fa-fw"></i>Show/Edit company information</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/importfile"><i class="fa fa-file-excel-o fa-fw"></i>Load information from file</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                            </ul>
                        <?php endif;?>
                        <?php
                            if(Yii::app()->user->getState('codeRole')=="READER"):
                        ?>
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/company/showEditcompany"><i class="fa fa-edit fa-fw"></i>Show/Edit company information</a>
                                </li>
                            </ul>
                        <?php endif;?>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">MBP Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
               
                <!-- /.row -->
                
                     <?php echo $content; ?>
                
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

       <!-- jQuery 2.2.3 -->
        <?php
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/metisMenu.min.js"></script>

        <!-- Ntify -->
        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/notify.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/startmin.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/Mbp.js"></script>
        <!-- Confirm jquery-->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <script>
            $(document).ready(function() {
                $(window).on('beforeunload', function() {
                    if (!Mbp.estadoGuarda) {
                        return "No ha guardado datos";
                    }
                });

            });
        </script>
    <?php
        else:
            echo $content;
        endif;
    ?>
    </body>
</html>
