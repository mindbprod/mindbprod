<?php /* @var $this CompanyController */

$this->breadcrumbs=array(
	'Register user',
);

?> 

<div class="row" id="divUser">
    <?php
     $form=$this->beginWidget('CActiveForm', array(
        'id'=>'import-form',
        'enableClientValidation'=>true,
            'enableAjaxValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        'htmlOptions'=> array('enctype'=>'multipart/form-data'),
    )); ?>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Load Excel to MBP
            </div>
            <div class="panel-body">
                <div class="box-body">
                    <?php echo  $form->errorSummary($model,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'file'); ?>
                        <?php echo $form->fileField($model,'file', array ('class' => 'file-upload btn btn-primary','placeholder'=>'Type person id')); ?>
                        <?php echo $form->error($model,'file'); ?>
                        <?php 
                            echo Yii::app()->getUser()->getFlash('error');
                            echo Yii::app()->getUser()->getFlash('success');
                        ?>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::submitButton('Load data'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
