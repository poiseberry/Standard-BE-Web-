<!-- Delete Modal -->
<div class="modal fade" id="modal_delete_listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this entries?<br><br>
                <b class="red">This action cannot be undone</b>
            </div>
            <div class="modal-footer">
                <form id="modal_delete_form_id" method="post">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="modal_delete_button" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

<!-- REQUIRED JS SCRIPTS -->
<script src="js/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- Plugins -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/notie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="js/formValidation.min.js"></script>
<script src="js/framework/bootstrap.min.js"></script>
<script src="js/jquery.alphanum.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script src="js/bootstrap.colorpickersliders.js"></script>
<script src="http:////cdnjs.cloudflare.com/ajax/libs/tinycolor/0.11.1/tinycolor.min.js"></script>
<script src="plugins/selectpicker/bootstrap-select.min.js"></script>
<script src="js/html.sortable.src.js"></script>
<script src="js/html.sortable.angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<!-- iCheck -->
<script>
    $(function () {
        $('input[name="status"]').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });

        $('.editor').summernote({
            height: 200,
            callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font',  ['strikethrough', 'superscript', 'subscript','fontname','fontsize','clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph','height']],
                ['insert', ['link', 'picture','video', 'hr','table']],
                ['view', ['undo','redo','fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });

        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "include/summernote.php",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $('.editor').summernote('editor.insertImage', url);
                }
            });
        }

        $('.selectpicker').selectpicker({
            liveSearch:true
        });

        $(".date").datetimepicker({
            format: "YYYY-MM-DD"
        });

        $(".datetime").datetimepicker({
            format:"YYYY-MM-DD H:mm:ss"
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $("form").formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                new_password: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });

        $("#file").fileinput({
            showRemove:false,
            showUpload:false,
            showCancel:false,
            maxFileCount:1,
            maxFileSize:25000
        });

        $(".alpha").alphanum({
            allowSpace: true,
            allowNewline: false,
            allowNumeric: false,
            allowUpper: true,
            allowLower: true,
            allowCaseless: true,
            allowOtherCharSets: false,
        });

        $(".number").alphanum({
            allowSpace: false,
            allowNewline: false,
            allowNumeric: true,
            allowUpper: false,
            allowLower: false,
            allowCaseless: true,
            allowOtherCharSets: false,
        });

        $('input').attr('autocomplete','off');

        $('#banner .owl-carousel').owlCarousel({
            items: 1,
            autoHeight: true,
            loop: true,
            dots: true,
            nav: false,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        });

        <?if(!preg_match("/listing/",$_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=""){?>

        <?if($type=="new" && $return=="success"){?>
        notie.alert(1, 'Successfully Added',1);
        <?}else if($type=="edit" && $return=="success"){?>
        notie.alert(1, 'Successfully Edited',1);
        <?}?>

        <?if($success_message!=""){?>
        notie.alert(1, '<?=$success_message?>',3);
        <?}else if($fail_message!=""){?>
        notie.alert(3, '<?=$fail_message?>',3);
        <?}?>

        <?}?>
    });

    function modal_delete_listing(folder, pkid) {
        $("#modal_delete_button").attr('onclick', 'ajax_delete_listing("' + folder + '","' + pkid + '")');
        $("#modal_delete_listing").modal('show');
    }

    function ajax_delete_listing(folder, pkid) {
        $("modal_delete_button").html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
                method: "POST",
                url: folder + "/listing.php",
                data: {method: "delete_listing", pkid: pkid},
            })
            .done(function (data) {
                $("#modal_delete_listing").modal('hide');
                $("#row_listing_"+pkid).hide('500');
                $("modal_delete_button").html('Delete');
                table.ajax.reload(null,false);
                notie.alert(1, 'Successfully Deleted',1);
            });
    }
</script>
