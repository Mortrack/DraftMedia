$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let MyRequestedServices_Link = $('#MyRequestedServices-Link'),
        messageModal = $('#messageModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt'),
        Finish_Btn = $('#Finish_Btn');



// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    MyRequestedServices_Link.attr("href", APP_URL + URL_MyRequestedServices);
    Finish_Btn.attr("href", APP_URL + URL_MyRequestedServices);

    MyRequestedServices_Link.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_MyRequestedServices;
    });
    Finish_Btn.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_MyRequestedServices;
    });


// ----------------------- //
// ----- UPLOAD FILE ----- //
// ----------------------- //
    let files,
        view = '',
        fileType;


    $('.uArtC').parent().find('input[type="submit"]').hide();
    $('.rAniC').parent().find('input[type="submit"]').hide();
    $('.lDiaD').parent().find('input[type="submit"]').hide();

    $('.uArtC').on('change', function(e) {
        files = e.target.files;
        view = $(this).parent().parent().parent().attr('id').match(/[0-9]+/)[0];
        fileType = '{"0":"user_art_concept_dir"}';
        $('.uArtC').parent().find('input[type="submit"]').hide();
        $(this).parent().find('input[type="submit"]').show();
        $('.rAniC').parent().find('input[type="submit"]').hide();
        $('.rAniC').val("");
        $('.lDiaD').parent().find('input[type="submit"]').hide();
        $('.lDiaD').val("");
    });
    $('.rAniC').on('change', function(e) {
        files = e.target.files;
        view = $(this).parent().parent().parent().attr('id').match(/[0-9]+/)[0];
        fileType = '{"0":"user_ani_concept_dir"}';

        $('.uArtC').parent().find('input[type="submit"]').hide();
        $('.uArtC').val("");
        $('.rAniC').parent().find('input[type="submit"]').hide();
        $(this).parent().find('input[type="submit"]').show();
        $('.lDiaD').parent().find('input[type="submit"]').hide();
        $('.lDiaD').val("");
    });
    $('.lDiaD').on('change', function(e) {
        files = e.target.files;
        view = $(this).parent().parent().parent().attr('id').match(/[0-9]+/)[0];
        fileType = '{"0":"logic_diagram_dir","1":"'+$(this).parent().parent().parent().find('.lDiaE').val()+'"}';
        $('.uArtC').parent().find('input[type="submit"]').hide();
        $('.uArtC').val("");
        $('.rAniC').parent().find('input[type="submit"]').hide();
        $('.rAniC').val("");
        $('.lDiaD').parent().find('input[type="submit"]').hide();
        $(this).parent().find('input[type="submit"]').show();
    });
    $('.lDiaE').on('change', function() {
        fileType = '{"0":"logic_diagram_dir","1":"'+$(this).parent().parent().parent().find('.lDiaE').val()+'"}';
    });


    $('form').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData();
        data.append('media', files[0]);
        data.append('x', x);
        data.append('view', view);
        data.append('fileType', fileType);
        $.ajax({
            url: '/Dea/ajaxUploadFile?serviceRequired',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            async: true,
            beforeSend: function() {
                //Open Loading Screen
                $('#loadingScreen').css({
                    'display':'block',
                    'padding-right':'17px'
                });
                $('#loadingScreen').removeClass('fade');
                $('#btn-LoadingScreenClose').modal('toggle');
                $('#loadingScreen').addClass('show');
            }
        })
            .done(function (response) {
                ajaxResponse = response;
                if (ajaxResponse.status == 200) {
                    setTimeout(function() {
                        //Close Loading Screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');

                        //modal de exito
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        messageModal.removeClass('fade');
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
                        modalTitle.append("PROCESO EXITOSO").addClass('text-success');
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-ok-100.png"/>');
                        modalGotIt.addClass('btn-success');
                    }, 500);
                } else {
                    setTimeout(function() {
                        //Close Loading Screen
                        $('#btn-LoadingScreenClose').modal('toggle');
                        $('#loadingScreen').removeClass('show');
                        $('#loadingScreen').removeAttr('style');

                        //modal de error
                        messageModal.css({
                            'display':'block',
                            'padding-right':'17px'
                        });
                        messageModal.removeClass('fade');
                        modalClose.modal('toggle');
                        messageModal.addClass('show');
                        modalTitle.append("ERROR").addClass('text-danger');
                        modalMessage.append(ajaxResponse.message);
                        modalIcon.prepend('<img src="/img/icons/icons8-error-100.png"/>');
                        modalGotIt.addClass('btn-danger');
                    }, 500);
                }
            });
    });


// ---------------------- //
// ----- FINISH BTN ----- //
// ---------------------- //
    //


// ------------------------------- //
// ----- ENABLE CLOSE MODALS ----- //
// ------------------------------- //
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
        '/Dea/ajaxDeaUploadFilesVisits',
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
            '/Dea/ajaxDeaUploadFilesTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente
});
