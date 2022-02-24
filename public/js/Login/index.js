$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    var container = $('#container'),
        Login_OuterModal = $('#Login-OuterModal'),
        Login_InnerModal = $('#Login-InnerModal'),
        CrearCuenta = $('#crearCuenta'),
        email_input = $('#email-input'),
        password1_input = $('#password-input'),
        rememberMe_checkbox = $('#customCheckLogin'),
        Login_Btn = $('#Login-btn'),
        errors_container = $('#errors-container'),
        errorHtml = "",
        loginModal = $('#loginModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt'),
        OuterModal_Text = $('#OuterModal-Text'),
        resetPassword = $('#reset-password'),
        changeEmail_input = $('#changeEmail-input');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    CrearCuenta.attr("href", APP_URL + URL_Register);

    CrearCuenta.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Register;
    });


// ------------------------ //
// ----- STYLES FIXES ----- //
// ------------------------ //
    let actualHeight,
        LoginHeight,
        navbarHeight,
        desiredTopMargin;

    actualHeight = container.innerHeight();
    LoginHeight = Login_InnerModal.innerHeight();
    navbarHeight = $('#navbar-main').innerHeight();
    desiredTopMargin = ((actualHeight-LoginHeight-navbarHeight)/2);
    if (desiredTopMargin < 0) {
        desiredTopMargin = 0;
    }
    container.css({
        'padding-top':desiredTopMargin,
        'min-height':LoginHeight
    });
    $(window).on('resize', function() {
        actualHeight = container.innerHeight();
        LoginHeight = Login_InnerModal.innerHeight();
        navbarHeight = $('#navbar-main').innerHeight();
        desiredTopMargin = ((actualHeight-LoginHeight-navbarHeight)/2);
        if (desiredTopMargin < 0) {
            desiredTopMargin = 0;
        }
        container.css({
            'padding-top':desiredTopMargin,
            'min-height':LoginHeight
        });
    });


// ------------------------------- //
// ----- LOGIN MODAL EFFECTS ----- //
// ------------------------------- //
    let modalActualWidth = Login_OuterModal.width();
    modalActualWidth = modalActualWidth/2;
    let mAW_100 = modalActualWidth,
        mAW_10 = (modalActualWidth/10);
    loginModalEffect('LOGIN', true);

    // ----- Login modal fixes on monitor width changes ----- //
    let originalDeviceWidth = $(window).width(),
        actualDeviceWidth = $(window).width();
    $(window).on('resize', function() {
        actualDeviceWidth = $(window).width();
        if(!$('body').hasClass("modal-open")) {
            if (actualDeviceWidth != originalDeviceWidth) {
                location.reload();
            }
        }
    });


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


// ----------------------------------------------- //
// ----- LOGIN MODAL: RESET PASSWORD PROCESS ----- //
// ----------------------------------------------- //
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }
    resetPassword.on('click', function() {
        $.post(
            '/Login/ajaxResetPassword',
            {
                email_input:changeEmail_input.val()
            },
            function (response) {
                ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 202) {
                    //Reset process of user's password was successful
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
                } else {
                    //An error ocurred while trying to reset the user's password
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
    });


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/Login/ajaxLoginIndexVisits',
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
            '/Login/ajaxLoginIndexTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente


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
                '/Login/ajaxLogin',
                {
                    email_input:email_input.val(),
                    password_input:password1_input.val(),
                    rememberMe_checkbox:rememberMe_checkbox.is(":checked")
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 202) {
                        //User loged in successfully
                        loginModalEffect('LOGGED IN', false);
                        setTimeout(function(){
                            window.location = APP_URL + URL_Home;
                        }, 2000);
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
     * This function is in charge applying the animation effect of the login modal.
     *
     * @return void
     *
     * @author Miranda Meza César
     * DATE November 25, 2018
     */
    function loginModalEffect($frontModalText, $isLoginProcess) {
        OuterModal_Text.text($frontModalText);
        let animationOrder = null;
        if ($isLoginProcess) {
            animationOrder = [1,2];
        } else {
            OuterModal_Text.css({
                'font-size':'50px',
                'padding-top':'20px'
            });
            animationOrder = [2,1];
        }
        if ($(window).width() >= 768) {
            if ($isLoginProcess) {
                Login_OuterModal.css({
                    'position':'relative',
                    'z-index':'2',
                    'left':mAW_100+'px'
                });
                Login_InnerModal.css({
                    'position':'relative',
                    'z-index':'1',
                    'right':mAW_100+'px'
                });
            }
            setTimeout(function(){
                //Animation part1
                Login_OuterModal.animate({
                    'left':'-'+mAW_10+'px',
                    'z-index':animationOrder[0]
                },500);
                Login_InnerModal.animate({
                    'right' : '-'+mAW_10+'px',
                    'z-index':animationOrder[1]
                },500);
                //Animation part2
                Login_OuterModal.animate({
                    'left':mAW_100+'px'
                },500);
                Login_InnerModal.animate({
                    'right':mAW_100+'px'
                },500);
            },500);
        } else {
            //We do this to fix bootstrap error margins on HTML design so that we can have a smooth responsive webpage
            let modalHeight = Login_OuterModal.height(),
                innerHeight = Login_InnerModal.height();
            if ($isLoginProcess) {
                Login_OuterModal.css({
                    'position':'relative',
                    'z-index':'2',
                    'left':0+'px',
                });
                Login_InnerModal.css({
                    'position':'relative',
                    'z-index':'1',
                    'right':0+'px',
                    'bottom':modalHeight+'px'
                });
            } else {
                Login_OuterModal.css({
                    'height':innerHeight
                });
            }
            setTimeout(function(){
                //Animation part1
                Login_OuterModal.animate({
                    'left':'-'+(mAW_100+mAW_10)+'px',
                    'z-index':animationOrder[0]
                },500);
                Login_InnerModal.animate({
                    'right' : '-'+(mAW_100+mAW_10)+'px',
                    'z-index':animationOrder[1]
                },500);
                //Animation part2
                Login_OuterModal.animate({
                    'left':0+'px'
                },500);
                Login_InnerModal.animate({
                    'right':0+'px'
                },500);
            },500);
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
