$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let Home = $('#header-home'),
        AcercaDe = $('#header-a1'),
        Servicios = $('#header-a2'),
        Precios = $('#header-a3'),
        Portafolio = $('#header-a4'),
        Login = $('#header-a5'),
        User = $('#header-a6'),
        EnglishLan = $('#english-language'),
        SpanishLan = $('#spanish-language'),
        MyProfile = $('#header-myProfile'),
        MyRequestedServices = $('#header-MyRequestedServices'),
        RequestService = $('#header-requestService'),
        CloseSession = $('#header-closeSession'),
        AcercaDe_Dot = $('#headerA1-dot'),
        AcercaDe_Line = $('#headerA1-line'),
        Servicios_Dot = $('#headerA2-dot'),
        Servicios_Line = $('#headerA2-line'),
        Precios_Dot = $('#headerA3-dot'),
        Precios_Line = $('#headerA3-line'),
        Portafolio_Dot = $('#headerA4-dot'),
        Portafolio_Line = $('#headerA4-line'),
        Login_Dot = $('#headerA5-dot'),
        Login_Line = $('#headerA5-line');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    Home.attr("href", APP_URL + URL_Home);
    AcercaDe.attr("href", APP_URL + URL_Aboutus);
    Servicios.attr("href", APP_URL + URL_Services);
    Precios.attr("href", APP_URL + URL_Pricing);
    Portafolio.attr("href", APP_URL + URL_Portfolio);
    Login.attr("href", APP_URL + URL_Login);
    MyProfile.attr("href", APP_URL + URL_MyProfile);
    MyRequestedServices.attr("href", APP_URL + URL_MyRequestedServices);
    RequestService.attr("href", APP_URL + URL_DEA);
    CloseSession.attr("href", APP_URL + URL_CloseSession);

    Home.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Home;
    });
    AcercaDe.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Aboutus;
    });
    Servicios.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Services;
    });
    Precios.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Pricing;
    });
    Portafolio.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Portfolio;
    });
    Login.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Login;
    });


// ------------------------ //
// ----- MENU EFFECTS ----- //
// ------------------------ //
    // Text sliding effect when home page displays for first time
    if (APP_URL == window.location.href) {
        AcercaDe.css({
            top:'-200px',
        });
        Servicios.css({
            top:'-200px',
        });
        Precios.css({
            top:'-200px',
        });
        Portafolio.css({
            top:'-200px',
        });
        Login.css({
            top:'-200px',
        });
        User.css({
            top:'-200px',
        });
        setTimeout(function(){
            AcercaDe.css({
                'top' : '0',
                'transition': 'top 0.5s ease'
            });
            Servicios.css({
                'top' : '0',
                'transition': 'top 1s ease'
            });
            Precios.css({
                'top' : '0',
                'transition': 'top 1.5s ease'
            });
            Portafolio.css({
                'top' : '0',
                'transition': 'top 2s ease'
            });
            Login.css({
                'top' : '0',
                'transition': 'top 2.5s ease'
            });
            User.css ({
                'top' : '0',
                'transition': 'top 2.5s ease'
            });
        }, 0);
    }


    // Underline effect for header's nav bar list items
    if ($(window).width() >= 992) {
        AcercaDe.parent().hover(function() {
            AcercaDe_Dot.addClass('dot');
            AcercaDe_Line.addClass('dot-line-maxWidth');
            AcercaDe_Dot.hide();
            AcercaDe_Line.hide();
            AcercaDe_Dot.show(50);
            AcercaDe_Line.show(300);
        }, function() {
            AcercaDe_Line.hide(300);
            AcercaDe_Dot.hide(50);
        });
        Servicios.parent().hover(function() {
            Servicios_Dot.addClass('dot');
            Servicios_Line.addClass('dot-line-maxWidth');
            Servicios_Dot.hide();
            Servicios_Line.hide();
            Servicios_Dot.show(50);
            Servicios_Line.show(300);
        }, function() {
            Servicios_Line.hide(300);
            Servicios_Dot.hide(50);
        });
        Precios.parent().hover(function() {
            Precios_Dot.addClass('dot');
            Precios_Line.addClass('dot-line-maxWidth');
            Precios_Dot.hide();
            Precios_Line.hide();
            Precios_Dot.show(50);
            Precios_Line.show(300);
        }, function() {
            Precios_Line.hide(300);
            Precios_Dot.hide(50);
        });
        Portafolio.parent().hover(function() {
            Portafolio_Dot.addClass('dot');
            Portafolio_Line.addClass('dot-line-maxWidth');
            Portafolio_Dot.hide();
            Portafolio_Line.hide();
            Portafolio_Dot.show(50);
            Portafolio_Line.show(300);
        }, function() {
            Portafolio_Line.hide(300);
            Portafolio_Dot.hide(50);
        });
        Login.parent().hover(function() {
            Login_Dot.addClass('dot');
            Login_Line.addClass('dot-line-maxWidth');
            Login_Dot.hide();
            Login_Line.hide();
            Login_Dot.show(50);
            Login_Line.show(300);
        }, function() {
            Login_Line.hide(300);
            Login_Dot.hide(50);
        });
    }


