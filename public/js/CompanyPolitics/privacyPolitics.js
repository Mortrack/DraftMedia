$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //


// ------------------------ //
// ----- STYLES FIXES ----- //
// ------------------------ //


// --------------------------------------------- //
// ----- NUMBER AND TIME OF VISITS COUNTER ----- //
// --------------------------------------------- //
    $.post(
        '/CompanyPolitics/ajaxCompanyPoliticsPrivacyPoliticsVisits',
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
            '/CompanyPolitics/ajaxCompanyPoliticsPrivacyPoliticsTime',
            {
                visitTime:"true"
            }
        );
    }, 5000); // NOTA IMPORTANTE: si este intervalo es pequeno, la pagina no funciona correctamente


// -------------------------------------------- //
// ----- FUNCTIONS USED FOR THIS .JS FILE ----- //
// -------------------------------------------- //
});
