$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let container = $('#container'),
        contentModal = $('#contentModal'),
        x,
        redirect_URL;


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
        'min-height':(contentModalHeight*2)
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
            'min-height':(contentModalHeight*2)
        });
    });


// -------------------------------------------- //
// ----- MY REQUEST'S MODAL: VIEW DETAILS ----- //
// -------------------------------------------- //
    $('#userRequests-table').on('click', ".viewDeaDetails", function() {
        //Redirect to XXXX screen
        /*
        redirect_URL = APP_URL + URL_DeaUploadFiles;
        x = $(this).parent().parent().attr('id');
        if (x != null) {
            redirect(redirect_URL, {x: x});
        } else {
            x = $(this).parent().parent().parent().parent().parent().prev().attr('id');
            redirect(redirect_URL, {x: x});
        }
        */
    });


// -------------------------------------------- //
// ----- MY REQUEST'S MODAL: UPLOAD FILES ----- //
// -------------------------------------------- //
    $('#userRequests-table').on('click', ".deaUploadFiles", function() {
        //Redirect to Upload screen
        redirect_URL = APP_URL + URL_DeaUploadFiles;
        x = $(this).parent().parent().attr('id');
        if (x != null) {
            redirect(redirect_URL, {x: x});
        } else {
            x = $(this).parent().parent().parent().parent().parent().prev().attr('id');
            redirect(redirect_URL, {x: x});
        }
    });


// ----------------------------------------------- //
// ----- MY REQUEST'S MODAL: PAY WITH PAYPAL ----- //
// ----------------------------------------------- //
    $('#userRequests-table').on('click', ".paypal", function() {
        //Redirect to XXXX screen
        redirect_URL = APP_URL + URL_PaypalCheckout;
        x = $(this).parent().parent().attr('id');
        if (x != null) {
            redirect(redirect_URL, {x: x});
        } else {
            x = $(this).parent().parent().parent().parent().parent().prev().attr('id');
            redirect(redirect_URL, {x: x});
        }
    });


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/UserRequests/ajaxUserRequestsIndexVisits',
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
            '/UserRequests/ajaxUserRequestsIndexTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente


// -------------------------------------------- //
// ----- FUNCTIONS USED FOR THIS .JS FILE ----- //
// -------------------------------------------- //
    function redirect(location, args) {
        let form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", location);

        $.each( args, function( key, value ) {
            let field = $('<input></input>');

            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);

            form.append(field);
        });
        $(form).appendTo('body').submit();
    }

});
