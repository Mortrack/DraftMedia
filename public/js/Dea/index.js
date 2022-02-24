$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let Home_Link = $('#Home-Link'),
        Firstname_Input = $('#firstname-Input'),
        Lastname_Input = $('#lastname-Input'),
        Phone_Input = $('#phone-Input'),
        Sex_Input = $('#sex-Input'),
        CompanyName_Input = $('#companyName-Input'),
        Country_Input = $('#country-Input'),
        KnowAboutUs_Input = $('#knowAboutUs-Input'),
        Workfield_Input = $('#workfield-Input'),
        TermsAndConditions_Checkbox = $('#TermsAndConditions-Checkbox'),
        ServiceRequired_Input = $('#ServiceRequired-Input'),
        TermsAndConditions_Link = $('#TermsAndConditions-Link'),
        ServicePackages_Btn = $('#btn-servicePackages'),
        PersonalPackage_Input = $('#personalPackage-input'),
        EntrepreneurshipPackage_Input = $('#entrepreneurshipPackage-input'),
        BusinessPackage_Input = $('#businessPackage-input'),
        ServicePackages_Link = $('#link-servicePackages'),
        PackageRequired = "",
        projectName_Input = $('#projectName-Input'),
        websiteCategory_Input = $('#websiteCategory-Input'),
        websiteLanguage_Input = $('#websiteLanguage-Input'),
        ViewsNumber_Input = $('#viewsNumber-Input'),
        BaseColorDefinition_Input = $('#baseColorDefinition-Input'),
        DefineBaseColors_Btn = $('#btn-defineBaseColors'),
        baseColorsLvlAttch_Input = $('#baseColorsLvlAttch-Input'),
        errors_container = $('#errors-container'),
        errorHtml = "",
        ColorCode = $('#colorCode-Input'),
        ColorPriority = $('#colorPriority-Input'),
        AddColor_Btn = $('#btn-addColor'),
        TotalPorcentage = $('#totalPorcentage'),
        ColorTable_container = $('#colorTable-container'),
        baseColorCode = [],
        baseColorPriority = [],
        websiteUrl_Input = $('#websiteUrl-Input'),
        targetAudience_Input = $('#targetAudience-Input'),
        whatToTransmit_Input = $('#whatToTransmit-Input'),
        Vista1 = $('#Vista1'),
        Vista1_tab = $('#Vista1-tab'),
        Vista2_tab = $('#Vista2-tab'),
        Vista3_tab = $('#Vista3-tab'),
        Vista4_tab = $('#Vista4-tab'),
        Vista5_tab = $('#Vista5-tab'),
        Vista6_tab = $('#Vista6-tab'),
        Vista7_tab = $('#Vista7-tab'),
        Vista8_tab = $('#Vista8-tab'),
        Finish_Btn = $('#Btn-Finish'),
        messageModal = $('#messageModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt'),
        userArtisticConcept_UploadInput = $('#userArtisticConcept-UploadInput');



// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    Home_Link.attr("href", APP_URL + URL_Home);
    ServicePackages_Link.attr("href", APP_URL + URL_Pricing);
    TermsAndConditions_Link.attr("href", APP_URL + URL_TERMSANDCONDITIONS);

    Home_Link.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Home;
    });


// ------------------------------------------------------------------------------------ //
// ----- DEA TOOL: CSS STYLES FIXES BECAUSE OF CSS FRAMEWORK COMPATIBILITY ISSUES ----- //
// ------------------------------------------------------------------------------------ //
    // ----- Media Queries inputed from JS ----- //
    if ($(window).width() <=768) {
        $('#input-group1').removeClass("input-group");
        $('#input-group2').removeClass("input-group");
        $('#input-group3').removeClass("input-group");
        $('#input-group4').removeClass("input-group");
        $('.C-disable-minusLg').css({
            'display':'none'
        });
    } else {
        $('#input-group1').addClass("input-group");
        $('#input-group2').addClass("input-group");
        $('#input-group3').addClass("input-group");
        $('#input-group4').addClass("input-group");
        $('.C-disable-minusLg').css({
            'display':'table-cell'
        });
    }
    $(window).on('resize', function() {
        if ($(window).width() <=768) {
            $('#input-group1').removeClass("input-group");
            $('#input-group2').removeClass("input-group");
            $('#input-group3').removeClass("input-group");
            $('#input-group4').removeClass("input-group");
            $('.C-disable-minusLg').css({
                'display':'none'
            });
        } else {
            $('#input-group1').addClass("input-group");
            $('#input-group2').addClass("input-group");
            $('#input-group3').addClass("input-group");
            $('#input-group4').addClass("input-group");
            $('.C-disable-minusLg').css({
                'display':'table-cell'
            });
        }
    });
    if ($(window).width() >=768) {
        $('.C-col-xl-6').css({
            'width':'50%'
        });
    } else {
        $('.C-col-xl-6').css({
            'width':'100%'
        });
    }
    $(window).on('resize', function() {
        if ($(window).width() >=768) {
            $('.C-col-xl-6').css({
                'width':'50%'
            });
        } else {
            $('.C-col-xl-6').css({
                'width':'100%'
            });
        }
    });
    if ($(window).width() <=575) {
        $('#wizard-container').css({
            'width':'95%'
        });
        $('#tAC-btn').css({
            'max-width': '63%'
        });
    } else {
        $('#tAC-btn').css({
            'max-width': '100%'
        });
    }
    $(window).on('resize', function() {
        if ($(window).width() <=575) {
            $('#wizard-container').css({
                'width':'95%'
            });
            $('#tAC-btn').css({
                'max-width': '63%'
            });
            ServicePackages_Btn.text('Ver Paquetes');
        } else {
            $('#tAC-btn').css({
                'max-width': '100%'
            });
            ServicePackages_Btn.text('Ver Características de los Paquetes');
        }
    });

