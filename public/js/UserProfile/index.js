$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let container = $('#container'),
        contentModal = $('#contentModal'),
        email_input = $('#email-input'),
        errors_container = $('#errors-container'),
        errors_container_newPassword = $('#errors-container-newPassword'),
        errorHtml = "",
        messageModal = $('#messageModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt'),
        firstname_input = $('#first_name-input'),
        lastname_input = $('#last_name-input'),
        actualPassword_input = $('#actualPassword-input'),
        newPassword1_input = $('#newPassword1-input'),
        newPassword2_input = $('#newPassword2-input'),
        changePassword = $('#changePassword'),
        editUserProfile = $('#editUserProfile'),
        saveChanges = $('#saveChanges');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //


// ------------------------ //
// ----- STYLES FIXES ----- //
// ------------------------ //
    let actualHeight,
        contentModalHeight,
        navbarHeight,
        desiredTopMargin;

    actualHeight = container.innerHeight();
    contentModalHeight = contentModal.innerHeight();
    navbarHeight = $('#navbar-main').innerHeight();
    desiredTopMargin = ((actualHeight-contentModalHeight-navbarHeight)/2);
    if (desiredTopMargin < 0) {
        desiredTopMargin = 0;
    }
    container.css({
        'padding-top':desiredTopMargin,
        'min-height':contentModalHeight
    });
    $(window).on('resize', function() {
        actualHeight = container.innerHeight();
        contentModalHeight = contentModal.innerHeight();
        navbarHeight = $('#navbar-main').innerHeight();
        desiredTopMargin = ((actualHeight-contentModalHeight-navbarHeight)/2);
        if (desiredTopMargin < 0) {
            desiredTopMargin = 0;
        }
        container.css({
            'padding-top':desiredTopMargin,
            'min-height':contentModalHeight
        });
    });


// -------------------------------------------------- //
// ----- MY-PROFILE MODAL: EDIT-PROFILE PROCESS ----- //
// -------------------------------------------------- //
    editUserProfile.on('click', function() {
        firstname_input.attr("disabled", false);
        lastname_input.attr("disabled", false);
        email_input.attr("disabled", false);
    });


// -------------------------------------------------- //
// ----- MY-PROFILE MODAL: SAVE-CHANGES PROCESS ----- //
// -------------------------------------------------- //
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }
    saveChanges.on('click', function() {
        errors_container.empty();
        errors_container.css({'display':'none'});
        errorHtml = "";
        if (firstname_input.val() == '' || firstname_input.val().match(/[ ]+/)!=null || firstname_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el nombre</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your name</li>';
            }
        }
        if (lastname_input.val() == '' || lastname_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa tu(s) apellido(s)</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your last name</li>';
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
        if (errorHtml == "") {
            $('#loadingScreen').removeClass('fade');
            $('#btn-LoadingScreenClose').modal('toggle');
            $('#loadingScreen').addClass('show');
            $.post(
                '/UserProfile/ajaxSaveChanges',
                {
                    firstname_input:firstname_input.val(),
                    lastname_input:lastname_input.val(),
                    email_input:email_input.val()
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 200) {
                        //Close loading screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');
                        //User changed his profile successfully
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
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
                        //Close loading screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');
                        //modal de error (User couldn't change his profile)
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
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
        messageModal.removeClass('show');
        messageModal.removeAttr('style');
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
        messageModal.removeClass('show');
        messageModal.removeAttr('style');
        modalTitle.empty();
        modalTitle.removeClass('text-success');
        modalTitle.removeClass('text-danger');
        modalMessage.empty();
        modalIcon.empty();
        modalGotIt.removeClass('btn-success');
        modalGotIt.removeClass('btn-danger');
    });


// ----------------------------------------------------- //
// ----- MY-PROFILE MODAL: CHANGE-PASSWORD PROCESS ----- //
// ----------------------------------------------------- //
    changePassword.on('click', function() {
        errors_container_newPassword.empty();
        errors_container_newPassword.css({'display':'none'});
        errorHtml = "";
        if (actualPassword_input.val() == '' || actualPassword_input.val() == null) {
            errors_container_newPassword.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor ingresa tu contraseña actual en el casillero corrrespondiente.</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please enter your current password in the corresponding box.</li>';
            }
        }
        if (newPassword1_input.val() == '' || newPassword1_input.val() == null || newPassword2_input.val() == '' || newPassword2_input.val() == null) {
            errors_container_newPassword.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor ingresa tu nueva contraseña en los dos casilleros corrrespondientes.</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please enter your new password in both of the corresponding boxes.</li>';
            }
        }
        if (errorHtml == "") {
            $('#loadingScreen').removeClass('fade');
            $('#btn-LoadingScreenClose').modal('toggle');
            $('#loadingScreen').addClass('show');
            $.post(
                '/UserProfile/ajaxChangePassword',
                {
                    actualPassword_input:actualPassword_input.val(),
                    newPassword1_input:newPassword1_input.val(),
                    newPassword2_input:newPassword2_input.val()
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 200) {
                        //Close loading screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');
                        //modal de exito
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
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
                        //Close loading screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');
                        //modal de error
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
                        modalTitle.append("ERROR").addClass('text-danger');
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-error-100.png"/>');
                        modalGotIt.addClass('btn-danger');
                    }
                }
            );
        } else {
            errors_container_newPassword.append(errorHtml);
        }
    });


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/UserProfile/ajaxUserProfileIndexVisits',
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
            '/UserProfile/ajaxUserProfileIndexTime',
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
