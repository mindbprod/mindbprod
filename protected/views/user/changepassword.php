<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/User/UserChPss.js",CClientScript::POS_END);
?>
<?php
/* @var $this CompanyController */

$this->breadcrumbs=array(
	'Register user',
);
?>           
<div class="row" id="divUser">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'changepass-form',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>
    <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change password
                </div>
                <div class="panel-body">
                    <div class="box-body">
                        <?php echo  $form->errorSummary($modelUser,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelUser,'password'); ?>
                            <?php echo $form->passwordField($modelUser,'password', array ('class' => 'form-control','placeholder'=>'Type password')); ?>
                            <?php echo $form->error($modelUser,'password'); ?>
                        </div>
                        <div class="form-group">
                            <label for="Email_email" class="required">Confirm passowrd <span class="required">*</span></label>
                            <?php echo CHtml::passwordField('User[confirm_password]', "",array('id'=>'confirm_password','class'=>"form-control",'placeholder'=>'Type confirm password')); ?>
                        </div>
                        
                        <div class="box-footer">
                            <div class="col-xs-4">
                                <?php echo CHtml::button('Change Password', array ('class' => 'btn btn-primary','id'=>'btnChangePss')); ?>
                            </div>
                        </div>
                
                    </div>
                </div>
            </div>
    </div>
    <?php $this->endWidget(); ?>
</div>