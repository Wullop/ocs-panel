<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<footer id="site-footer" role="contentinfo">
	</footer><!-- #site-footer -->

	<!-- js -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.0/metisMenu.min.js"></script>
	<script src="<?= base_url('asset/js/sb-admin-2.js') ?>"></script>
	<script src="<?= base_url('asset/js/bootstrap-datepicker.min.js') ?>"></script>
	<script src="<?= base_url('asset/js/bootstrap-dialog.min.js') ?>"></script>
		 <script type="text/javascript">
        $('.input-group.date').datepicker({
            format: "yyyy/mm/dd",
            weekStart: 1,
            clearBtn: true,
            language: "id",
            autoclose: true,
            todayHighlight: true
        });
        $('.hapus').click(function(e) {
            e.preventDefault();
            BootstrapDialog.confirm({
                title: 'Confirm',
                message: ' Konfirmasi ?',
                type: BootstrapDialog.TYPE_DANGER,
                closable: true,
                btnCancelLabel: 'Batal',
                btnOKLabel: 'Delete',
                btnOKClass: 'btn-danger',
                callback: function(result) {
                    if(result) {
                        location.href = $('.hapus').attr('href');
                    }
                }
            });
        });
        function print_report() {
            window.print();
            return false;
        }
    </script>

</body>
</html>
