<?php ?>
<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type">Type</label>
            <div class="form-line">
                <?php
                $exam_types_list[''] = '-- Please select Type--';
                foreach ($exam_type_types as $exam_type_type) {
                    $exam_types_list[$exam_type_type->id] = $exam_type_type->name;
                }
                echo form_dropdown('type', $exam_types_list, "", 'id="type" class="form-control show-tick select"  required="required"" ');
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type">Date & Venue</label>
            <div class="form-line">
                <div class="form-line">
                    <?php
                    $time_venue_list[''] = '-- Please select Date & Venue--';
                    foreach ($time_venues as $time_venue_obj) {
                        $time_venue_list[$time_venue_obj->id] = $time_venue_obj->time_venue;
                    }
                    echo form_dropdown('time_venue', $time_venue_list, "", 'id="time_venue" class="form-control show-tick select"  required="required"" ');
                    ?>
                </div>
                <div class="form-line" id="time_venue_other_div">
                    <input type="text" name="time_venue_other" id="time_venue_other" class="form-control"
                           placeholder="Please Enter Others Date & Venue"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" id="l_type">Instrument</label>
            <div class="form-line">
                <select class="form-control show-tick" name="instrument" id="instrument" required>
                    <option value="">-- Please select Instrument--</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" id="l_grade">Grade</label>
            <div class="form-line">
                <select class="form-control show-tick" required name="grade" id="grade">
                    <option value="">-- Please select Grade--</option>
                </select>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="last_name">Exam Suite</label>
            <div class="form-line">
                <input type="text" name="exam_suite" class="form-control" readonly id="exam_suite"/>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="fees">Fees</label>
            <div class="form-line">
                <input type="text" name="fees" id="fees" class="form-control" readonly required placeholder=""/>
            </div>
        </div>
    </div>
</div>
<div class="common row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="voucher_code">Voucher Code</label>
            <div class="form-line">
                <input type="text" id="voucher_code" name="voucher_code" class="form-control"
                       placeholder="please enter voucher code"/>
            </div>
            <br>
            <input type="checkbox" style="display: none" id="voucher_apply" class="form-line"/><label
                    for="voucher_apply" style="display: none; font-size: 14px" id="voucher_label_apply"> <b>Voucher
                    Apply</b></label>
            <p id="voucher_apply_details"></p>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        $("#time_venue_other_div").hide();
    });
    $('#type').change(function () {
        $("#exam_suite").val('');
        $("#fees").val('');
        var exam_types = $('#exam_type').val();
        var exam_type_types = $(this).val();
        var l_type = (exam_type_types == '3' ? 'Product Name' : 'Instrument');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_types'); ?>",
            data: {exam_type: exam_types, exam_type_type: exam_type_types},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#l_type").text(l_type);
                $("#instrument").empty();
                $("#grade").empty();
                $("#instrument").append('<option value="">-- Please Select Instrument--</option>');
                $.each(states, function (index, key) {
                    $("#instrument").append('<option value=' + key.id + '>' + key.instrument_name + '</option>');

                });
                $("#instrument").selectpicker('refresh');
                $("#grade").selectpicker('refresh');
            },
        });
    });

    $('#time_venue').change(function () {
        var obj = $("#time_venue option:selected").text();
        if (obj == 'Others') {
            $("#time_venue_other_div").show();
            $('#time_venue_other').val();
            $('#time_venue_other').attr('required', true);
        } else {
            $('#time_venue_other').removeAttr('required');
            $('#time_venue_other').val();
            $("#time_venue_other_div").hide();
        }
    });
    $('#instrument').change(function () {
        $("#exam_suite").val('');
        $("#fees").val('');
        var exam_type_types = $('#exam_type').val();
        var types = $('#type').val();
        var instruments = $(this).val();
        var l_grade = (types == '2' ? 'Diploma' : 'Grade');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_grade'); ?>",
            data: {exam_type_type: types, instrument: instruments},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#l_grade").text(l_grade);
                $("#grade").empty();
                $("#grade").append('<option value="">-- Please Select Grade--</option>');
                $.each(states, function (index, key) {
                    $("#grade").append('<option value=' + key.id + '>' + key.grade_name + '</option>');

                });
                $("#grade").selectpicker('refresh');
            },
        });
    });

    $('#grade').change(function () {
        var instrument = $('#instrument').val();
        var grade = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_suite'); ?>",
            data: {instrument_id: instrument, grade_id: grade},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#exam_suite").val(states.suite_name);
                $("#fees").val(states.fees);
            },
        });
    });

    $('#voucher_apply').click(function () {
        if ($(this).prop('checked') == true) {
            var code = $('#voucher_code').val();
            toastr.options.positionClass = 'toast-bottom-right';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('user/exam_registration/check_voucher_details'); ?>",
                data: {code: code},
                dataType: "json",//return type expected as json
                success: function (states) {
                    if (states.error_info == '') {
                        $('#voucher_apply_details').empty();
                        var label_obj = '<label style="font-size: 13px" class="label label-info" for="voucher_apply_details">Available Discount :' + states.update_status.fee + ' RM</label>'
                        $('#voucher_apply_details').append(label_obj);
                    } else {
                        toastr.error(states.error_info, 'Error');
                        $('#voucher_code').val('');
                        $('#voucher_apply').prop('checked', false);
                        $('#voucher_apply').removeAttr('required');
                        $('#voucher_apply').hide();
                        $('#voucher_label_apply').hide();
                    }
                },
                error: function (error) {
                    toastr.error('Something went wrong,Please contact with system admin', 'Error')
                }
            });
        }
        else {
            if ($('#voucher_code').val() == '' || $('#voucher_code').val() == undefined)
                toastr.error('Please enter voucher code', 'Error');
            $('#voucher_code').val('');
            $('#voucher_apply').removeAttr('required');
            $('#voucher_apply').hide();
            $('#voucher_label_apply').hide();
            $('#voucher_apply_details').empty();
        }
    });
</script>
