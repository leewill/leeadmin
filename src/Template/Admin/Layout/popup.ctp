<?php
    $this->append('importCss');
    echo $this->element('Admin/Common/Css/common');
    $this->end();
?>
<?php $this->append('pageStyle'); ?>
<style type="text/css">
.right-side {
    margin-left:0px;
}
</style>
<?php $this->end(); ?>
<!DOCTYPE html>
<html>
    <head>
<?php echo $this->element('Admin/Common/head'); ?>
    </head>
    <body class="skin-blue">
        <div class="wrapper row-offcanvas row-offcanvas-left">
<?php echo $this->element('Admin/Common/right_side'); ?>
        </div>
<?php echo $this->element('Admin/Common/Script/common'); ?>
    </body>
</html>
