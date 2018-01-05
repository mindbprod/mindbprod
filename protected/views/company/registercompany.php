<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Company/Company.js",CClientScript::POS_END);
?>
<?php
/* @var $this CompanyController */

$this->breadcrumbs=array(
	'Company',
);
//echo $this->breadcrumbs[0];
?>           
<div class="row" id="divCompany">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'entityreg-form',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                Regstro de empresa
            </div>
            <div class="panel-body">
                
                    <div class="box-body">
                        <?php echo  $form->errorSummary(array($modelCompany,$modelTelephone,$modeloEmail,$modelTypeEnt,$modelWeb,$modelSNetw,$modelContinent,$modelCountry,$modelState,$modelCity),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                        
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_name'); ?>
                            <?php echo $form->textField($modelCompany,'company_name', array ('class' => 'form-control','placeholder'=>'Digite el nombre de la empresa')); ?>
                            <?php echo $form->error($modelCompany,'company_name'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_number'); ?>
                            <?php echo $form->textField($modelCompany,'company_number', array ('class' => 'form-control','placeholder'=>'Digite el número de identificación de la empresa')); ?>
                            <?php echo $form->error($modelCompany,'company_number'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_address'); ?>
                            <?php echo $form->textField($modelCompany,'company_address', array ('class' => 'form-control','placeholder'=>'Digite la dirección de la empresa')); ?>
                            <?php echo $form->error($modelCompany,'company_address'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::label("Telephone - Whatsapp", "Telephone") ?>
                            <?php echo $form->textField($modelTelephone,'telephone_number', array ('class' => 'form-control','placeholder'=>'Digite el teléfono')); ?>
                            <?php echo $form->error($modelTelephone,'telephone_number'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelTypeEnt,'id_typecompany'); ?><br>
                            <?php echo $form->checkBoxList($modelTypeEnt,'id_typecompany',CHtml::listData($typeCompany,'id_typecompany','typecompany_name'));  ?>
                            <?php echo $form->error($modelTypeEnt,'id_typecompany'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_fest_desc'); ?>
                            <?php echo $form->textArea($modelCompany,'company_fest_desc', array ('class' => 'form-control','placeholder'=>'Digite la descripción de la empresa o de la actividad que realiza')); ?>
                            <?php echo $form->error($modelCompany,'company_fest_desc'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelWeb,'web'); ?>
                            <?php echo $form->textField($modelWeb,'web', array ('class' => 'form-control','placeholder'=>'Digite portal web')); ?>
                            <?php echo $form->error($modelWeb,'web'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelContinent,'continent_name'); ?>
                            <?php echo $form->textField($modelContinent,'continent_name', array ('class' => 'form-control','placeholder'=>'Digite Continente')); ?>
                            <?php echo $form->error($modelContinent,'continent_name'); ?>
                            <input name="Continent[id_continent]" id="Continent_id_continent" type="hidden">
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCountry,'country_name'); ?>
                            <?php echo $form->textField($modelCountry,'country_name', array ('class' => 'form-control','placeholder'=>'Digite País')); ?>
                            <?php echo $form->error($modelCountry,'country_name'); ?>
                            <input name="Country[id_country]" id="Country_id_country" type="hidden">
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelState,'state_name'); ?>
                            <?php echo $form->textField($modelState,'state_name', array ('class' => 'form-control','placeholder'=>'Digite Estado o departamento')); ?>
                            <?php echo $form->error($modelState,'state_name'); ?>
                            <input name="State[id_state]" id="State_id_state" type="hidden">
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCity,'city_name'); ?>
                            <?php echo $form->textField($modelCity,'city_name', array ('class' => 'form-control','placeholder'=>'Digite Ciudad')); ?>
                            <?php echo $form->error($modelCity,'city_name'); ?>
                            <input name="City[id_city]" id="City_id_city" type="hidden">
                        </div>
                    </div>
                    <!-- /.box-body -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                Información alterna
            </div>
            <div class="panel-body">
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($modelCompany,'company_observations'); ?>
                                    <?php echo $form->textArea($modelCompany,'company_observations', array ('class' => 'form-control','placeholder'=>'Digite observaciones adicionales respecto a la entidad')); ?>
                                    <?php echo $form->error($modelCompany,'company_observations'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="Email_email" class="required">Email <span class="required">*</span></label>
                                    <?php echo CHtml::textField('input_email', "",array('id'=>'input_email','class'=>"form-control",'placeholder'=>'Digite email')); ?>
                                    <?php echo $form->error($modeloEmail,'email'); ?>
                                    <?php echo CHtml::button('Agregar email', array ('class' => 'btn btn-warning','id'=>'btnAgregaEm')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                emails
                            </div>
                            <div class="panel-body">
                               <div id="email-form">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="SocialNetwork_snetwork" class="required">Snetwork <span class="required">*</span></label>
                                    <?php echo CHtml::textField('input_snet', "",array('id'=>'input_snet','class'=>"form-control",'placeholder'=>'Digite red social')); ?>
                                    <div class="errorMessage" id="SocialNetwork_snetwork_em_" style="display:none">Snetwork cannot be blank.</div>
                                </div>
                                <div class="form-group">
                                    <?php echo CHtml::label("S-network type", "snetwork type") ?><br>
                                    <?php echo CHtml::radioButtonList('TypeSNetwork','TypeSNetwork',CHtml::listData($typeSNetwork,'id_typesnetwork','typesnetwork_name'));  ?><br>
                                    <?php echo CHtml::button('Agregar s-network', array ('class' => 'btn btn-warning','id'=>'btnAgregaRsocial')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                social networks
                            </div>
                            <div class="panel-body">
                                <div id="snetw-form">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="box-footer">
                        <div class="col-xs-4">
                            <?php echo CHtml::button('Registrar', array ('class' => 'btn btn-primary','id'=>'btnRegCmp')); ?>
                            <?php echo CHtml::button('Editar', array ('class' => 'btn btn-warning','id'=>'btnEditaCmp')); ?>
                        </div>
                        <div class="col-xs-4">
                            <?php echo CHtml::button('Cancelar edición', array ('class' => 'btn btn-danger','id'=>'btnCancelaCmp')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php $this->endWidget(); ?>
    
    <!-- /.col-lg-12 -->
</div>
                <!-- /.row -->
            
