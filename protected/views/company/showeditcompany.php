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
        <div class="col-lg-12">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'entitysearch-form',
                'enableClientValidation'=>true,
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                )
            )); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search criterials <input type="checkbox" id="aSearchCriteria"  checked="">show/hide
                </div>
                <div class="panel-body" id="divSearchCrit">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                 <div class="panel-heading">
                                     Company data <input type="checkbox" id="chCmp" name="chCmp">
                                </div>
                                <div class="panel-body" id="criteriCmp">
                                    <label for="Company_name" class="required">Company Name</label>
                                    <?php echo CHtml::textField('Company[company_name]', "",array('id'=>'company_name','class'=>"form-control",'placeholder'=>'Type company name')); ?>
                                   
                                    <label for="Company_number" class="required">Company Number</label>
                                    <?php echo CHtml::textField('Company[company_number]', "",array('id'=>'company_number','class'=>"form-control",'placeholder'=>'Type company number')); ?>
                                    
                                    <label for="Company_address" class="required">Company Address</label>
                                    <?php echo CHtml::textField('Company[company_address]', "",array('id'=>'company_address','class'=>"form-control",'placeholder'=>'Type company address')); ?>
                                
                                    <label for="Company_description" class="required">Company Festival description</label>
                                    <?php echo CHtml::textField('Company[company_fest_desc]', "",array('id'=>'company_fest_desc','class'=>"form-control",'placeholder'=>'Type keyword')); ?>

                                    <label for="Company_city" class="required">Company City</label>
                                    <?php echo CHtml::textField('Company[city]', "",array('id'=>'Company_city','class'=>"form-control",'placeholder'=>'Type company city')); ?>
                                    <input name="Company[id_city]" id="Company_id_city" type="hidden">
                                    
                                    <label for="Company_type" class="required">Type Company</label><br>
                                    <?php echo CHtml::checkBoxList('Company[company_type]',"",CHtml::listData($typeCompany,'id_typecompany','typecompany_name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                 <div class="panel-heading">
                                     Telephone <input type="checkbox" id="chTl" name="chTl">
                                </div>
                                <div class="panel-body" id="criteriaTl">
                                    <label for="Telephone_number" class="required">Telephone number</label>
                                    <?php echo CHtml::textField('Telephone[number]', "",array('id'=>'Telephone_number','class'=>"form-control",'placeholder'=>'Type telephone number')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="panel panel-default">
                                 <div class="panel-heading">
                                     Web <input type="checkbox" id="chWeb" name="chWeb">
                                </div>
                                <div class="panel-body" id="criteriaWeb">
                                    <label for="Web_web" class="required">Web</label>
                                    <?php echo CHtml::textField('Web[web]', "",array('id'=>'Web_web','class'=>"form-control",'placeholder'=>'Type web')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="panel panel-default">
                                 <div class="panel-heading">
                                     Email <input type="checkbox" id="chEm" name="chEm">
                                </div>
                                <div class="panel-body" id="criteriaEm">
                                    <label for="Email_email" class="required">Email</label>
                                    <?php echo CHtml::textField('Email[email]', "",array('id'=>'Email_email','class'=>"form-control",'placeholder'=>'Type email')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="panel panel-default">
                                 <div class="panel-heading">
                                     Social Network <input type="checkbox" id="chSN" name="chSN">
                                </div>
                                <div class="panel-body" id="criteriaSN">
                                    <label for="Socialnetwork_snetwork" class="required">Social network</label>
                                    <?php echo CHtml::textField('Socialnetwork[snetwork]', "",array('id'=>'Socialnetwork_snetwork','class'=>"form-control",'placeholder'=>'Type social network')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <?php echo CHtml::button('Search', array ('class' => 'btn btn-primary','id'=>'btnSearchCmp')); ?>
                            <?php echo CHtml::button('Clean data', array ('class' => 'btn btn-warning','id'=>'btnCleanCmp')); ?>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <?php $this->endWidget(); ?>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="dataTableShowDataCmp" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Company number</th>
                                <th>Company name</th>
                                <th>Company address</th>
                                <th>Company/fest description</th>
                                <th>Company city</th>
                                <th>Company telephon</th>
                                <th>Company web</th>
                                <th>Company email(s)</th>
                                <th>Company Social networks(s)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Company number</th>
                                <th>Company name</th>
                                <th>Company address</th>
                                <th>Company/fest description</th>
                                <th>Company city</th>
                                <th>Company telephon</th>
                                <th>Company web</th>
                                <th>Company email(s)</th>
                                <th>Company Social networks(s)</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                    'id'=>'editDataCmp',
                    'options'=>array(
                        'title'=>'Edit data',
                        'autoOpen'=>false,
                        'width'=>'80%',
                        'height'=>'auto'

                    )));?>
    <div class="row" id="divCompanyEdit">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'entityedit-form',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                Company information
            </div>
            <div class="panel-body">
                
                    <div class="box-body">
                        <?php echo  $form->errorSummary(array($modelCompany,$modelTelephone,$modeloEmail,$modelTypeEnt,$modelWeb,$modelSNetw,$modelContinent,$modelCountry,$modelState,$modelCity),'','',array('style' => 'font-size:14px;color:#F00')); ?>
                        
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_name'); ?>
                            <?php echo $form->textField($modelCompany,'company_name', array ('class' => 'form-control','placeholder'=>'Digite el nombre de la empresa')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpName')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_number'); ?>
                            <?php echo $form->textField($modelCompany,'company_number', array ('class' => 'form-control','placeholder'=>'Digite el número de identificación de la empresa')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpNumber')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_address'); ?>
                            <?php echo $form->textField($modelCompany,'company_address', array ('class' => 'form-control','placeholder'=>'Digite la dirección de la empresa')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpAdd')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::label("Telephone - Whatsapp", "Telephone") ?>
                            <?php echo $form->textField($modelTelephone,'telephone_number', array ('class' => 'form-control','placeholder'=>'Digite el teléfono')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpTel')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelTypeEnt,'id_typecompany'); ?><br>
                            <?php echo $form->checkBoxList($modelTypeEnt,'id_typecompany',CHtml::listData($typeCompany,'id_typecompany','typecompany_name'));  ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpTc')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelCompany,'company_fest_desc'); ?>
                            <?php echo $form->textArea($modelCompany,'company_fest_desc', array ('class' => 'form-control','placeholder'=>'Digite la descripción de la empresa o de la actividad que realiza')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpFDesc')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($modelWeb,'web'); ?>
                            <?php echo $form->textField($modelWeb,'web', array ('class' => 'form-control','placeholder'=>'Digite portal web')); ?>
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpWeb')); ?>
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
                            <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpCity')); ?>
                            <input name="Company[id_city]" id="Company_id_city" type="hidden">
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
                Extra information
            </div>
            <div class="panel-body">
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($modelCompany,'company_observations'); ?>
                                    <?php echo $form->textArea($modelCompany,'company_observations', array ('class' => 'form-control','placeholder'=>'Digite observaciones adicionales respecto a la entidad')); ?>
                                    <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpObs')); ?>
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
                                    <?php echo CHtml::button('Agregar email', array ('class' => 'btn btn-warning','id'=>'btnAgregaEm')); ?>
                                    <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpEmls')); ?>
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
                                    <?php echo CHtml::button('Edit', array ('class' => 'btn btn-warning','id'=>'btnEditCmpSNet')); ?>
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
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
    <!-- /.col-lg-12 -->
</div>
                <!-- /.row -->
            
