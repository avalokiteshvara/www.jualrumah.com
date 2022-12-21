<!DOCTYPE html>
<html class="no-js">

    <!--header.php-->

    <?php include 'header.php'; ?>

    <!--end header.php -->

    <body onload="setFocus()">

        <!--uppermenu.php-->

        <?php include 'uppermenu.php'; ?>

        <!--end uppermenu.php-->


        <div class="container-fluid">
            <div class="row-fluid">

                <?php include 'leftmenu.php' ?>

               <!--START CONTENT-->

                <?php
                    $page_name .= ".php";
                    include $page_name;
                ?>
               <!--END CONTENT-->

                 </div>
            <hr>
            <!-- <footer>
                <p>&copy; Vincent Gabriel 2013</p>
            </footer> -->
        </div>
        <!--/.fluid-container-->
      
        <script src="<?php echo base_url();?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/jquery.uniform.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/bootstrap-datepicker.js"></script>

        <script src="<?php echo base_url();?>assets/admin/vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

        <script src="<?php echo base_url();?>assets/admin/vendors/wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>


        <script src="<?php echo base_url();?>assets/admin/scripts.js"></script>

        <script>
        $(function() {
            $(".datepicker").datepicker();
            $(".uniform_on").uniform();
            $(".chzn-select").chosen();
            $('.textarea').wysihtml5();

            $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#rootwizard').find('.bar').css({width:$percent+'%'});
                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show();
                    $('#rootwizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }
            }});
            $('#rootwizard .finish').click(function() {
                alert('Finished!, Starting over!');
                $('#rootwizard').find("a[href*='tab1']").trigger('click');
            });
        });

        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });

        </script>
    </body>

</html>