// -------------------------------------------------------------- //
// ----- DEA TOOL: JQUERY MASK PHONE NUMBER COMPONENT SETUP ----- //
// -------------------------------------------------------------- //
    Phone_Input.usPhoneFormat({
        format: '(xxx) xxx-xxxx',
    });
    // ----- DESDE MEXICO A USA/Canada ----- //
    //00 + 1 + Ciudad + NumeroTelefonico --> [(00)-1]-(xxx)-xxx-xxxx

// -------------------------------------- //
// ----- DEA TOOL: SERVICE REQUIRED ----- //
// -------------------------------------- //
    ServiceRequired_Input.on('change', function() {
        if (ServiceRequired_Input.val() != 'dea_webdesign') {
            //oculta el contenido de generales y detalles
            $('#generales').hide();
            $('#detalles').hide();
        } else {
            //des-oculta el contenido de generales y detalles
            $('#generales').show();
            $('#detalles').show();
        }
    });


// --------------------------------------------------------- //
// ----- DEA TOOL: HOW MANY VIEWS TO OFFER PER PACKAGE ----- //
// --------------------------------------------------------- //
    PersonalPackage_Input.parent().on('click', function() {
        isPackageChange();
    });
    EntrepreneurshipPackage_Input.parent().on('click', function() {
        isPackageChange();
    });
    BusinessPackage_Input.parent().on('click', function() {
        isPackageChange();
    });
    function isPackageChange() {
        if (PersonalPackage_Input.attr('checked')=="checked") {
            ViewsNumber_Input.empty();
            ViewsNumber_Input.append('<option disabled="" selected=""></option>');
            ViewsNumber_Input.append('<option value="1">1</option>');
        }
        if (EntrepreneurshipPackage_Input.attr('checked')=="checked") {
            ViewsNumber_Input.empty();
            ViewsNumber_Input.append('<option disabled="" selected=""></option>');
            ViewsNumber_Input.append('<option value="1">1</option>');
            ViewsNumber_Input.append('<option value="2">2</option>');
            ViewsNumber_Input.append('<option value="3">3</option>');
        }
        if (BusinessPackage_Input.attr('checked')=="checked") {
            ViewsNumber_Input.empty();
            ViewsNumber_Input.append('<option disabled="" selected=""></option>');
            ViewsNumber_Input.append('<option value="1">1</option>');
            ViewsNumber_Input.append('<option value="2">2</option>');
            ViewsNumber_Input.append('<option value="3">3</option>');
            ViewsNumber_Input.append('<option value="4">4</option>');
            ViewsNumber_Input.append('<option value="5">5</option>');
            ViewsNumber_Input.append('<option value="6">6</option>');
            ViewsNumber_Input.append('<option value="7">7</option>');
            ViewsNumber_Input.append('<option value="8">8</option>');
        }
    }


// ------------------------------------- //
// ----- DEA TOOL: ADD COLOR MODAL ----- //
// ------------------------------------- //
    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }
    // ----- This is the code used to add and delete colors and to update the total-porcentage value ----- //
    DefineBaseColors_Btn.prop('disabled', true);
    DefineBaseColors_Btn.hide();
    BaseColorDefinition_Input.on('change', function() {
        if (BaseColorDefinition_Input.val() == "true") {
            DefineBaseColors_Btn.prop('disabled', false);
            DefineBaseColors_Btn.show();
        } else if (BaseColorDefinition_Input.val() == "false") {
            DefineBaseColors_Btn.prop('disabled', true);
            DefineBaseColors_Btn.hide();
        }
    });
    DefineBaseColors_Btn.on('click', function(e) {
        e.preventDefault(); //Para que no refresque la pagina-web
    });
    let row = 1,
        TotalPriorityPorcentage=0;
    AddColor_Btn.on('click', function(e) {
        e.preventDefault();
        errors_container.empty();
        errors_container.css({'display':'none'});
        errorHtml = "";
        if (ColorCode.val() == '' || ColorCode.val().match(/[ ]+/)!=null || ColorCode.val() == null || ColorCode.val().match(/[^(a-z)(A-Z)(0-9)]/)!=null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el código del color deseado (ej. F2F2F2) y sin caracteres especiales.</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete the code of the desired color (eg F2F2F2) and without special characters.</li>';
            }
        }
        if (ColorPriority.val() == '' || ColorPriority.val().match(/[ ]+/)!=null || ColorPriority.val() == null || ColorPriority.val().match(/[^(0-9)]/)!=null) {
            errors_container.css({'display':'block'});
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el porcentaje de prioridad del color con un número entero (ej. 81) y sin caracteres especiales.</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete the priority percentage of the color with a whole number (eg 81) and without special characters.</li>';
            }
        }
        if (errorHtml=="") {
            let ColorTable_Html =
                '<tr class="bg-gray content-text text-center C-text-darkgray" id="delete_row' + row + '">' +
                '<td id="colorCode-value">' + ColorCode.val() + '</td>' +
                '<td id="colorPriority-value">' + ColorPriority.val() + '</td>' +
                '<td><div class="dot-colorSample" style="background:#' + ColorCode.val() + ';"></div></td>' +
                '<td><img src="/img/icons/icons8-close-window-48.png" width="75%" id="' + row + '" class="rowDelete-btn" style="cursor: pointer;"></td>' +
                '</tr>';
            row++;
            ColorTable_container.append(ColorTable_Html);
            $('.rowDelete-btn').on('click', function(e) {
                e.preventDefault();
                let button_id = $(this).attr("id");
                $('#delete_row' + button_id).remove();
                // Actualizamos el porcentaje total que se ha asignado a los colores
                TotalPriorityPorcentage=0;
                for (i=0; i<$('#colorSelector-table tbody tr').length; i++) {
                    TotalPriorityPorcentage += parseInt($('#colorSelector-table tbody tr').eq(i).find('#colorPriority-value').html());
                }
                TotalPorcentage.text(TotalPriorityPorcentage);
            });

            // Actualizamos el porcentaje total que se ha asignado a los colores
            TotalPriorityPorcentage=0;
            for (i=0; i<$('#colorSelector-table tbody tr').length; i++) {
                TotalPriorityPorcentage += parseInt($('#colorSelector-table tbody tr').eq(i).find('#colorPriority-value').html());
            }
            TotalPorcentage.text(TotalPriorityPorcentage);
        } else {
            errors_container.append(errorHtml);
        }
    });


