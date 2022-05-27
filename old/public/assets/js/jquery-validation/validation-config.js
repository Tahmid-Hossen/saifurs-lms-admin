if (typeof $.validator === 'function') {

    //default proof
    var proof = null;
    var fileSize = 0;


//Set Template for Error Validation
    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "help-block",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element bs4
            error.addClass("error help-block");
            var elementContainer = element.closest(".form-group").find("span.text-danger");
            if (elementContainer) {
                elementContainer.replaceWith(error);
            } else {
                element.next("span").replaceWith(error);
            }
        },
        highlight: function (element) {
            var label = $(element).closest(".form-group");
            label.find("i.fa").remove();
            label.addClass("has-error").removeClass("has-success")
                .prepend("<i class=\"fa fa-times-circle\" style=\"color: #dd4b39\"></i>");
        },
        unhighlight: function (element) {
            var label = $(element).closest(".form-group");
            label.find("i.fa").remove();
            label.addClass("has-success").removeClass("has-error")
                .prepend("<i class=\"fa fa-check\" style=\"color: #00a65a\"></i>");
        }
    });
    //regex match method
    $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input.(Invalid Format)"
    );

    //name match method
    $.validator.addMethod("nametitle", function (value, element) {
            return this.optional(element) || /[a-zA-Z0-9\.\- ]+$/.test(value);
        },
        "Please enter only alphabets and spaces."
    );
    //Branch name
    $.validator.addMethod("branchtitle", function (value, element) {
            return this.optional(element) || /[a-zA-Z0-9\.\- ]+$/.test(value);
        },
        "Please enter only alphabets number, Hyphen(-) and spaces."
    );
    //Advanced Email Validation
    $.validator.addMethod("emailadvance", function (value, element) {
            return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
        },
        "Invalid Email Address"
    );

    //mobile number match method
    $.validator.addMethod("mobilenumber", function (value, element) {
            return this.optional(element) || /^01[0-9]{9}$/.test(value);
        },
        "Please enter value on this 01XXXXXXXXX format."
    );

    //applicant's id & password match method
    $.validator.addMethod("credential", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]{8,10}$/.test(value);
        },
        "Please enter only alphabet and numbers."
    );

    $.validator.addMethod("filesize", function (value, element) {
            return !!(this.optional(element) || (value < 50 || value > 1000));
        },
        "Please enter file size between 50 kb to 1000 kb"
    );

    $.validator.addMethod("noSpace", function (value, element) {
            return this.optional(element) || value.indexOf(" ") < 0 && value.length >= 1;
        },
        "No space please and don't leave it empty"
    );

    $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\-\.]+$/i.test(value);
        },
        "Letters, numbers, hyphen sign and dot only please"
    );

    //@TODO current message set to 8 MB need some improvements
    $.validator.addMethod("videofilesize", function (value, element, param) {
            //console.log(element.files[0].size);
            return this.optional(element) || (element.files[0].size <= param);
        },
        "Upload Max File Size Limit 8MB. Try another file."
    );

    //AJAx Based Unique user name confirm
    /**
     * @param value inout field value
     * @param element input field
     * @param id user id for edit except purpose
     */
    $.validator.addMethod('uniqueusername', function (value, element, id) {
        $.post(USERNAME_FIND_URL, {username: value, _token: CSRF_TOKEN, user_id: id}, function (response) {
            if (response.status == 200)
                proof = response.data;
            else
                proof = false;
        }, 'json');
        return this.optional(element) || proof;

    }, "Username already taken, Try another one");

    /**
     * @param value inout field value
     * @param element input field
     * @param id user id for edit except purpose
     */
    $.validator.addMethod('uniqueemail', function (value, element, id) {
        $.post(EMAIL_FIND_URL, {email: value, user_id: id, _token: CSRF_TOKEN}, function (response) {
            if (response.status == 200)
                proof = response.data;
            else
                proof = false;
        }, 'json');
        return this.optional(element) || proof;

    }, "Email Address already taken, Try another one");

    /**
     * @param value inout field value
     * @param element input field
     * @param paramDate max date limit
     */
    $.validator.addMethod("maxDate", function (value, element, paramDate = null) {

        var inputDate  = new Date(value);
        var compareDate = new Date(paramDate);

        return this.optional(element) || (new Date(value) <= new Date(paramDate));
    }, "Input date cannot be greater then current date.");

    /**
     * @param value inout field value
     * @param element input field
     * @param paramDate max date limit
     */
    $.validator.addMethod("minDate", function (value, element, paramDate = null) {

        var inputDate  = new Date(value);
        var compareDate = new Date(paramDate);
        return this.optional(element) || (inputDate >= compareDate);
    }, "Input date cannot be smaller then birth date.");
}


// Validation Type
function fileTypeValidation(fileType) {
    if (fileType != 'image/png' && fileType != 'image/jpg' &&
        fileType != 'image/gif' && fileType != 'image/jpeg') {

        return {
            "status": false,
            "error": "<b>Invalid File Type (" + fileType + ")</b>. Allowed (.jpg, .png, .gif)."
        };
    } else {
        return {
            "status": true,
            "error": "<b>Valid File Type (" + fileType + ")</b>."
        };
    }
}

// Validation Size
function fileSizeValidation(fileSize, minSize, maxSize) {
    if (fileSize < minSize || fileSize > maxSize) {
        return {
            "status": false,
            "error": "<b>Invalid File Size( " + fileSize.toFixed(2) + " kb)</b>." +
                " Allowed between " + minSize + " kb to " + maxSize + " kb"
        };
    } else
        return {
            "status": true,
            "error": "<b>Valid File Size (" + fileSize + "kb)</b>."
        };
}

// Resolution Validation
function imageResolutionValidation(imgWidth, imgHeight, minWidth, minHeight, maxWidth, maxHeight, stdRatio) {
    var ratio = (imgWidth / imgHeight).toPrecision(3);
    /* Maximum Width */
    if (imgWidth > maxWidth || imgHeight > maxHeight) {
        return {
            "status": false,
            "error": "<b>Invalid Resolution( Width: " + imgWidth + " px , Height: " + imgHeight + "px )</b>." +
                " Allowed maximum width: " + maxWidth + "px , height: " + maxHeight + "px."
        }

    }
    /* Minimum Width */
    else if (imgWidth < minWidth || imgHeight < minHeight) {
        return {
            "status": false,
            "error": "<b>Invalid Resolution( Width: " + imgWidth + " px , Height: " + imgHeight + "px )</b>." +
                " Allowed minimum width: " + minWidth + "px , height:  " + minHeight + "px."
        }
    }
    /* Image Ratio */
    else if (ratio != stdRatio) {
        return {
            "status": false,
            "error": "<b>Invalid Image Scale ( Ratio: " + ratio + " )</b>." +
                " Allowed Ratio Scale of " + stdRatio + "."
        };

    } else {
        return {
            "status": true,
            "error": "<b>Image Validation Successful.</b>"
        };
    }
}
