$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let email_input = $('#email-input'),
        password1_input = $('#password-input'),
        Login_Btn = $('#Login-btn'),
        errors_container = $('#errors-container'),
        errorHtml = "",
        loginModal = $('#loginModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt');
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }

// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //


// ------------------------ //
// ----- STYLES FIXES ----- //
// ------------------------ //


// -------------------------------------- //
// ----- LOGIN MODAL: LOGIN PROCESS ----- //
// -------------------------------------- //
    Login_Btn.on('click', function() {
        login();
    });
    $(document).on("keydown", function(event) {
        if(event.which == 13) {
            login();
        }
    });

    // ----- Close modal and reset its content on close-button click ----- //
    modalClose.on('click', function() {
        modalClose.modal('toggle');
        loginModal.removeClass('show');
        loginModal.removeAttr('style');
        modalTitle.empty();
        modalTitle.removeClass('text-success');
        modalTitle.removeClass('text-danger');
        modalMessage.empty();
        modalIcon.empty();
        modalGotIt.removeClass('btn-success');
        modalGotIt.removeClass('btn-danger');
    });
    // ----- Close modal and reset its content on GotIt-button click ----- //
    modalGotIt.on('click', function() {
        modalClose.modal('toggle');
        loginModal.removeClass('show');
        loginModal.removeAttr('style');
        modalTitle.empty();
        modalTitle.removeClass('text-success');
        modalTitle.removeClass('text-danger');
        modalMessage.empty();
        modalIcon.empty();
        modalGotIt.removeClass('btn-success');
        modalGotIt.removeClass('btn-danger');
    });


// -------------------------------------------- //
// ----- FUNCTIONS USED FOR THIS .JS FILE ----- //
// -------------------------------------------- //
    /**
     * This function is in charge of executing the validation process and also of executing the
     * corresponding process for the log in of a user by sending to a php controller the data of
     * the log in form.
     *
     * @return void
     *
     * @author Miranda Meza César
     * DATE November 24, 2018
     */
    function login() {
        errors_container.empty();
        errors_container.css({'display':'none'});
        errorHtml = "";
        if (email_input.val() == '' || email_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el correo</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete the email</li>';
            }
        }
        if (password1_input.val() == '' || password1_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor ingresa tu contraseña</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please enter your password</li>';
            }
        }
        if (errorHtml == "") {
            $.post(
                '/Admin/Login/ajaxLogin',
                {
                    email_input:email_input.val(),
                    password_input:password1_input.val()
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 202) {
                        //modal de exito
                        loginModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        loginModal.addClass('show');
                        if (language=='spanish') {
                            modalTitle.append("PROCESO EXITOSO").addClass('text-success');
                        }
                        if (language=='english') {
                            modalTitle.append("PROCESS SUCCESSFUL").addClass('text-success');
                        }
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-ok-100.png"/>');
                        modalGotIt.addClass('btn-success');
                        window.location = APP_URL + URL_AdminSummary;
                    } else {
                        //modal de error
                        loginModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        loginModal.addClass('show');
                        modalTitle.append("ERROR").addClass('text-danger');
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-error-100.png"/>');
                        modalGotIt.addClass('btn-danger');
                    }
                }
            );
        } else {
            errors_container.append(errorHtml);
        }
    }

    /**
     * This function is in charge of retrieving the value of an specific browser cookie.
     *
     * @return string
     *
     * @author Miranda Meza César
     * DATE November 25, 2018
     */
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
});
