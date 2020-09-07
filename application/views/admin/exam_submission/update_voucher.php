<style type="text/css">
    #file-upload {
        position: absolute;
        left: -9999px;
    }
    a:hover {
        background-color: white;
        color: white;
    }
    label[for="file-upload"] {
        padding: 1em;
        display: inline-block;
        background: #064D06;
        color: #fff;
        cursor: pointer;

    &
    :hover {
        color: #fff
    }

    }
    .btn-upload {
        padding: 1em;
        display: inline-block;
        background: #011401;
        color: #fff;
        cursor: pointer;
        margin-left: -5px;
        border: 0;
    }

    #filename {
        padding: 1em;
        float: left;
        width: 380px;
        white-space: nowrap;
        overflow: hidden;
        color: #fff;
        background: #3c763d;
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Create Voucher (From XLS)
                </h2>
            </div>
            <div class="body">
                <!-- Upload  -->
                <?php if (!empty($error)):
                    echo '<span class="alert alert-danger" style="display: block;">';
                    foreach ($error as $item => $value):?>
                        <?php echo $item; ?>: <?php echo $value; ?>
                    <?php endforeach;
                    echo '</span>'; endif; ?>
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="well well-sm">
                        <a href="<?php echo base_url('files/csv/sample_voucher_update.csv'); ?>"
                           class="btn-upload pull-right" style="background-color: #3c763d">Download Sample
                            File</a>
                        <span class="text-warning">The first line in downloaded csv file should remain as it is. Please do not change the order of columns.
The correct column order is ( Voucher Code, Fee ) & you must follow this.</span>
                        <br>
                        <br>
                        <br>
                        <div class="clearfix"></div>
                        <div>
                            <?php echo form_open_multipart('admin/exam_registration/update_voucher'); ?>
                            <span id="filename">Select File:</span>
                            <label for="file-upload">Browse<input type="file" name="userfile" id="file-upload"></label>
                            <input type="submit" name="submit" value="Upload" class="btn-upload"/>
                            <p>
                                <medim class="text-success">Allowed Types: Microsoft XLS (csv) only </medim>
                            </p>

                            <?php echo form_close(); ?>

                            <?php if (!empty($upload_data)):
                                echo '<br><h3>Uploaded File Detail: </h3>';
                                foreach ($upload_data as $item => $value):?>
                                    <li><?php echo $item; ?>: <?php echo $value; ?></li>
                                <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#file-upload').change(function () {
        var filepath = this.value;
        var m = filepath.match(/([^\/\\]+)$/);
        var filename = m[1];
        $('#filename').html(filename);

    });
    $("#update_voucher").addClass('active');
</script>