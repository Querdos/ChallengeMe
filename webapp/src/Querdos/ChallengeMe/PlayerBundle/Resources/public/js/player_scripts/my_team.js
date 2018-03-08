/**
 * Created by querdos on 3/23/17.
 */

// function to show a notice for non team users
function notifyNoTeam() {
    // TODO @querdos Manage translation for the non team message
    new PNotify({
        title:      'You have no team !',
        text:       'You must be in a team to participate in challenges',
        type:       'info',
        styling:    'bootstrap3'
    });
}

// function to show on the form for team creation
function showFormTeam() {
    $("#form_create_team").slideToggle();
}

// function that set a listener on the changeRole button
function setListenerOnChangeRoleButton() {
    $(".buttonChangeRole").on('click', function() {
        // changing modal title
        $("#titleModalRole").html("Changing role for <b>" + $(this).attr("player_username") + "</b>");

        // setting player id
        $("#selectRole").attr("player_id", $(this).attr("player_id"));
    });
}

// function that set a listener on the change save role button
function setListenerOnSaveRole(url_change_role) {
    $("#saveRoleForPlayer").on('click', function() {
        // retrieving data
        var selectRole  = $("#selectRole");
        var playerId    = selectRole.attr("player_id");
        var roleId      = selectRole.val();

        var data        = { 'playerId': playerId, 'roleId': roleId };

        // sending ajax request
        $.ajax({
            url:    url_change_role,
            type:   "POST",
            data:   data
        }).success(function() {
            location.reload();
        }).error(function() {
            // TODO @querdos: Manage trnaslation for the error on changing a role
            new PNotify({
                title:      'An error occured',
                text:       'An error occured while trying to assign the role. If the error persists, please contact an administrator.',
                type:       'error',
                styling:    'bootstrap3'
            });
        })
    });
}

// function for init datepicker
function datePickerInit() {
    var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
    };

    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
            days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };
    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker(optionSet1, cb);
    $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
    });
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
    });
    $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
    });
}

