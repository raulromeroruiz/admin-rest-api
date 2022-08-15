<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrador de contenidos</title>
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, initial-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/admin.css">

    <script src="<?php echo base_url();?>bootstrap/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
    <!-- Table -->
    <script src="<?php echo base_url();?>bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.file-input.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap-filestyle.min.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/tinymce3/jquery.tinymce.js"></script>
    
    <script>
    $(document).ready(function() {
        <?php 
        $notable = array(
            "secciones",
            "contenidos",
            "banners",
            "noticias"
        );
        if (!in_array($this->uri->segment(2), $notable)) { ?>
        $('#mytable').dataTable();
        <?php } ?>

        $("#mytable #checkall").click(function () {
            if ($("#mytable #checkall").is(':checked')) {
                $("#mytable input[type=checkbox]").each(function () {
                    $(this).prop("checked", true);
                });

            } else {
                $("#mytable input[type=checkbox]").each(function () {
                    $(this).prop("checked", false);
                });
            }
        });
        
        $("[data-toggle=tooltip]").tooltip();
    });
    </script>
</head>
<body>
    <div class="loader"></div>
    <?php require_once('nav.php'); ?>