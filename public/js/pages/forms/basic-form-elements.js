$(function () {
    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD hh:mm:ss',
        clearButton: true,
        weekStart: 1,
        pickTime:true
        // time: true,
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        year: true,
        time: false
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        date: false
    });
});