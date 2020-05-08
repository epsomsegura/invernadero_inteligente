$(document).ready(function () {
    
       
    {
        $("#tabs").tabs();
        $("#tabs").tabs("option", {
            "selected": 0,
            "disabled": [0, 1, 2, 3]
        });






        $("input[type=checkbox]").click(function () {
            if ($(this).is(':checked')) {
                $('#tabs').tabs("enable", $(this).val());
                $('#tabs').tabs("select", $(this).val());
            }
            else {
                $('#tabs').tabs("disable", $(this).val());

                var number = parseInt($(this).val());
                if (number > 0) {
                    number.toString();
                    $('#tabs').tabs("select", "" + number + "");
                    --number;
                } else {
                    $('#tabs').tabs("select", "0");
                }

            }
//             $('input:checkbox').change(function () {
//            if ($(this).is(":checked")) {
//                $("div[id^='tabs']").addClass("ui-state-enable");
//            }
//            else {
//                $("div[id^='tabs']").addClass("ui-state-disabled");
//            }
//        });
        });
    }
});