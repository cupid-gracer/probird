// Class definition

var KTFormWidgetsValidation = function () {
    // Private functions
    var validator;

    var _initWidgets = function() {
        // Initialize Plugins

        // Daterangepicker
        $('#kt_daterangepicker').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-light-primary',
            timePicker:true,
            timePicker24Hour:true,
            timePickerSeconds:true,
            maxDate: new Date(),
            maxSpan:{"days": 6},
            minYear:2021,
        }, function(start, end, label) {
            var input = $('#kt_daterangepicker').find('.form-control');
            var is_range = ((end-start) - (7 * 24 * 3600 * 1000)  )< 0

            if(is_range){
                $('#from_datepicker').val(start.format('YYYY-MM-DD'));
                $('#timepicker_from').val(start.format(' HH:mm:ss'));
                $('#to_datepicker').val(end.format('YYYY-MM-DD'));
                $('#timepicker_to').val(end.format(' HH:mm:ss'));
                input.val( start.format('YYYY-MM-DD.HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD.HH:mm:ss'));
            }
            else toastr.warning("Le volume de données maximal téléchargeable en une seule selection est d'une semaine!");
            // Revalidate field
            // validator.revalidateField('daterangepicker');
        });

        $('#kt_daterangepicker2').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-light-primary',
            timePicker:true,
            timePicker24Hour:true,
            timePickerSeconds:true,
            maxDate: new Date(),
            maxSpan:{"days": 6},
            minYear:2021,
        }, function(start, end, label) {
            var input = $('#kt_daterangepicker2').find('.form-control');
            var is_range = ((end-start) - (7 * 24 * 3600 * 1000)  )< 0

            if(is_range){
                $('#from_datepicker').val(start.format('YYYY-MM-DD'));
                $('#timepicker_from').val(start.format(' HH:mm:ss'));
                $('#to_datepicker').val(end.format('YYYY-MM-DD'));
                $('#timepicker_to').val(end.format(' HH:mm:ss'));
                input.val( start.format('YYYY-MM-DD.HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD.HH:mm:ss'));
            }
            else toastr.warning("Le volume de données maximal téléchargeable en une seule selection est d'une semaine!");
            // Revalidate field
            // validator.revalidateField('daterangepicker');
        });

    }

    var _initValidation = function () {
        // Validation Rules
        validator = FormValidation.formValidation(
            document.getElementById('DownloadFormID'),
            {
                fields: {
                    daterangepicker: {
                        validators: {
                            notEmpty: {
                                message: 'Daterange is required'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        );
    }

    return {
        // public functions
        init: function() {
            _initWidgets();
            _initValidation();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormWidgetsValidation.init();
});
