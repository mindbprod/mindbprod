<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/User/User.js",CClientScript::POS_END);
?>
<?php
/* @var $this CompanyController */

$this->breadcrumbs=array(
	'Register user',
);
?>           
<div class="row" id="divUser">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'userreg-form',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>
    <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Register
                </div>
                <div class="panel-body">
                    <div class="box-body">
                        <?php echo  $form->errorSummary(array($modelPerson,$modelUser),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelPerson,'person_id'); ?>
                            <?php echo $form->textField($modelPerson,'person_id', array ('class' => 'form-control','placeholder'=>'Type person id')); ?>
                            <?php echo $form->error($modelPerson,'person_id'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelPerson,'person_name'); ?>
                            <?php echo $form->textField($modelPerson,'person_name', array ('class' => 'form-control','placeholder'=>'Type person name')); ?>
                            <?php echo $form->error($modelPerson,'person_name'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelPerson,'person_lastname'); ?>
                            <?php echo $form->textField($modelPerson,'person_lastname', array ('class' => 'form-control','placeholder'=>'Type person lastname')); ?>
                            <?php echo $form->error($modelPerson,'person_lastname'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelUser,'id_typeuser'); ?>
                            <?php echo $form->dropDownList($modelUser,'id_typeuser',  CHtml::listData($typeUser,"id_typeuser", "typeuser_name"),array ('class' => 'form-control', 'prompt'=>'Select type user')); ?>
                            <?php echo $form->error($modelUser,'id_typeuser'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelPerson,'person_email'); ?>
                            <?php echo $form->textField($modelPerson,'person_email', array ('class' => 'form-control','placeholder'=>'Type person email')); ?>
                            <?php echo $form->error($modelPerson,'person_email'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelUser,'username'); ?>
                            <?php echo $form->textField($modelUser,'username', array ('class' => 'form-control','placeholder'=>'Type username')); ?>
                            <?php echo $form->error($modelUser,'username'); ?>
                        </div>
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
                                <?php echo CHtml::button('Save', array ('class' => 'btn btn-primary','id'=>'btnRegUser')); ?>
                                <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditUser')); ?>
                            </div>
                            <div class="col-xs-4">
                                <?php echo CHtml::button('Cancel', array ('class' => 'btn btn-danger','id'=>'btnCancel')); ?>
                            </div>
                        </div>
                
                    </div>
                </div>
            </div>
    </div>
    <?php $this->endWidget(); ?>
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                User data
            </div>
            <div class="panel-body">
                <table id="dataTableUser" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Person ID</th>
                            <th>Person name</th>
                            <th>Person lastname</th>
                            <th>Person email</th>
                            <th>User type</th>
                            <th>Username</th>
                            <th>State</th>
                            <th>En/Dis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($users)){
                                foreach($users as $user):
                                     if($user["active_user"]==1){
                                        $state=2;
                                        $codeState="To disable";
                                        $actualState="Enabled";
                                    }
                                    else{
                                        $state=1;
                                        $codeState="To enable";
                                        $actualState="Disabled";
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $user["person_id"]?></td>
                                        <td><?php echo $user["person_name"]?></td>
                                        <td><?php echo $user["person_lastname"]?></td>
                                        <td><?php echo $user["person_email"]?></td>
                                        <td><?php echo $user["typeuser_name"]?></td>
                                        <td><?php echo $user["username"]?></td>
                                        <td><?php echo $actualState?></td><td><a href='javascript:User.changeStatePre("<?php echo $state?>","<?php echo $user["person_id"]?>");'><?php echo $codeState;?></a></td>
                                    </tr>
                                <?php endforeach;
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Person ID</th>
                            <th>Person name</th>
                            <th>Person lastname</th>
                            <th>Person email</th>
                            <th>User type</th>
                            <th>Username</th>
                            <th>State</th>
                            <th>En/Dis</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>