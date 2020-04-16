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
</div>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" id="l_type">Instrument</label>
            <div class="form-line">
                <select class="form-control show-tick" name="instrument" id="instrument">
                    <option value="">-- Please select Instrument--</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" id="l_grade">Grade</label>
            <div class="form-line">
                <select class="form-control show-tick" name="grade" id="grade">
                    <option value="">-- Please select Grade--</option>
                </select>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="exam_suite">Exam Suite</label>
            <div class="form-line">
                <select class="form-control show-tick" name="exam_suite" id="exam_suite">
                    <option value="">-- Please select Exam Suite--</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="fees">Fees</label>
            <div class="form-line">
                <input type="text" name="fees" class="form-control" required placeholder=""/>
            </div>
        </div>
    </div>
</div>
<div class="common row clearfix">
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
        $("#instrument").selectpicker('refresh');
        $("#grade").selectpicker('refresh');
        $("#exam_suite").selectpicker('refresh');

        var exam_types = $('#exam_type').val();
        var exam_type_types = $(this).val();
        var l_type = (exam_type_types == '3' ? 'Product Name' : 'Instrument');
        var l_grade = (exam_type_types == '2' ? 'Diploma' : 'Grade');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_types'); ?>",
            data: {exam_type: exam_types, exam_type_type: exam_type_types},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#l_type").text(l_type);
                $("#instrument").empty();
                $("#instrument").append('<option value="">-- Please Select Instrument--</option>');
                $.each(states, function (index, key) {
                    $("#instrument").append('<option value=' + key.id + '>' + key.instrument_name + '</option>');

                });
                $("#instrument").selectpicker('refresh');
            },
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_type_grade'); ?>",
            data: {exam_type_type: exam_type_types},
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
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/exam_registration/get_exam_suite'); ?>",
            data: {exam_type_type: exam_type_types},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#l_type").text(l_type);
                $("#exam_suite").empty();
                $("#exam_suite").append('<option value="">-- Please Select Exam Suite--</option>');
                $.each(states, function (index, key) {
                    $("#exam_suite").append('<option value=' + key.id + '>' + key.name + '</option>');

                });
                $("#exam_suite").selectpicker('refresh');
            },
        });
    });
</script>
