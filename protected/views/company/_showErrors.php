<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/plugins/datatables/dataTables.bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/jquery.dataTables.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/plugins/datatables/dataTables.bootstrap.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile("https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Company/Companyaudit.js",CClientScript::POS_END);
?>
<?php
/* @var $this CompanyController */

$this->breadcrumbs=array(
	'Company',
);
//echo $this->breadcrumbs[0];
?>           
<div class="row" id="divShowErrors">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="dataTableShowErrors" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Created</th>
                                <th>Id</th>
                                <th>Audit Request</th>
                                <th>User</th>
                                <th>Hash</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Error code</th>
                                <th>Message</th>
                                <th>File</th>
                                <th>Line</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
</div>