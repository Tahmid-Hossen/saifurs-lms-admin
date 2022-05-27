/**
 * Image Display Function
 * @param input
 * @param htmlID
 */


function imageIsLoaded(input, htmlID = null) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var classID = 'blah';
        if (htmlID != null) {
            classID = htmlID;
        }

        reader.onload = function (e) {
            document.getElementById(classID).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function initPreloader() {
    /**
     * Preloader Hide
     */
    $('.message').delay(5000).fadeOut('slow');
    $(".loader").fadeOut("slow");
}

/**
 * @param dest target object
 * @param msg default message to display as placeholder
 */
function dropdownCleaner(dest, msg) {
    dest.empty();
    dest.append('<option value="">' + msg + '</option>');
}

/**
 *
 * @param dest target object
 * @param data received data
 * @param id data pointer that will be value
 * @param text data pointer that will be option text
 * @param selected prefill a options
 * @param msg default message to display as placeholder
 */
function dropdownFiller(dest, data, id, text, selected = null, msg = 'Select an option') {

    dropdownCleaner(dest, msg);

    var selectedStatus = "";

    if (data.length > 0) {
        //dest.append('<option value="" ' + selectedStatus + '>Please Select</option>');

        $.each(data, function (key, value) {
            var optionValue = value[id];
            var optionText = value[text];

            if (selected == optionValue)
                selectedStatus = 'selected';

            dest.append('<option value="' + optionValue + '" ' + selectedStatus + '>' + optionText + '</option>');
        });

        //if destination DOM have select 2 init
        if (selectedStatus.length > 3) {
            dest.val(selected);

            if (dest.data('select2-id'))
                dest.trigger('change.select2');
            else
                dest.trigger('change');
        }
    }
}

/**
 *
 * @param src company object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getBranchDropdown(src, dest, selected = null) {

    var srcValue = src.val();

    if (!isNaN(srcValue)) {

        $.post(BRANCH_URL,
            {company_id: srcValue, '_token': CSRF_TOKEN},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'branch_name', selected, 'Please Select Branch');
                } else {
                    dropdownCleaner(dest, 'Please Select Branch');
                }
            }, 'json');
    }
}

/**
 *
 * @param src country object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getStateDropdown(src, dest, selected = null) {
    //var srcValue = src.val();
    var srcValue = 18; //Bangladesh

    if (!isNaN(srcValue)) {

        $.post(STATE_URL,
            {country_id: srcValue, 'state_status': 'ACTIVE', '_token': CSRF_TOKEN},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'state_name', selected, 'Please Select Division');
                } else {
                    dropdownCleaner(dest, 'Please Select Division');
                }
            }, 'json');
    }
}

/**
 *
 * @param country country object
 * @param src country object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getCityDropdown(country, src, dest, selected = null) {
    var countryValue = country.val();
    var srcValue = src.val();
    if (!isNaN(srcValue)) {

        $.post(CITY_URL,
            {country_id: countryValue, state_id: srcValue, 'city_status': 'ACTIVE', '_token': CSRF_TOKEN},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'city_name', selected, 'Please Select City');
                } else {
                    dropdownCleaner(dest, 'Please Select City');
                }
            }, 'json');
    }
}

/**
 *  get Course Category Category Dropdown
 *
 * @param src company object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getCourseCategoryDropdown(src, dest, selected = null) {
    var srcValue = src.val();
    if (!isNaN(srcValue)) {
        $.post(CATEGORY_URL,
            {company_id: srcValue, 'course_category_status': 'ACTIVE', '_token': CSRF_TOKEN},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'course_category_title', selected, 'Please Select Course Category');
                } else {
                    dropdownCleaner(dest, 'Please Select Course Category');
                }
            }, 'json');
    }
}

/**
 *  get Course Sub Category Category Dropdown
 *
 * @param src company object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getSubCategoryDropdown(src, dest, selected = null) {
    var srcValue = src.val();
    if (!isNaN(srcValue)) {
        $.post(SUB_CATEGORY_URL,
            {course_category_id: srcValue, 'course_sub_category_status': 'ACTIVE', '_token': CSRF_TOKEN},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'course_sub_category_title', selected, 'Please Select Sub Category');
                } else {
                    dropdownCleaner(dest, 'Please Select Sub Category');
                }
            }, 'json');
    }
}

/**
 *  get Course Child Category Dropdown
 *
 * @param src company object
 * @param dest dropdown of branch
 * @param selected prefill a options
 */
function getChildCategoryDropdown(src, dest, selected = null) {
    var srcValue = src.val();
    if (!isNaN(srcValue)) {
        $.post(CHILD_CATEGORY_URL,
            {course_sub_category_id: srcValue, '_token': CSRF_TOKEN, course_child_category_status: 'ACTIVE'},
            function (response) {
                if (response.status === 200) {
                    dropdownFiller(dest, response.data, 'id', 'course_child_category_title', selected, 'Please Select Child Category');
                } else {
                    dropdownCleaner(dest, 'Please Select Child Category');
                }
            }, 'json');
    }
}

/**
 * Resize Course navigation Sidebar
 */
function resizeNavbar() {

    var navbar = $("#nav-sidebar");

    if (window.screen.width <= 767)
        navbar.collapse("hide");
    else
        navbar.collapse("show");
}

function customValidationResponse(element, valid = null) {
    var span = $("#" + element + "-error");
    var container = span.closest(".form-group");
    var input = $("#" + element);

    if (valid === true) {
        container.addClass("has-success").removeClass("has-error");
        container.find("i.fa").remove();
        container.find("label").prepend('<i class="fa fa-check" style="color: #00a65a"></i>');
        input.attr("aria-invalid", "false");
    }

    if (valid === false) {
        container.addClass("has-error").removeClass("has-success");
        container.find("i.fa").remove();
        container.find("label").prepend('<i class="fa fa-times-circle" style="color: #dd4b39"></i>');
        input.attr("aria-invalid", "true");
    }
}

function findUserName() {
    $('#username-error').html('<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....');

    var username = $('#username').val() || '';
    var user_id = $('#user_id').val() || '';

    if (username != '') {
        $.ajax({
            type: "POST",
            url: USERNAME_HAVE_FIND_URL,
            dataType: 'json',
            data: {
                'username': username,
                'user_id': user_id,
                '_token': CSRF_TOKEN
            },
            success: function (data) {
                if (data['findUser'] > 0) {
                    customValidationResponse('username', false);
                    $('#username-error').html('<span class="text-danger help-block">Username already have, please provide another username!</span>');
                } else {
                    customValidationResponse('username', true);
                    $('#username-error').html('<span class="text-success">Username available.</span>');
                }
            }
        });
    } else {
        $('#username-error').html('<span class="text-danger help-block">Please provide User ID!</span>');
    }
}

function findEmail() {
    $('#email-error').html('<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....');
    var email = $('#email').val() || '';
    var user_id = $('#user_id').val() || '';
    if (email != '') {
        $.ajax({
            type: "POST",
            url: EMAIL_FIND_URL,
            dataType: 'json',
            data: {
                'email': email,
                'user_id': user_id,
                '_token': CSRF_TOKEN
            },
            success: function (data) {
                if (data['findUser'] > 0) {
                    customValidationResponse('email', false);
                    $('#email-error').html('<span class="text-danger help-block">Email Address already have, please provide another email!</span>');
                } else {
                    customValidationResponse('email', true);
                    $('#email-error').html('<span class="text-success">Email Address available.</span>');
                }
            }
        });
    } else {
        $('#email-error').html('<span class="text-danger help-block">Please provide User email!</span>');
    }
}

function findMobile() {
    $('#mobile_phone').html('<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....');
    var mobile_phone = $('#mobile_phone').val() || '';
    var user_id = $('#user_id').val() || '';
    if (mobile_phone != '') {
        $.ajax({
            type: "POST",
            url: MOBILE_NUMBER_FIND_URL,
            dataType: 'json',
            data: {
                'mobile_number': mobile_phone,
                'user_id': user_id,
                '_token': CSRF_TOKEN
            },
            success: function (data) {
                if (data['findUser'] > 0) {
                    customValidationResponse('mobile_phone', false);
                    $('#mobile_phone-error').html('<span class="text-danger help-block">Mobile Number already have, please provide another mobile_phone!</span>');
                } else {
                    customValidationResponse('mobile_phone', true);
                    $('#mobile_phone-error').html('<span class="text-success">Mobile Number available.</span>');
                }
            }
        });
    } else {
        $('#mobile_phone-error').html('<span class="text-danger help-block">Please provide User Mobile Number!</span>');
    }
}

// To Copy any Clipboard input
function copyLinkFromButton(button_id) {
    var clipboard = new ClipboardJS(button_id);
    clipboard.on('success', function (e) {
        $(e.trigger).attr('title', 'Link Copied').tooltip('fixTitle').tooltip('show');
        e.clearSelection();
        setTimeout(function () {
            $(e.trigger).attr('title', 'Copy Link').tooltip('fixTitle');
        }, 1000);
    });
}

function getUserList() {
    var company_id = $('#company_id').val();
    var branch_id = $('#branch_id').val() || '';
    if (company_id) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: USER_DETAIL_LIST_URL,
            data: {
                company_id: company_id,
                branch_id: branch_id,
                '_token': CSRF_TOKEN
            },
            success: function (res) {
                if (res.status === 200) {
                    $("#user_id").empty();
                    $("#user_id").append('<option value="">Please Select User</option>');
                    $.each(res.data, function (key, value) {
                        if (selected_user_id == value.user_id) {
                            userSelectedStatus = ' selected ';
                        } else {
                            userSelectedStatus = '';
                        }
                        $("#user_id").append('<option value="' + value.user_id + '" ' + userSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
                    });
                } else {
                    $("#user_id").empty();
                    $("#user_id").append('<option value="">Please Select User</option>');
                }
            }
        });
    } else {
        $("#user_id").empty();
        $("#user_id").append('<option value="">Please Select User</option>');
    }
}

