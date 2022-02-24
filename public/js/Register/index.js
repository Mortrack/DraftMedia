$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let Link_PoliticasPrivacidad = $('#PoliticasPrivacidad-Link'),
        firstname_input = $('#firstname-input'),
        lastname_input = $('#lastname-input'),
        email_input = $('#email-input'),
        password1_input = $('#password1-input'),
        password2_input = $('#password2-input'),
        passwordSecurityLevel_text = $('#password_security-level'),
        privacyPolitics_checkbox = $('#customCheckRegister-checkbox'),
        register_btn = $('#registerAccount'),
        errorHtml = "",
        errors_container = $('#errors-container'),
        registerModal = $('#registerModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    Link_PoliticasPrivacidad.attr("href", APP_URL + URL_PRIVACYPOLITICS);


// -------------------------- //
// ----- REGISTER MODAL ----- //
// -------------------------- //
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }
    register_btn.on('click', function() {
        errors_container.empty();
        errors_container.css({'display':'none'});
        errorHtml = "";
        if (firstname_input.val() == '' || firstname_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa tu(s) nombre(s)</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your name(s)</li>';
            }
        }
        if (lastname_input.val() == '' || lastname_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa tu(s) Apellido(s)</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your Last Name</li>';
            }
        }
        if (email_input.val() == '' || email_input.val().match(/[ ]+/)!=null || email_input.val() == null || email_input.val().match('[(a-z)(A-Z)(0-9)]+\@[(a-z)(A-Z)(0-9)]+\.[(a-z)(A-Z)(0-9)]+[^ ]+') == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el correo</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your email</li>';
            }
        }
        if (password1_input.val() == ''|| password1_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor ingresa tu contraseña en los dos casilleros corrrespondientes</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please enter your password in both input-boxes.</li>';
            }
        }
        if (password2_input.val() == ''|| password2_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor ingresa tu contraseña en los dos casilleros corrrespondientes</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please enter your password in both input-boxes.</li>';
            }
        }
        if (!privacyPolitics_checkbox.is(":checked")) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor Acepta las Políticas de Privacidad</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please accept the Privacy Politics</li>';
            }
        }
        if (errorHtml == "") {
            $.post(
                '/Register/ajaxReceiveRegisterForm',
                {
                    firstname_input:firstname_input.val(),
                    lastname_input:lastname_input.val(),
                    email_input:email_input.val(),
                    password1_input:password1_input.val(),
                    password2_input:password2_input.val(),
                    privacyPolitics_checkbox:privacyPolitics_checkbox.is(":checked")
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 201) {
                        //modal de exito
                        registerModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        registerModal.addClass('show');
                        if (language=='spanish') {
                            modalTitle.append("PROCESO EXITOSO").addClass('text-success');
                        }
                        if (language=='english') {
                            modalTitle.append("PROCESS SUCCESSFUL").addClass('text-success');
                        }
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-ok-100.png"/>');
                        modalGotIt.addClass('btn-success');
                    } else {
                        //modal de error
                        registerModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        registerModal.addClass('show');
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
    });

    // ----- Close modal and reset its content on close-button click ----- //
    modalClose.on('click', function() {
        modalClose.modal('toggle');
        registerModal.removeClass('show');
        registerModal.removeAttr('style');
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
        registerModal.removeClass('show');
        registerModal.removeAttr('style');
        modalTitle.empty();
        modalTitle.removeClass('text-success');
        modalTitle.removeClass('text-danger');
        modalMessage.empty();
        modalIcon.empty();
        modalGotIt.removeClass('btn-success');
        modalGotIt.removeClass('btn-danger');
    });

    password1_input.on('keyup', function() {
            if ((password1_input.val().length <= 6) && (password2_input.val().length <= 6)) {
                passwordSecurityLevel_text.removeClass('text-success');
                passwordSecurityLevel_text.removeClass('text-warning');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("debil");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("weak");
                }
                passwordSecurityLevel_text.addClass('text-danger');
            }
            if ((password1_input.val().length >6) && (password1_input.val().length <=10) && (password2_input.val().length >6) && (password2_input.val().length <=10)) {
                passwordSecurityLevel_text.removeClass('text-success');
                passwordSecurityLevel_text.removeClass('text-danger');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("moderada");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("moderate");
                }
                passwordSecurityLevel_text.addClass('text-warning');
            }
            if ((password1_input.val().length > 10) && (password2_input.val().length > 10)) {
                passwordSecurityLevel_text.removeClass('text-warning');
                passwordSecurityLevel_text.removeClass('text-danger');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("fuerte");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("strong");
                }
                passwordSecurityLevel_text.addClass('text-success');
            }
    });
    password2_input.on('keyup', function() {
            if ((password1_input.val().length <= 6) && (password2_input.val().length <= 6)) {
                passwordSecurityLevel_text.removeClass('text-success');
                passwordSecurityLevel_text.removeClass('text-warning');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("debil");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("weak");
                }
                passwordSecurityLevel_text.addClass('text-danger');
            }
            if ((password1_input.val().length >6) && (password1_input.val().length <=10) && (password2_input.val().length >6) && (password2_input.val().length <=10)) {
                passwordSecurityLevel_text.removeClass('text-success');
                passwordSecurityLevel_text.removeClass('text-danger');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("moderada");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("moderate");
                }
                passwordSecurityLevel_text.addClass('text-warning');
            }
            if ((password1_input.val().length > 10) && (password2_input.val().length > 10)) {
                passwordSecurityLevel_text.removeClass('text-warning');
                passwordSecurityLevel_text.removeClass('text-danger');
                passwordSecurityLevel_text.empty();
                if (language=='spanish') {
                    passwordSecurityLevel_text.append("fuerte");
                }
                if (language=='english') {
                    passwordSecurityLevel_text.append("strong");
                }
                passwordSecurityLevel_text.addClass('text-success');
            }
    });


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/Register/ajaxRegisterIndexVisits',
        {
        },
        function (response) {
        }
    );
    //OBSERVACIONES: contabilizar el tiempo de visita de los usuarios de esta manera,
    //funciona pero hace un poco lento el cambio de una vista a otra del sitio web.
    //Sin embargo, las funcionalidades propias de la vista actual no se ven afectadas
    //en velocidad.
    setInterval(function() {
        $.post(
            '/Register/ajaxRegisterIndexTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente


// -------------------------------------------- //
// ----- FUNCTIONS USED FOR THIS .JS FILE ----- //
// -------------------------------------------- //
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
