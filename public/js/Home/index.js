$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let TwitterButton = $('#Link-twitter'),
        FacebookButton = $('#Link-facebook'),
        InstagramButton = $('#Link-instagram'),
        //GithubButton = $('#Link-github'),
        HomeLink = $('#Link-home'),
        ContactoButton = $('#btn-contacto'),
        ContactoRedirect = $('#paralax-contacto').offset().top,
        ReadMore_WebDesign = $('#btn-LeerMas_DW'),
        ReadMore_VideoPhoto = $('#btn-LeerMas_FV'),
        ReadMore_CommunManage = $('#btn-LeerMas_RS'),
        CesarMirandaTwitter = $('#CesarMiranda-Twitter'),
        CesarMirandaFacebook = $('#CesarMiranda-Facebook'),
        CesarMirandaDribbble = $('#CesarMiranda-Dribbble'),
        GreciaJaimeTwitter = $('#GreciaJaime-Twitter'),
        GreciaJaimeFacebook = $('#GreciaJaime-Facebook'),
        GreciaJaimeDribbble = $('#GreciaJaime-Dribbble'),
        NaharaUchaTwitter = $('#NaharaUcha-Twitter'),
        NaharaUchaFacebook = $('#NaharaUcha-Facebook'),
        NaharaUchaDribbble = $('#NaharaUcha-Dribbble'),
        RegisterButton = $('#btn-register'),
        LoginButton = $('#btn-login'),
        ServiceSolitudeButton = $('#btn-ServiceSolitude'),
        WhiteRectangule = $('#bodysHeader-whiteRectangule'),
        ImageOne = $('#ImageOne'),
        ImageTwo = $('#ImageTwo'),
        ImageThree = $('#ImageThree'),
        ImageFour = $('#ImageFour'),
        errorHtml = "",
        errors_container = $('#errors-container'),
        name_input = $('#name-input'),
        email_input = $('#email-input'),
        message_input = $('#message-input'),
        contactUsBtn = $('#contactUs-btn'),
        messageModal = $('#messageModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    TwitterButton.attr("href", URL_Twitter);
    FacebookButton.attr("href", URL_Facebook);
    InstagramButton.attr("href", URL_Instagram);
    //GithubButton.attr("href", URL_Github);
    HomeLink.attr("href", APP_URL + URL_Home);

    ReadMore_WebDesign.attr("href", APP_URL + URL_Services); //Must send JSON
    ReadMore_VideoPhoto.attr("href", APP_URL + URL_Services); //Must send JSON
    ReadMore_CommunManage.attr("href", APP_URL + URL_Services); //Must send JSON

    CesarMirandaTwitter.attr("href", URL_CesarM_Twitter);
    CesarMirandaFacebook.attr("href", URL_CesarM_Facebook);
    CesarMirandaDribbble.attr("href", URL_CesarM_Dribbble);
    GreciaJaimeTwitter.attr("href", URL_CesarM_Twitter);
    GreciaJaimeFacebook.attr("href", URL_CesarM_Facebook);
    GreciaJaimeDribbble.attr("href", URL_CesarM_Dribbble);
    NaharaUchaTwitter.attr("href", URL_CesarM_Twitter);
    NaharaUchaFacebook.attr("href", URL_CesarM_Facebook);
    NaharaUchaDribbble.attr("href", URL_CesarM_Dribbble);

    RegisterButton.attr("href", APP_URL + URL_Register);
    LoginButton.attr("href", APP_URL + URL_Login);
    ServiceSolitudeButton.attr("href", APP_URL + URL_DEA);

    // ----- OnClick Links ----- //
    ContactoButton.on('click', function(e){
        e.preventDefault();
        $('html, body').animate({
            scrollTop: ContactoRedirect
        }, 500);
    });

    ReadMore_WebDesign.on('click', function(e){ //Must send JSON
        e.preventDefault();
        window.location = APP_URL + URL_Services;
    });
    ReadMore_VideoPhoto.on('click', function(e){ //Must send JSON
        e.preventDefault();
        window.location = APP_URL + URL_Services;
    });
    ReadMore_CommunManage.on('click', function(e){ //Must send JSON
        e.preventDefault();
        window.location = APP_URL + URL_Services;
    });

    CesarMirandaTwitter.on('click', function(e){
        e.preventDefault();
        window.location = URL_CesarM_Twitter;
    });
    CesarMirandaFacebook.on('click', function(e){
        e.preventDefault();
        window.location = URL_CesarM_Facebook;
    });
    CesarMirandaDribbble.on('click', function(e){
        e.preventDefault();
        window.location = URL_CesarM_Dribbble;
    });
    GreciaJaimeTwitter.on('click', function(e){
        e.preventDefault();
        window.location = URL_GreciaJ_Twitter;
    });
    GreciaJaimeFacebook.on('click', function(e){
        e.preventDefault();
        window.location = URL_GreciaJ_Facebook;
    });
    GreciaJaimeDribbble.on('click', function(e){
        e.preventDefault();
        window.location = URL_GreciaJ_Dribbble;
    });
    NaharaUchaTwitter.on('click', function(e){
        e.preventDefault();
        window.location = URL_NaharaU_Twitter;
    });
    NaharaUchaFacebook.on('click', function(e){
        e.preventDefault();
        window.location = URL_NaharaU_Facebook;
    });
    NaharaUchaDribbble.on('click', function(e){
        e.preventDefault();
        window.location = URL_NaharaU_Dribbble;
    });

    RegisterButton.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Register;
    });
    LoginButton.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Login;
    });
    ServiceSolitudeButton.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_DEA;
    });

