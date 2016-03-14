function checkEmail(email, page) {
    var response = false;
    if (validateEmail(email)) {
        
        $.ajax({
            type: 'POST',
            async: false,
            url: checkEmailSource,
            data: "email=" + email,
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(data) {

                if (data == 'error') {
                    $("#ajaxEmailMsg").removeClass("success").html("Email " + email + " already exists.").addClass("error").show();
                    
                } else {
                    $("#ajaxEmailMsg").removeClass("error").html("Email " + email + " is available.").addClass("success").show();
                    
                    response = true;
                }
            }
        });
    } else {

        $("#ajaxEmailMsg").html("");
    }
    return response;
}

function validateEmail(email) {

    var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    var valid = emailReg.test(email);

    if (!valid) {
        return false;
    } else {
        return true;
    }
}

function checkUsername(username) {
    
    var response = false; 
    
//        if (!username.match("/^[A-Za-z0-9-_!#$]+$/") || username.length < 6)  {
//            $("#ajaxUserMsg").html('').hide();
//            return false;
//        }
                    
        $.ajax({
            type: 'POST',
            async: false,
            url: checkUsernameSource,
            data: "username=" + username,
            beforeSend: function() {
                $("#loaderUser").show();
            },
            success: function(data) {

                if (data == 'error') {

                    $("#ajaxUserMsg").removeClass("success").html("Username " + username + " already exists.").addClass("error").show();
                    
                    response = false;
                } else {
                    $("#ajaxUserMsg").removeClass("error").html("Username " + username + " is available.").addClass("success").show();
                    
                    response = true;
                }
                //$("#loaderUser").hide();
            }
        });
    return response;
}

// check city in admin form..
function checkCity(cityname) {
    
    var response = false; 
                    
        $.ajax({
            type: 'POST',
            async: false,
            url: checkCitySource,
            data: "city=" + cityname,
            beforeSend: function() {
                //$("#loaderUser").show();
            },
            success: function(data) {
                if (data == 'error') {
                    response = false;
                } else {
                   response = true;
                }
            }
        });
    return response;
}

// check city in admin form..
function checkEmailAdmin(email) {
    
    var response = false; 
                    
        $.ajax({
            type: 'POST',
            async: false,
            url: checkEmailSource,
            data: "email=" + email,
            beforeSend: function() {
                //$("#loaderUser").show();
            },
            success: function(data) {
                if (data == 'error') {
                    response = true;
                } else {
                   response = false;
                }
            }
        });
    return response;
}