// ---------------------- //
// ----- STYLES FIX ----- //
// ---------------------- //
    if ($(window).width() < 992) {
        $('#navbar_global').css({
            'background':'#F2F2F2'
        });
        $('#header-a1 span').css({
            'color':'#1B1B1B'
        });
        $('#header-a2 span').css({
            'color':'#1B1B1B'
        });
        $('#header-a3 span').css({
            'color':'#1B1B1B'
        });
        $('#header-a4 span').css({
            'color':'#1B1B1B'
        });
        $('#header-a5 span').css({
            'color':'#1B1B1B'
        });
        $('#header-a6 span').css({
            'color':'#1B1B1B'
        });
        $('#en-text').css({
            'color':'#1B1B1B'
        });
        $('#es-text').css({
            'color':'#1B1B1B'
        });
        $('#slash-text').css({
            'color':'#1B1B1B'
        });
    } else {
        $('#navbar_global').css({
            'background-color':'transparent'
        });
        $('#header-a1 span').css({
            'color':'#FFFFFF'
        });
        $('#header-a2 span').css({
            'color':'#FFFFFF'
        });
        $('#header-a3 span').css({
            'color':'#FFFFFF'
        });
        $('#header-a4 span').css({
            'color':'#FFFFFF'
        });
        $('#header-a5 span').css({
            'color':'#FFFFFF'
        });
        $('#header-a6 span').css({
            'color':'#FFFFFF'
        });
        $('#en-text').css({
            'color':'#FFFFFF'
        });
        $('#es-text').css({
            'color':'#FFFFFF'
        });
        $('#slash-text').css({
            'color':'#FFFFFF'
        });
    }
    $(window).on('resize', function() {
        if ($(window).width() < 992) {
            $('#navbar_global').css({
                'background':'#F2F2F2'
            });
            $('#header-a1 span').css({
                'color':'#1B1B1B'
            });
            $('#header-a2 span').css({
                'color':'#1B1B1B'
            });
            $('#header-a3 span').css({
                'color':'#1B1B1B'
            });
            $('#header-a4 span').css({
                'color':'#1B1B1B'
            });
            $('#header-a5 span').css({
                'color':'#1B1B1B'
            });
            $('#header-a6 span').css({
                'color':'#1B1B1B'
            });
            $('#en-text').css({
                'color':'#1B1B1B'
            });
            $('#es-text').css({
                'color':'#1B1B1B'
            });
            $('#slash-text').css({
                'color':'#1B1B1B'
            });
        } else {
            $('#navbar_global').css({
                'background-color':'transparent'
            });
            $('#header-a1 span').css({
                'color':'#FFFFFF'
            });
            $('#header-a2 span').css({
                'color':'#FFFFFF'
            });
            $('#header-a3 span').css({
                'color':'#FFFFFF'
            });
            $('#header-a4 span').css({
                'color':'#FFFFFF'
            });
            $('#header-a5 span').css({
                'color':'#FFFFFF'
            });
            $('#header-a6 span').css({
                'color':'#FFFFFF'
            });
            $('#en-text').css({
                'color':'#FFFFFF'
            });
            $('#es-text').css({
                'color':'#FFFFFF'
            });
            $('#slash-text').css({
                'color':'#FFFFFF'
            });
        }
    });


// ------------------------------ //
// ----- LANGUAGE SELECTION ----- //
// ------------------------------ //
    EnglishLan.on('click', function(e){
        e.preventDefault();
        //Open Loading Screen
        $('#loadingScreen').css({
            'display':'block',
            'padding-right':'17px'
        });
        $('#loadingScreen').removeClass('fade');
        $('#btn-LoadingScreenClose').modal('toggle');
        $('#loadingScreen').addClass('show');
        $.post(
            '/Home/ajaxLanguageSelection',
            {
                language:'english'
            },
            function (response) {
                ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    location.reload();
                }
            }
        );
    });
    SpanishLan.on('click', function(e){
        e.preventDefault();
        //Open Loading Screen
        $('#loadingScreen').css({
            'display':'block',
            'padding-right':'17px'
        });
        $('#loadingScreen').removeClass('fade');
        $('#btn-LoadingScreenClose').modal('toggle');
        $('#loadingScreen').addClass('show');
        $.post(
            '/Home/ajaxLanguageSelection',
            {
                language:'spanish'
            },
            function (response) {
                ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    location.reload();
                }
            }
        );
    });
});