// ------------------------------------ //
// ----- BODY'S HEADER STYLES FIX ----- //
// ------------------------------------ //
    $(window).resize(function() {
        if (window.innerWidth <= 424) {
            TwitterButton.css({
                'display':'none',
            });
            FacebookButton.css({
                'display':'none',
            });
            InstagramButton.css({
                'display':'none',
            });
        } else {
            TwitterButton.css({
                'display':'inline-block',
            });
            FacebookButton.css({
                'display':'inline-block',
            });
            InstagramButton.css({
                'display':'inline-block',
            });
        }
    }).resize();


// --------------------------------- //
// ----- BODY'S HEADER EFFECTS ----- //
// --------------------------------- //
    ImageTwo.hide();
    ImageThree.hide();
    ImageFour.hide();
    WhiteRectangule.css({
        'height': '25%',
        'width': '105%',
        'position': 'relative',
        'bottom': '517px'
    });
    let t_const = 2000,
        opacity = '0.3';

    //Start animation: Animation part1
    HomesHeaderAnimationStartUp(t_const, opacity);
    //Finish first loop of the animation
    HomesHeaderAnimationLoop(t_const, opacity);
    //From here on, our animation will be looped to infinity
    setInterval(function() {
        HomesHeaderAnimationLoop(t_const, opacity);
    },(t_const*6)*4);

    function HomesHeaderAnimationStartUp($time,$opacity) {
        let t_const = $time;
        //Start animation: Animation part1
        /*
        ImageOne.css({
            'opacity': $opacity,
            'height': '150%',
            'width': '150%',
            'position': 'relative',
            'bottom': '130px',
            'right': '130px'
        });
        setTimeout(function(){
            ImageOne.animate({
                'bottom': '213.5px',
                'right': '213.5px'
            },t_const*5, 'linear');
            ImageOne.animate({
                'opacity': '0',
                'bottom': '230px',
                'right': '230px'
            },t_const, 'linear');
        },0);
        */
        ImageOne.css({
            'opacity': '0',
            'height': '150%',
            'width': '150%',
            'position': 'relative',
            'bottom': '130px',
            'right': '130px'
        });
        ImageOne.animate({
            'opacity': $opacity,
            'bottom': '146.5px',
            'right': '146.5px'
        },t_const, 'linear');
        ImageOne.animate({
            'bottom': '213.5px',
            'right': '213.5px'
        },t_const*4, 'linear');
        ImageOne.animate({
            'opacity': '0',
            'bottom': '230px',
            'right': '230px'
        },t_const, 'linear');
    }
    function HomesHeaderAnimationLoop($time,$opacity) {
        let t_const = $time;
        //Animation part2
        setTimeout(function() {
            ImageOne.hide();
            ImageTwo.show();
            ImageTwo.css({
                'opacity': '0',
                'height': '150%',
                'width': '150%',
                'position': 'relative',
                'bottom': '230px',
                'right': '230px'
            });
            ImageTwo.animate({
                'opacity': $opacity,
                'bottom': '213.5px',
                'right': '213.5px'
            },t_const, 'linear');
            ImageTwo.animate({
                'bottom': '146.5px',
                'right': '146.5px'
            },t_const*4, 'linear');
            ImageTwo.animate({
                'opacity': '0',
                'bottom': '130px',
                'right': '130px'
            },t_const, 'linear');
        },(t_const*6));

        //Animation part3
        setTimeout(function(){
            ImageTwo.hide();
            ImageThree.show();
            ImageThree.css({
                'opacity': '0',
                'height': '150%',
                'width': '150%',
                'position': 'relative',
                'bottom': '50px',
                'right': '50px'
            });
            ImageThree.animate({
                'opacity': $opacity,
                'bottom': '66.5px',
                'right': '66.5px'
            },t_const, 'linear');
            ImageThree.animate({
                'bottom': '133.5px',
                'right': '133.5px'
            },t_const*4, 'linear');
            ImageThree.animate({
                'opacity': '0',
                'bottom': '150px',
                'right': '150px'
            },t_const, 'linear');
        },(t_const*6)*2);

        //Animation part4
        setTimeout(function(){
            ImageThree.hide();
            ImageFour.show();
            ImageFour.css({
                'opacity': '0',
                'height': '150%',
                'width': '150%',
                'position': 'relative',
                'bottom': '150px',
                'right': '150px'
            });
            ImageFour.animate({
                'opacity': $opacity,
                'bottom': '133.5px',
                'right': '133.5px'
            },t_const, 'linear');
            ImageFour.animate({
                'bottom': '66.5px',
                'right': '66.5px'
            },t_const*4, 'linear');
            ImageFour.animate({
                'opacity': '0',
                'bottom': '50px',
                'right': '50px'
            },t_const, 'linear');
        },(t_const*6)*3);

        //Reset Animation: Animation part5
        setTimeout(function(){
            ImageFour.hide();
            ImageOne.show();
            ImageOne.css({
                'bottom': '130px',
                'right': '130px'
            });
            ImageOne.animate({
                'opacity': $opacity,
                'bottom': '146.5px',
                'right': '146.5px'
            },t_const, 'linear');
            ImageOne.animate({
                'bottom': '213.5px',
                'right': '213.5px'
            },t_const*4, 'linear');
            ImageOne.animate({
                'opacity': '0',
                'bottom': '230px',
                'right': '230px'
            },t_const, 'linear');
        },(t_const*6)*4);
    }


// --------------------------- //
// ----- CONTACT US FORM ----- //
// --------------------------- //
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }
    contactUsBtn.on('click', function() {
        errors_container.empty();
        errors_container.css({'display':'none'});
        errorHtml = "";
        if (name_input.val() == '' || name_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el nombre</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your name</li>';
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
        if (message_input.val() == '' || message_input.val() == null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el mensaje</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete the message</li>';
            }
        }
        if (errorHtml == "") {
            $.post(
                '/Home/ajaxContactUs',
                {
                    name_input:name_input.val(),
                    email_input:email_input.val(),
                    message_input:message_input.val()
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 200) {
                        name_input.val("");
                        email_input.val("");
                        message_input.val("");

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


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/Home/ajaxHomeIndexVisits',
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
            '/Home/ajaxHomeIndexTime',
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