// ----------------------------- //
// ----- DEA TOOL: DETAILS ----- //
// ----------------------------- //
    //This is a must have in order to have pill-tabs working under bootstrap, but that for some reason i'ts
    //not being applied manually through the .html corresponding file. So we fixed it through js.
    Vista1.addClass('in');
    let justOnce=1;
    Vista1.parent().parent().find('li').on('click', function() {
        if (justOnce == 1) {
            Vista1.removeClass('in');
            Vista1.removeClass('show');
            justOnce = 0;
        }
    });

    // We enable the amount of views that the user requested to have on his website and we disable the others that he
    // didn't
    Vista2_tab.prop('disabled', true);
    Vista2_tab.hide();
    Vista3_tab.prop('disabled', true);
    Vista3_tab.hide();
    Vista4_tab.prop('disabled', true);
    Vista4_tab.hide();
    Vista5_tab.prop('disabled', true);
    Vista5_tab.hide();
    Vista6_tab.prop('disabled', true);
    Vista6_tab.hide();
    Vista7_tab.prop('disabled', true);
    Vista7_tab.hide();
    Vista8_tab.prop('disabled', true);
    Vista8_tab.hide();
    ViewsNumber_Input.on('change', function() {
        if (ViewsNumber_Input.val()!=null) {
            switch((parseInt(ViewsNumber_Input.val())-1)) {
                case 0:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();

                    Vista2_tab.prop('disabled', true);
                    Vista2_tab.hide();
                    Vista3_tab.prop('disabled', true);
                    Vista3_tab.hide();
                    Vista4_tab.prop('disabled', true);
                    Vista4_tab.hide();
                    Vista5_tab.prop('disabled', true);
                    Vista5_tab.hide();
                    Vista6_tab.prop('disabled', true);
                    Vista6_tab.hide();
                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 1:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();

                    Vista3_tab.prop('disabled', true);
                    Vista3_tab.hide();
                    Vista4_tab.prop('disabled', true);
                    Vista4_tab.hide();
                    Vista5_tab.prop('disabled', true);
                    Vista5_tab.hide();
                    Vista6_tab.prop('disabled', true);
                    Vista6_tab.hide();
                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 2:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();

                    Vista4_tab.prop('disabled', true);
                    Vista4_tab.hide();
                    Vista5_tab.prop('disabled', true);
                    Vista5_tab.hide();
                    Vista6_tab.prop('disabled', true);
                    Vista6_tab.hide();
                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 3:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();
                    Vista4_tab.prop('disabled', false);
                    Vista4_tab.show();

                    Vista5_tab.prop('disabled', true);
                    Vista5_tab.hide();
                    Vista6_tab.prop('disabled', true);
                    Vista6_tab.hide();
                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 4:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();
                    Vista4_tab.prop('disabled', false);
                    Vista4_tab.show();
                    Vista5_tab.prop('disabled', false);
                    Vista5_tab.show();

                    Vista6_tab.prop('disabled', true);
                    Vista6_tab.hide();
                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 5:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();
                    Vista4_tab.prop('disabled', false);
                    Vista4_tab.show();
                    Vista5_tab.prop('disabled', false);
                    Vista5_tab.show();
                    Vista6_tab.prop('disabled', false);
                    Vista6_tab.show();

                    Vista7_tab.prop('disabled', true);
                    Vista7_tab.hide();
                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 6:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();
                    Vista4_tab.prop('disabled', false);
                    Vista4_tab.show();
                    Vista5_tab.prop('disabled', false);
                    Vista5_tab.show();
                    Vista6_tab.prop('disabled', false);
                    Vista6_tab.show();
                    Vista7_tab.prop('disabled', false);
                    Vista7_tab.show();

                    Vista8_tab.prop('disabled', true);
                    Vista8_tab.hide();
                    break;
                case 7:
                    Vista1_tab.prop('disabled', false);
                    Vista1_tab.show();
                    Vista2_tab.prop('disabled', false);
                    Vista2_tab.show();
                    Vista3_tab.prop('disabled', false);
                    Vista3_tab.show();
                    Vista4_tab.prop('disabled', false);
                    Vista4_tab.show();
                    Vista5_tab.prop('disabled', false);
                    Vista5_tab.show();
                    Vista6_tab.prop('disabled', false);
                    Vista6_tab.show();
                    Vista7_tab.prop('disabled', false);
                    Vista7_tab.show();
                    Vista8_tab.prop('disabled', false);
                    Vista8_tab.show();
                    break;
            }
        }
    });





    // ----- ----- Vista1 ----- ----- //
    // Question #1: ¿Tienes algún concepto artístico propio que desees que nosotros apliquemos?
    //

    // Question #2: ¿Hay alguna sección o sitio web del que desees referenciarnos algún concepto artístico?
    $('#Vista' + (1)).find('#refUrlArtisticConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refUrlArtisticConcept-Input').parent().parent().hide();
    $('#Vista' + (1)).find('#refExplanationArtiscticConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refExplanationArtiscticConcept-Input').parent().parent().hide();
    ViewsNumber_Input.on('change', function() {
        if (ViewsNumber_Input.val() != null) {
            for (i=1; i<(parseInt(ViewsNumber_Input.val())); i++) {
                $('#Vista' + (i + 1)).find('#refUrlArtisticConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refUrlArtisticConcept-Input').parent().parent().hide();
                $('#Vista' + (i + 1)).find('#refExplanationArtiscticConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refExplanationArtiscticConcept-Input').parent().parent().hide();
            }
        }
    });
    $('.rArtC').on('change', function() {
        if ($(this).val()!=null) {
            switch ((parseInt($(this).val()))) {
                case 0:
                    $(this).parent().parent().parent().find('#refUrlArtisticConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refUrlArtisticConcept-Input').parent().parent().hide();
                    $(this).parent().parent().parent().find('#refExplanationArtiscticConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refExplanationArtiscticConcept-Input').parent().parent().hide();
                    break;
                case 1:
                    $(this).parent().parent().parent().find('#refUrlArtisticConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refUrlArtisticConcept-Input').parent().parent().show();
                    $(this).parent().parent().parent().find('#refExplanationArtiscticConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refExplanationArtiscticConcept-Input').parent().parent().show();
                    break;
            }
        }
    });

    // Question #3: ¿Tienes algún concepto de animación o efecto visual que desees que nosotros apliquemos?
    /*
    userAnimationConcept_UploadInput.parent().parent().prop('disabled', true);
    userAnimationConcept_UploadInput.parent().parent().hide();
    userAnimationConcept_Input.on('change', function() {
        if (userAnimationConcept_Input.val()!=null) {
            switch ((parseInt(userAnimationConcept_Input.val()))) {
                case 0:
                    userAnimationConcept_UploadInput.parent().parent().prop('disabled', true);
                    userAnimationConcept_UploadInput.parent().parent().hide();
                    break;
                case 1:
                    userAnimationConcept_UploadInput.parent().parent().prop('disabled', false);
                    userAnimationConcept_UploadInput.parent().parent().show();
                    break;
            }
        }
    });
    */
    // Question #4: ¿Hay algun concepto de animación o efecto visual de algún sitio web que desees referenciarnos?
    $('#Vista' + (1)).find('#refUrlAnimationConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refUrlAnimationConcept-Input').parent().parent().hide();
    $('#Vista' + (1)).find('#refExplanationAnimationConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refExplanationAnimationConcept-Input').parent().parent().hide();
    ViewsNumber_Input.on('change', function() {
        if (ViewsNumber_Input.val() != null) {
            for (i=1; i<(parseInt(ViewsNumber_Input.val())); i++) {
                $('#Vista' + (i + 1)).find('#refUrlAnimationConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refUrlAnimationConcept-Input').parent().parent().hide();
                $('#Vista' + (i + 1)).find('#refExplanationAnimationConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refExplanationAnimationConcept-Input').parent().parent().hide();
            }
        }
    });
    $('.rAniC').on('change', function() {
        if ($(this).val()!=null) {
            switch ((parseInt($(this).val()))) {
                case 0:
                    $(this).parent().parent().parent().find('#refUrlAnimationConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refUrlAnimationConcept-Input').parent().parent().hide();
                    $(this).parent().parent().parent().find('#refExplanationAnimationConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refExplanationAnimationConcept-Input').parent().parent().hide();
                    break;
                case 1:
                    $(this).parent().parent().parent().find('#refUrlAnimationConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refUrlAnimationConcept-Input').parent().parent().show();
                    $(this).parent().parent().parent().find('#refExplanationAnimationConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refExplanationAnimationConcept-Input').parent().parent().show();
                    break;
            }
        }
    });
    // Question #5: ¿Hay alguna otra cosa de algún sitio web del que desees referenciarnos algo más?
    $('#Vista' + (1)).find('#refUrlOtherConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refUrlOtherConcept-Input').parent().parent().hide();
    $('#Vista' + (1)).find('#refExplanationOtherConcept-Input').parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#refExplanationOtherConcept-Input').parent().parent().hide();
    ViewsNumber_Input.on('change', function() {
        if (ViewsNumber_Input.val() != null) {
            for (i=1; i<(parseInt(ViewsNumber_Input.val())); i++) {
                $('#Vista' + (i + 1)).find('#refUrlOtherConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refUrlOtherConcept-Input').parent().parent().hide();
                $('#Vista' + (i + 1)).find('#refExplanationOtherConcept-Input').parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#refExplanationOtherConcept-Input').parent().parent().hide();
            }
        }
    });
    $('.uothC').on('change', function() {
        if ($(this).val()!=null) {
            switch ((parseInt($(this).val()))) {
                case 0:
                    $(this).parent().parent().parent().find('#refUrlOtherConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refUrlOtherConcept-Input').parent().parent().hide();
                    $(this).parent().parent().parent().find('#refExplanationOtherConcept-Input').parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().find('#refExplanationOtherConcept-Input').parent().parent().hide();
                    break;
                case 1:
                    $(this).parent().parent().parent().find('#refUrlOtherConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refUrlOtherConcept-Input').parent().parent().show();
                    $(this).parent().parent().parent().find('#refExplanationOtherConcept-Input').parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().find('#refExplanationOtherConcept-Input').parent().parent().show();
                    break;
            }
        }
    });
    // Question #6: ¿Hay algún diagrama lógico / técnico de tu sitio web que desees compartirnos?
    /*
    viewLogicDiagram_UploadInput.parent().parent().prop('disabled', true);
    viewLogicDiagram_UploadInput.parent().parent().hide();
    explanationViewLogicDiagram_Input.parent().parent().prop('disabled', true);
    explanationViewLogicDiagram_Input.parent().parent().hide();
    viewLogicDiagram_Input.on('change', function() {
        if (viewLogicDiagram_Input.val()!=null) {
            switch ((parseInt(viewLogicDiagram_Input.val()))) {
                case 0:
                    viewLogicDiagram_UploadInput.parent().parent().prop('disabled', true);
                    viewLogicDiagram_UploadInput.parent().parent().hide();
                    explanationViewLogicDiagram_Input.parent().parent().prop('disabled', true);
                    explanationViewLogicDiagram_Input.parent().parent().hide();
                    break;
                case 1:
                    viewLogicDiagram_UploadInput.parent().parent().prop('disabled', false);
                    viewLogicDiagram_UploadInput.parent().parent().show();
                    explanationViewLogicDiagram_Input.parent().parent().prop('disabled', false);
                    explanationViewLogicDiagram_Input.parent().parent().show();
                    break;
            }
        }
    });
    */

    // Habilitador de descripcion de secciones
    $('#Vista' + (1)).find('#section1-TextInput').parent().parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#section1-TextInput').parent().parent().parent().hide();
    $('#Vista' + (1)).find('#section2-TextInput').parent().parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#section2-TextInput').parent().parent().parent().hide();
    $('#Vista' + (1)).find('#section3-TextInput').parent().parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#section3-TextInput').parent().parent().parent().hide();
    $('#Vista' + (1)).find('#section4-TextInput').parent().parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#section4-TextInput').parent().parent().parent().hide();
    $('#Vista' + (1)).find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
    $('#Vista' + (1)).find('#section5-TextInput').parent().parent().parent().hide();
    ViewsNumber_Input.on('change', function() {
        if (ViewsNumber_Input.val() != null) {
            for (i=1; i<(parseInt(ViewsNumber_Input.val())); i++) {
                $('#Vista' + (i + 1)).find('#section1-TextInput').parent().parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#section1-TextInput').parent().parent().parent().hide();
                $('#Vista' + (i + 1)).find('#section2-TextInput').parent().parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#section2-TextInput').parent().parent().parent().hide();
                $('#Vista' + (i + 1)).find('#section3-TextInput').parent().parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#section3-TextInput').parent().parent().parent().hide();
                $('#Vista' + (i + 1)).find('#section4-TextInput').parent().parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#section4-TextInput').parent().parent().parent().hide();
                $('#Vista' + (i + 1)).find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
                $('#Vista' + (i + 1)).find('#section5-TextInput').parent().parent().parent().hide();
            }
        }
    });
    $('.secQuan').on('change', function() {
        if ($(this).val()!=null) {
            switch ((parseInt($(this).val())-1)) {
                case 0:
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().hide();
                    break;
                case 1:
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().hide();
                    break;
                case 2:
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().hide();
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().hide();
                    break;
                case 3:
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().prop('disabled', true);
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().hide();
                    break;
                case 4:
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section1-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section2-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section3-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section4-TextInput').parent().parent().parent().show();
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().prop('disabled', false);
                    $(this).parent().parent().parent().parent().find('#section5-TextInput').parent().parent().parent().show();
                    break;
            }
        }
    });