/**
 * INIT Application
 */
$(document).ready(function () {
//apply config defaults
    /**
     * Ref: https://github.com/rstaib/jquery-steps/wiki/Settings
     */
    $.extend(true, $.fn.steps.defaults, {
        headerTag: "h3",
        bodyTag: "section",
        autoFocus: true,
        titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
        enableCancelButton: true,
        labels: {
            cancel: '<i class=\'fa fa-times\'></i> <span class=\'text-bold\'> Cancel</span>',
            current: "current step:",
            pagination: "Pagination",
            finish: "<i class=\'fa fa-check\'></i> <span class=\'text-bold\'> Save </span>",
            next: "<span class=\'kt-hidden-mobile text-bold\'> Next </span><i class=\'fa fa-arrow-right\'></i> ",
            previous: "<i class=\'fa fa-arrow-left\'></i> <span class=\'text-bold\'> Previous </span>"
        },
        onCanceled: function (event) {
            window.location.href = PREVIOUS_URL;
        }
    });


    /**
     * Toggle to change two state values
     */
    $(".toggle-class").change(function () {
        var toggle = $(this);

        var fieldData = (toggle.prop("checked") === true)
            ? toggle.data("on")
            : toggle.data("off");

        $.get(TOGGLE_URL, {m: toggle.data("model"), i: toggle.data("id"), f: toggle.data("field"), v: fieldData},
            function (response) {
                if (response.status === 200) {
                    //@TODO add notify popup
                    console.log(response);
                } else {
                    console.log(response);
                }
            }, "json");
    });

    //Date picker
    $(".only_date").daterangepicker({
        buttonClasses: "btn",
        startDate: moment(),
        maxDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: "YYYY-MM-DD"}
    });

    //Date & Time picker
    $(".date-time-picker").daterangepicker({
        buttonClasses: "btn",
        startDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: "YYYY-MM-DD"}
    });

    $(".date_of_birth").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        startDate: moment().subtract(15, "years"),
        endDate: moment(),
        maxDate: moment(),
        locale: {
            format: "YYYY-MM-DD"
        }
    });

    $(".date_of_enrollment").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        endDate: moment().add(1, "years"),
        locale: {
            format: "YYYY-MM-DD"
        }
    });

    //Timepicker
    $(".only_time").timepicker({
        autoclose: true
    });

    //Select2
    $(".select2, .auto_search").select2({
        "width": "100%",
        placeholder: "Select an option"
    });

    //tag created
    $(".tags").select2({
        "width": "100%",
        placeholder: "Select an option",
        tags: true
    });

    //bootstrap WYSIHTML5 - text editor
    $(".editor").wysihtml5({
        toolbar: {
            "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": false, //Button to change color of font
            "blockquote": false, //Blockquote
            "size": "sm" //default: none, other options are xs, sm, lg
        }
    });

    $('a[data-toggle="modal"]').on('click', function () {
        console.log($(this).attr('data-toggle'))
        $.ajax({
            type: 'get',
            url: $(this).attr('href'),
            //data: {id : id},
            async: false,
            dataType: "text",
            success: function (data) {
                $('.modal-content').html(data);
                $('#' + $(this).attr('data-toggle')).modal('show');
            }
        })
        //return false;
    });

    // date and time picker for events
    $("#event_duration, .event_duration").daterangepicker({
        timePicker: true,
        timePickerIncrement: 1,
        locale: {
            format: "YYYY-MM-DD HH:mm:ss"
        }
    });

    //Date range as a button
    $("#daterange-btn").daterangepicker({
            ranges: {
                "Today": [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function (start, end) {
            $('#start_date').val(start.format('YYYY-MM-DD'))
            $('#end_date').val(end.format('YYYY-MM-DD'))
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

        });

    $('[data-toggle="tooltip"]').tooltip();

    //@TODO Select 2 validation UI control
    //@TODO priority LOW
    // IT Does not react to jquery validation aor bootstrap3

    /*    $("select").change(function () {
            var dropdown = $(this);
            if (dropdown.hasClass("select2-hidden-accessible")) {
                var dropdownValue = dropdown.val();
            }
        });

        $(".select2-hidden-accessible").on('change.select2', function (e) {
            var data = e.params.data;
            console.log(e.params);
        });*/


    $('button[type="reset"], input[type="reset"]').click(function () {
        var origin = $(this).closest("form");
        if (origin) {
            //<input />
            origin.find("input").each(function () {
                var element = $(this);
                if (element.attr("type") === 'hidden' || element.attr("type") === 'submit' ||
                    element.attr("type") === 'reset' || element.attr("type") === 'button') {
                    return;
                } else if (element.attr("type") === 'radio' || element.attr("type") === 'checkbox') {
                    element.prop("checked", false);
                } else {
                    element.attr("value", "");
                }
            });
            //<select>
            origin.find("select").each(function () {
                $(this).find("option").each(function () {
                    $(this).removeAttr("selected");
                });
                $(this).find("option:first").prop("selected", true).trigger("change");
            });
        }
    });

    initPreloader();
    resizeNavbar();
});


