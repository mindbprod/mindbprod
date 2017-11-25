<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Startmin - Bootstrap Admin Theme</title>

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

        <!-- Custom Fonts -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body class="hold-transition login-page">
    <?php
    $this->pageTitle=Yii::app()->name . ' - Login';
    $this->breadcrumbs=array(
            'Login',
    );
?>
    

    
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'login-form',
                                'enableClientValidation'=>true,
                                'enableAjaxValidation'=>true,
                                'clientOptions'=>array(
                                        'validateOnSubmit'=>true,
                                ),
                        )); ?>
                            <fieldset>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'username'); ?>
                                    <?php echo $form->textField($model,'username', array ('class' => 'form-control','placeholder'=>'Digite nombre de usuario')); ?>
                                    <?php echo $form->error($model,'username'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'password'); ?>
                                    <?php echo $form->passwordField($model,'password', array ('class' => 'form-control','placeholder'=>'Digite password')); ?>
                                    <?php echo $form->error($model,'password'); ?>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <?php echo CHtml::submitButton('Login', array ('class' => 'btn btn-primary btn-block btn-flat')); ?>
                            </fieldset>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
</div>
  <!-- /.login-box-body -->

<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
 <?php
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/startmin.js"></script>
</body>
</html>
