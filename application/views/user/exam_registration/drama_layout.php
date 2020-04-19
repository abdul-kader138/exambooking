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
            <label for="type">Time & Venue</label>
            <div class="form-line">
                <?php
                $time_venue_list[''] = '-- Please select Time & Venue--';
                foreach ($time_venues as $time_venue_obj) {
                    $time_venue_list[$time_venue_obj->id] = $time_venue_obj->time_venue;
                }
                echo form_dropdown('time_venue', $time_venue_list, "", 'id="time_venue" class="form-control show-tick select"  required="required"" ');
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="group_name">Group name</label>
            <div class="form-line">
                <input type="text" name="group_name" class="form-control" required
                       placeholder="please enter group name"/>
            </div>
            <br>
            <label for="type" id="d_grade">Grade</label>
            <div class="form-line">
                <select class="form-control show-tick" required name="grade" id="grade">
                    <option value="">-- Please select Grade--</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" id="d_type">Categories</label>
            <div class="form-line">
                <select class="form-control show-tick" required name="instrument" id="instrument">
                    <option value="">-- Please select Categories--</option>
                </select>
            </div>
            <br>
            <label for="last_name">Exam Suite</label>
            <div class="form-line">
                <input type="text" name="exam_suite" class="form-control" readonly  id="exam_suite"/>
            </div>
        </div>
    </div>
</div>

<div class="common row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="fees">Fees</label>
            <div class="form-line">
                <input type="hidden" name="fees_val" id="fees_val">
                <input type="text" name="fees" id="fees" readonly class="form-control" required placeholder=""/>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="voucher_code">Voucher Code</label>
            <div class="form-line">
                <input type="text" name="voucher_code" class="form-control" placeholder="please enter voucher code"/>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $('#type').change(function () {

        var exam_types = $('#exam_type').val();
        var exam_type_types = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_types'); ?>",
            data: {exam_type: exam_types, exam_type_type: exam_type_types},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#instrument").empty();
                $("#instrument").append('<option value="">-- Please select Instrument--</option>');
                $.each(states, function (index, key) {
                    $("#instrument").append('<option value=' + key.id + '>' + key.instrument_name + '</option>');

                });
                $("#instrument").selectpicker('refresh');
            },
        });
    });

    $('#instrument').change(function () {
        $("#exam_suite").val('');
        $("#fees").val('');
        var exam_type_types = $('#exam_type').val();
        var types = $('#type').val();
        var instruments = $(this).val();
        var d_grade = (types == '2' ? 'Diploma' : 'Grade');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_grade'); ?>",
            data: {exam_type_type: types,instrument:instruments},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#d_grade").text(d_grade);
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
</script>