// ---------------------------- //
// ----- DEA TOOL: SUBMIT ----- //
// ---------------------------- //
    let errorFinish = "",
        projectName,
        websiteCategory,
        websiteLanguage,
        ViewsNumber,
        BaseColorDefinition,
        baseColorsLvlAttch,
        websiteUrl,
        targetAudience,
        whatToTransmit,
        viewsDetails = [];

    Finish_Btn.on('click', function() {
        errorFinish = "";

        // ----- dea_requests table (from database) data ----- //
        if (Firstname_Input.val()=='' || Firstname_Input.val()==null) {
            if (language=='spanish') {
                errorHtml += '<li>Porfavor completa el nombre</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your name</li>';
            }
        }
        if (Lastname_Input.val()=='' || Lastname_Input.val()==null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor completa el Apellido.</li>';
            }
            if (language=='english') {
                errorHtml += '<li>Please complete your last name</li>';
            }
        }
        if (Phone_Input.val().match(/\([0-9][0-9][0-9]\)\s[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/)==null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor completa el número telefónico.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please complete the phone number.</li>';
            }
        }
        if (Sex_Input.val() == null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor define el sexo correspondiente.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please define the corresponding gender.</li>';
            }
        }
        if (Country_Input.val() == null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor define el país correspondinete.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please define the corresponding country.</li>';
            }
        }
        if (KnowAboutUs_Input.val() == null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor define el como te enteraste de nosotros.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please define how you found out about us.</li>';
            }
        }
        if (Workfield_Input.val() == null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor define el sector al que te dedicas tu o la empresa a la que representas.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please define the sector to which you are dedicated or for the company that you represent.</li>';
            }
        }
        if (!TermsAndConditions_Checkbox.is(":checked")) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor Acepta los Términos y Condiciones.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please accept the Terms and Conditions.</li>';
            }
        }
        if (ServiceRequired_Input.val() == null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor escoge el servicio profesional que necesitas de DraftMedia.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please choose the professional service that you need from DraftMedia.</li>';
            }
        }
        if (PersonalPackage_Input.attr("checked")==null && EntrepreneurshipPackage_Input.attr("checked")==null && BusinessPackage_Input.attr("checked")==null) {
            if (language=='spanish') {
                errorFinish += '<li>Porfavor escoge el paquete que deseas contratar.</li>';
            }
            if (language=='english') {
                errorFinish += '<li>Please choose the package you wish to hire.</li>';
            }
        } else {
            if (PersonalPackage_Input.attr("checked")!=null) {
                PackageRequired = "Paquete Personal";
            }
            if (EntrepreneurshipPackage_Input.attr("checked")!=null) {
                PackageRequired = "Paquete Emprendedor";
            }
            if (BusinessPackage_Input.attr("checked")!=null) {
                PackageRequired = "Paquete Empresarial";
            }
        }

        if (ServiceRequired_Input.val() == 'dea_webdesign') {
            // ----- dea_webdesign table (from database) data ----- //
            if (projectName_Input.val()=='' || projectName_Input.val()==null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor indícanos el nombre de tu proyecto/empresa en el sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please indicate the name of your project / company on the website.</li>';
                }
            }
            if (websiteCategory_Input.val() == null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor indícanos la categoría de tu sitio Web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please tell us the category of your website.</li>';
                }
            }
            if (websiteLanguage_Input.val() == null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor escoge el lenguaje en el que deseas que se elabore tu sitio Web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please choose the language in which you want your website to be developed.</li>';
                }
            }
            if (ViewsNumber_Input.val() == null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor escoge la cantidad de vistas que deseas emplear en tu sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please choose the amount of views you want to use on your website.</li>';
                }
            }

            if (BaseColorDefinition_Input.val() == null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor indícanos si deseas definir colores base para el diseño de tu sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please let us know if you want to define base colors for the design of your website.</li>';
                }
            } else {
                if (BaseColorDefinition_Input.val()=='true') {
                    // el cliente si desea definir colores
                    if (baseColorsLvlAttch_Input.val() == null) {
                        if (language=='spanish') {
                            errorFinish += '<li>Porfavor indícanos el nivel de apego con el que deseas que nos acatemos a los colores base que propusiste.</li>';
                        }
                        if (language=='english') {
                            errorFinish += '<li>Please tell us the level of attachment with which you want us to abide by the base colors that you proposed.</li>';
                        }
                    }
                    if ($('#colorSelector-table tbody tr').length==0) {
                        if (language=='spanish') {
                            errorFinish += '<li>Porfavor indícanos cuales son los colores base que quieres que se empleen en tu sitio web.</li>';
                        }
                        if (language=='english') {
                            errorFinish += '<li>Please tell us what are the base colors that you want to be used on your website.</li>';
                        }
                    }
                    if ($('#colorSelector-table tbody tr').length>0 && $('#colorSelector-table tbody tr').length<=5) {
                        for (i=0; i<($('#colorSelector-table tbody tr').length); i++) {
                            baseColorCode[i] = $('#colorSelector-table tbody tr').eq(i).find('#colorCode-value').html();
                            baseColorPriority[i] = $('#colorSelector-table tbody tr').eq(i).find('#colorPriority-value').html();
                        }
                    } else {
                        if (language=='spanish') {
                            errorFinish += '<li>El número máximo de colores base que podemos manejar son 5. Porfavor, define 5 colores base o menos.</li>';
                        }
                        if (language=='english') {
                            errorFinish += '<li>The maximum number of base colors we can handle are 5. Please, define 5 base colors or less.</li>';
                        }
                    }
                    if (TotalPriorityPorcentage != 100) {
                        if (language=='spanish') {
                            errorFinish += '<li>Porfavor, define porcetajes de prioridad en los colores base que propusiste de manera que la suma total sea 100%.</li>';
                        }
                        if (language=='english') {
                            errorFinish += '<li>Please, define priority percentages in the base colors that you proposed so that the total sum is 100%.</li>';
                        }
                    }
                }
            }
            if (websiteUrl_Input.val()=='' || websiteUrl_Input.val()==null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor define el nombre de URL o dominio que deseas para tu sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please define the URL or domain name you want for your website.</li>';
                }
            } else {
                if ($('#websiteUrl-Input').val().match(/^www.[(a-z)(A-Z)(-)]+.com$/)==null && $('#websiteUrl-Input').val().match(/^www.[(a-z)(A-Z)(-)]+.com.mx$/)==null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor define un nombre de URL con el prefijo \"www.\" y la terminación \".com\" o \".com.mx\".</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please define a URL name with the prefix \"www.\" and the ending \".com\" or \".com.mx\".</li>';
                    }
                }
            }
            if (targetAudience_Input.val()=='' || targetAudience_Input.val()==null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor indícanos el público objetivo a quién quieres hacer llegar el contenido de tu sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please tell us the target audience to whom you want to get the content of your website.</li>';
                }
            }
            if (whatToTransmit_Input.val()=='' || whatToTransmit_Input.val()==null) {
                if (language=='spanish') {
                    errorFinish += '<li>Porfavor indícanos el concepto que deseas transmitir en tu sitio web.</li>';
                }
                if (language=='english') {
                    errorFinish += '<li>Please tell us the concept you want to transmit on your website.</li>';
                }
            }

            // This is the correct way to make an associative array. If the associative array
            // is made differently than this method, it might work on javascript, but you won't
            // be able to send it through post/get methods to php. If you send suck array, a
            // null value will be send instead unless you do it this way.
            // NOTE that we are creating an object instead of an associative array, but php will
            // read this as an associative array.
            viewsDetails = [];
            for (i=0; i<ViewsNumber_Input.val(); i++) {
                viewsDetails[i] = new Array();
                viewsDetails[i] = {};
            }
            // We define the corresponding view values, letting as null those ones that weren't used by the user
            for (i=0; i<ViewsNumber_Input.val(); i++) {
                if ($('#Vista' + (i + 1)).find('#typeOfView-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos el tipo de vista que deseas para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please tell us the type of view you want for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['type_of_website'] = $('#Vista' + (i + 1)).find('#typeOfView-Input').val();
                }
                if ($('#Vista' + (i + 1)).find('#sectionQuantity-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos cuantas secciones deseas tener en la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please tell us how many sections you wish to have for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['sections_quantity'] = $('#Vista' + (i + 1)).find('#sectionQuantity-Input').val();
                    viewsDetails[i]['section1_content'] = '';
                    viewsDetails[i]['section2_content'] = '';
                    viewsDetails[i]['section3_content'] = '';
                    viewsDetails[i]['section4_content'] = '';
                    viewsDetails[i]['section5_content'] = '';
                    switch ((parseInt(viewsDetails[i]['sections_quantity'])-1)) {
                        case 0:
                            viewsDetails[i]['section1_content'] = $('#Vista' + (i + 1)).find('#section1-TextInput').val();
                            viewsDetails[i]['section2_content'] = '';
                            viewsDetails[i]['section3_content'] = '';
                            viewsDetails[i]['section4_content'] = '';
                            viewsDetails[i]['section5_content'] = '';
                            break;
                        case 1:
                            viewsDetails[i]['section1_content'] = $('#Vista' + (i + 1)).find('#section1-TextInput').val();
                            viewsDetails[i]['section2_content'] = $('#Vista' + (i + 1)).find('#section2-TextInput').val();
                            viewsDetails[i]['section3_content'] = '';
                            viewsDetails[i]['section4_content'] = '';
                            viewsDetails[i]['section5_content'] = '';
                            break;
                        case 2:
                            viewsDetails[i]['section1_content'] = $('#Vista' + (i + 1)).find('#section1-TextInput').val();
                            viewsDetails[i]['section2_content'] = $('#Vista' + (i + 1)).find('#section2-TextInput').val();
                            viewsDetails[i]['section3_content'] = $('#Vista' + (i + 1)).find('#section3-TextInput').val();
                            viewsDetails[i]['section4_content'] = '';
                            viewsDetails[i]['section5_content'] = '';
                            break;
                        case 3:
                            viewsDetails[i]['section1_content'] = $('#Vista' + (i + 1)).find('#section1-TextInput').val();
                            viewsDetails[i]['section2_content'] = $('#Vista' + (i + 1)).find('#section2-TextInput').val();
                            viewsDetails[i]['section3_content'] = $('#Vista' + (i + 1)).find('#section3-TextInput').val();
                            viewsDetails[i]['section4_content'] = $('#Vista' + (i + 1)).find('#section4-TextInput').val();
                            viewsDetails[i]['section5_content'] = '';
                            break;
                        case 4:
                            viewsDetails[i]['section1_content'] = $('#Vista' + (i + 1)).find('#section1-TextInput').val();
                            viewsDetails[i]['section2_content'] = $('#Vista' + (i + 1)).find('#section2-TextInput').val();
                            viewsDetails[i]['section3_content'] = $('#Vista' + (i + 1)).find('#section3-TextInput').val();
                            viewsDetails[i]['section4_content'] = $('#Vista' + (i + 1)).find('#section4-TextInput').val();
                            viewsDetails[i]['section5_content'] = $('#Vista' + (i + 1)).find('#section5-TextInput').val();
                            break;
                    }
                }
                if ($('#Vista' + (i + 1)).find('#userArtisticConcept-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si tienes un concepto artístico propio para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you have an artistic concept for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_user_art_concept'] = $('#Vista' + (i + 1)).find('#userArtisticConcept-Input').val();
                }
                if ($('#Vista' + (i + 1)).find('#refArtisticConcept-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si nos quieres referenciar algún concepto artístico para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you want to reference an artistic concept for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_ext_art_concept'] = $('#Vista' + (i + 1)).find('#refArtisticConcept-Input').val();
                    viewsDetails[i]['ext_art_concept_url'] = '';
                    viewsDetails[i]['ext_art_concept_exp'] = '';
                    if ($('#Vista' + (i + 1)).find('#refArtisticConcept-Input').val() == '1') {
                        if ($('#Vista' + (i + 1)).find('#refUrlArtisticConcept-Input').val()==null && $('#Vista' + (i + 1)).find('#refExplanationArtiscticConcept-Input').val()==null) {
                            if (language=='spanish') {
                                errorFinish += '<li>Porfavor indícanos cual es el concepto artístico que nos deseas referenciar, junto con una descripción, para la vista' + (i+1) + '.</li>';
                            }
                            if (language=='english') {
                                errorFinish += '<li>Please tell us what is the artistic concept you want to reference, along with a description, for the view' + (i+1) + '.</li>';
                            }
                        } else {
                            viewsDetails[i]['ext_art_concept_url'] = $('#Vista' + (i + 1)).find('#refUrlArtisticConcept-Input').val();
                            viewsDetails[i]['ext_art_concept_exp'] = $('#Vista' + (i + 1)).find('#refExplanationArtiscticConcept-Input').val();
                        }
                    }
                }
                if ($('#Vista' + (i + 1)).find('#userAnimationConcept-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si tienes algún concepto de animación propio para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you have any concept of own animation for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_user_ani_concept'] = $('#Vista' + (i + 1)).find('#userAnimationConcept-Input').val();
                }
                if ($('#Vista' + (i + 1)).find('#refAnimationConcept-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si deseas referenciarnos algún concepto de animación para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you wish to refer us any concept of animation for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_ext_ani_concept'] = $('#Vista' + (i + 1)).find('#refAnimationConcept-Input').val();
                    viewsDetails[i]['ext_ani_concept_url'] = '';
                    viewsDetails[i]['ext_ani_concept_exp'] = '';
                    if ($('#Vista' + (i + 1)).find('#refAnimationConcept-Input').val() == '1') {
                        if ($('#Vista' + (i + 1)).find('#refUrlAnimationConcept-Input').val()==null && $('#Vista' + (i + 1)).find('#refExplanationAnimationConcept-Input').val()==null) {
                            if (language=='spanish') {
                                errorFinish += '<li>Porfavor indícanos cual es la animación que nos deseas referenciar, junto con una descripción, para la vista' + (i+1) + '.</li>';
                            }
                            if (language=='english') {
                                errorFinish += '<li>Please tell us which is the animation you want to reference, along with a description, for the view' + (i+1) + '.</li>';
                            }
                        } else {
                            viewsDetails[i]['ext_ani_concept_url'] = $('#Vista' + (i + 1)).find('#refUrlAnimationConcept-Input').val();
                            viewsDetails[i]['ext_ani_concept_exp'] = $('#Vista' + (i + 1)).find('#refExplanationAnimationConcept-Input').val();
                        }
                    }
                }
                if ($('#Vista' + (i + 1)).find('#userOtherConcept-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si tienes alguna referencia adicional para vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you have any additional reference for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_other_concept'] = $('#Vista' + (i + 1)).find('#userOtherConcept-Input').val();
                    viewsDetails[i]['other_concept_url'] = '';
                    viewsDetails[i]['other_concept_exp'] = '';
                    if ($('#Vista' + (i + 1)).find('#userOtherConcept-Input').val() == '1') {
                        if ($('#Vista' + (i + 1)).find('#refUrlOtherConcept-Input').val()==null && $('#Vista' + (i + 1)).find('#refExplanationOtherConcept-Input').val()==null) {
                            if (language=='spanish') {
                                errorFinish += '<li>Porfavor indícanos si hay alguna otra cosa que nos deseas referenciar, junto con una descripción, para la vista' + (i+1) + '.</li>';
                            }
                            if (language=='english') {
                                errorFinish += '<li>Please let us know if there is anything else you would like to reference to us, along with a description, for the view' + (i+1) + '.</li>';
                            }
                        } else {
                            viewsDetails[i]['other_concept_url'] = $('#Vista' + (i + 1)).find('#refUrlOtherConcept-Input').val();
                            viewsDetails[i]['other_concept_exp'] = $('#Vista' + (i + 1)).find('#refExplanationOtherConcept-Input').val();
                        }
                    }
                }
                if ($('#Vista' + (i + 1)).find('#viewLogicDiagram-Input').val() == null) {
                    if (language=='spanish') {
                        errorFinish += '<li>Porfavor indícanos si tienes algún diagrama lógico / técnico para la vista' + (i+1) + '.</li>';
                    }
                    if (language=='english') {
                        errorFinish += '<li>Please let us know if you have any logic / technical diagram for the view' + (i+1) + '.</li>';
                    }
                } else {
                    viewsDetails[i]['is_logic_diagram'] = $('#Vista' + (i + 1)).find('#viewLogicDiagram-Input').val();
                }
            }
            projectName = projectName_Input.val();
            websiteCategory = websiteCategory_Input.val();
            websiteLanguage = websiteLanguage_Input.val();
            ViewsNumber = ViewsNumber_Input.val();
            BaseColorDefinition = BaseColorDefinition_Input.val();
            baseColorsLvlAttch = baseColorsLvlAttch_Input.val();
            websiteUrl = websiteUrl_Input.val();
            targetAudience = targetAudience_Input.val();
            whatToTransmit = whatToTransmit_Input.val();
        } else {
            projectName = " ";
            websiteCategory = " ";
            websiteLanguage = " ";
            ViewsNumber = 1;
            BaseColorDefinition = "true";
            baseColorsLvlAttch = " ";
            websiteUrl = " ";
            targetAudience = " ";
            whatToTransmit = " ";
            viewsDetails = [];
            for (i=0; i<1; i++) {
                viewsDetails[i] = new Array();
                viewsDetails[i] = {};
            }
            viewsDetails[0]['type_of_website'] = " ";
            viewsDetails[0]['sections_quantity'] = 1;
            viewsDetails[0]['section1_content'] = " ";
            viewsDetails[0]['section2_content'] = " ";
            viewsDetails[0]['section3_content'] = " ";
            viewsDetails[0]['section4_content'] = " ";
            viewsDetails[0]['section5_content'] = " ";
            viewsDetails[0]['is_user_art_concept'] = " ";
            viewsDetails[0]['is_ext_art_concept'] = " ";
            viewsDetails[0]['ext_art_concept_url'] = " ";
            viewsDetails[0]['ext_art_concept_exp'] = " ";
            viewsDetails[0]['is_user_ani_concept'] = 1;
            viewsDetails[0]['is_ext_ani_concept'] = 1;
            viewsDetails[0]['ext_ani_concept_url'] = " ";
            viewsDetails[0]['ext_ani_concept_exp'] = " ";
            viewsDetails[0]['is_other_concept'] = 1;
            viewsDetails[0]['other_concept_url'] = " ";
            viewsDetails[0]['other_concept_exp'] = " ";
            viewsDetails[0]['is_logic_diagram'] = 1;
        }

        if (errorFinish == "") {
            //Open Loading Screen
            $('#loadingScreen').css({
                'display':'block',
                'padding-right':'17px'
            });
            $('#loadingScreen').removeClass('fade');
            $('#btn-LoadingScreenClose').modal('toggle');
            $('#loadingScreen').addClass('show');
            // Make Ajax request
            $.post(
                '/Dea/ajaxSubmitDeaForm',
                {
                    first_name:Firstname_Input.val(),
                    last_name:Lastname_Input.val(),
                    phone:Phone_Input.val().match(/[0-9][0-9][0-9]/g)[0] + Phone_Input.val().match(/[0-9][0-9][0-9]/g)[1] + Phone_Input.val().match(/[0-9][0-9][0-9][0-9]/)[0],
                    sex:Sex_Input.val(),
                    company_name:CompanyName_Input.val(),
                    country:Country_Input.val(),
                    know_about_us:KnowAboutUs_Input.val(),
                    workfield:Workfield_Input.val(),
                    terms_and_conditions:TermsAndConditions_Checkbox.is(":checked"),
                    service_required:ServiceRequired_Input.val(),
                    package_required:PackageRequired,
                    project_name:projectName,
                    website_category:websiteCategory,
                    website_language:websiteLanguage,
                    website_views:ViewsNumber,
                    is_base_colors:BaseColorDefinition,
                    base_colors_lvl_attch:baseColorsLvlAttch,
                    base_color_code:baseColorCode,
                    base_color_priority:baseColorPriority,
                    website_url:websiteUrl,
                    target_audience:targetAudience,
                    what_to_transmit:whatToTransmit,
                    viewsDetails:viewsDetails
                },
                function (response) {
                    ajaxResponse = JSON.parse(response.match('\{(\"[^"]+\"\:[^,}]+[,}])+')[0]); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                    if (ajaxResponse.status == 201) {
                        setTimeout(function() {
                            //Close Loading Screen
                            //$('#btn-LoadingScreenClose').modal('toggle');
                            //$('#loadingScreen').removeClass('show');
                            //$('#loadingScreen').removeAttr('style');

                            //Redirect to Upload screen
                            let redirect_URL = APP_URL + URL_DeaUploadFiles;
                            redirect(redirect_URL, {x: ajaxResponse.data});
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
                }
            );
        } else {
            //modal de error
            messageModal.css({
                'display':'block',
                'padding-right':'17px'
            });
            messageModal.removeClass('fade');
            modalClose.modal('toggle');
            messageModal.addClass('show');
            modalTitle.append("ERROR").addClass('text-danger');
            modalMessage.append(errorFinish);
            modalIcon.prepend('<img src="/img/icons/icons8-error-100.png"/>');
            modalGotIt.addClass('btn-danger');
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
        '/Dea/ajaxDeaIndexVisits',
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
            '/Dea/ajaxDeaIndexTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente


// -------------------------------------------------- //
// ----- FUNCTIONS USED ON THIS JAVASCRIPT FILE ----- //
// -------------------------------------------------- //
    /**
     * This function is in charge of redirecting to another URL, through javascript, and of
     * passing by some argument values to such URL.
     *
     * @return string
     *
     * @author Miranda Meza César
     * DATE November 11, 2018
     */
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
