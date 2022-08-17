// Class definition

var KTFormWidgetsValidation = function () {
    // Private functions
    var validator;

    var _initWidgets = function() {
        // Initialize Plugins

        // Daterangepicker
        $('#wt_kt_daterangepicker').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-light-primary',
            timePicker:true,
            timePicker24Hour:true,
            timePickerSeconds:true,
            maxDate: new Date(),
            maxSpan:{"days": 365},
            minYear:2021,
        }, function(start, end, label) {
            var input = $('#wt_kt_daterangepicker').find('.form-control');
            
            let start_time = start.format('YYYY-MM-DD HH:mm:ss');
            let end_time = end.format('YYYY-MM-DD HH:mm:ss');
            input.val( start.format('YYYY-MM-DD.HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD.HH:mm:ss'));
            $('#wt_start_time').val(start_time);
            $('#wt_end_time').val(end_time);
        });

        $('#cam_kt_daterangepicker').daterangepicker({
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
            var input = $('#cam_kt_daterangepicker').find('.form-control');
            let start_time = start.format('YYYY-MM-DD HH:mm:ss');
            let end_time = end.format('YYYY-MM-DD HH:mm:ss');
            input.val( start.format('YYYY-MM-DD.HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD.HH:mm:ss'));
            $('#cam_start_time').val(start_time);
            $('#cam_end_time').val(end_time);
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
