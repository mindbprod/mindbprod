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
                <?php echo Yii::t('app','registro_empresa')?>
            </div>
            <div class="panel-body">
                    <div class="box-body">
                        <?php echo  $form->errorSummary(array($modelCompany,$modelTelephone,$modeloEmail,$modelTypeEnt,$modelSNetw),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                        
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_name'); ?>
                            <?php echo $form->textField($modelCompany,'company_name', array ('class' => 'form-control','placeholder'=>Yii::t('app','nombre_empresa'))); ?>
                            <?php echo $form->error($modelCompany,'company_name'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_number'); ?>
                            <?php echo $form->textField($modelCompany,'company_number', array ('class' => 'form-control','placeholder'=>Yii::t('app','numero_empresa'))); ?>
                            <?php echo $form->error($modelCompany,'company_number'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_address'); ?>
                            <?php echo $form->textField($modelCompany,'company_address', array ('class' => 'form-control','placeholder'=>Yii::t('app','direccion_empresa'))); ?>
                            <?php echo $form->error($modelCompany,'company_address'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::label("Telephone - Whatsapp", "Telephone") ?>
                            <?php echo $form->textField($modelTelephone,'telephone_number', array ('class' => 'form-control','placeholder'=>Yii::t('app','telefono_empresa'))); ?>
                            <?php echo $form->error($modelTelephone,'telephone_number'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelTypeEnt,'id_typecompany'); ?><br>
                            <?php echo $form->checkBoxList($modelTypeEnt,'id_typecompany',CHtml::listData($typeCompany,'id_typecompany',Yii::t('app','tipo_empresa')));  ?>
                            <?php echo $form->error($modelTypeEnt,'id_typecompany'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_fest_desc'); ?>
                            <?php echo $form->textArea($modelCompany,'company_fest_desc', array ('class' => 'form-control','placeholder'=>Yii::t('app','actividad_empresa'))); ?>
                            <?php echo $form->error($modelCompany,'company_fest_desc'); ?>
                        </div>
                        <div class="form-group">
                            <label for="Web_web">Web</label>
                            <?php echo CHtml::textField('Web[web]', "",array('id'=>'Web_web','class'=>"form-control",'placeholder'=>Yii::t('app','web_empresa'))); ?>                                                                                 
                            <input name="Web[web]" id="Web_web" type="hidden">
                        </div>
                        <div class="form-group">
                            <label for="Continent_continent_name"><?php echo Yii::t('app','continente')?></label>
                            <?php echo CHtml::textField('Continent[continent_name]', "",array('id'=>'Continent_continent_name','class'=>"form-control",'placeholder'=>Yii::t('app','continente_empresa'))); ?>                                                     
                            <input name="Continent[id_continent]" id="Continent_id_continent" type="hidden">
                        </div>
                        <div class="form-group">
                            <label for="Country_country_name"><?php echo Yii::t('app','pais')?></label>
                            <?php echo CHtml::textField('Country[country_name]', "",array('id'=>'Country_country_name','class'=>"form-control",'placeholder'=>Yii::t('app','pais_empresa'))); ?>                                                                                 
                            <input name="Country[id_country]" id="Country_id_country" type="hidden">
                        </div>
                        <div class="form-group">
                            <label for="State_state_name"><?php echo Yii::t('app','estado')?></label>
                            <?php echo CHtml::textField('State[state_name]', "",array('id'=>'State_state_name','class'=>"form-control",'placeholder'=>Yii::t('app','estado_empresa'))); ?>                                                                                 
                            <input name="State[id_state]" id="State_id_state" type="hidden">
                        </div>
                        <div class="form-group">
                            <label for="City_city_name"><?php echo Yii::t('app','ciudad')?></label>
                            <?php echo CHtml::textField('City[city_name]', "",array('id'=>'City_city_name','class'=>"form-control",'placeholder'=>Yii::t('app','ciudad_empresa'))); ?>                                                                                 
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
                <?php echo Yii::t('app','informacion_alterna')?>
            </div>
            <div class="panel-body">
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($modelCompany,'company_observations'); ?>
                                    <?php echo $form->textArea($modelCompany,'company_observations', array ('class' => 'form-control','placeholder'=>Yii::t('app','observacion_empresa'))); ?>
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
                                    <label for="Email_email" class="required">Email <span class="required">*</span> e.g.: aaa@bbb.com</label>
                                    <?php echo CHtml::textField('input_email', "",array('id'=>'input_email','class'=>"form-control",'placeholder'=>Yii::t('app','email_empresa'))); ?>
                                    <?php echo $form->error($modeloEmail,'email'); ?>
                                    <?php echo CHtml::button(Yii::t('app','agrega_email'), array ('class' => 'btn btn-warning','id'=>'btnAgregaEm')); ?>
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
                                    <?php echo CHtml::textField('input_snet', "",array('id'=>'input_snet','class'=>"form-control",'placeholder'=>Yii::t('app','redsocial_empresa'))); ?>
                                    <div class="errorMessage" id="SocialNetwork_snetwork_em_" style="display:none">Snetwork cannot be blank.</div>
                                </div>
                                <div class="form-group">
                                    <?php echo CHtml::label("S-network type", "snetwork type") ?><br>
                                    <?php echo CHtml::radioButtonList('TypeSNetwork','TypeSNetwork',CHtml::listData($typeSNetwork,'id_typesnetwork','typesnetwork_name'));  ?><br>
                                    <?php echo CHtml::button(Yii::t('app','agrega_redsocial'), array ('class' => 'btn btn-warning','id'=>'btnAgregaRsocial')); ?>
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
                            <?php echo CHtml::button(Yii::t('app','registrar'), array ('class' => 'btn btn-primary','id'=>'btnRegCmp')); ?>
                            <?php echo CHtml::button(Yii::t('app','editar'), array ('class' => 'btn btn-warning','id'=>'btnEditaCmp')); ?>
                        </div>
                        <div class="col-xs-4">
                            <?php echo CHtml::button(Yii::t('app','cancelar_edicion'), array ('class' => 'btn btn-danger','id'=>'btnCancelaCmp')); ?>
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
            
