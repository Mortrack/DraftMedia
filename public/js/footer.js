$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    var TwitterButton = $('#footer-twitter'),
        FacebookButton = $('#footer-facebook'),
        InstagramButton = $('#footer-instagram'),
        GithubButton = $('#footer-github'),
        HomeLink = $('#footer-home');


// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //
    TwitterButton.attr("href", URL_Twitter);
    FacebookButton.attr("href", URL_Facebook);
    InstagramButton.attr("href", URL_Instagram);
    GithubButton.attr("href", URL_Github);
    HomeLink.attr("href", APP_URL + URL_Home);

    HomeLink.on('click', function(e){
        e.preventDefault();
        window.location = APP_URL + URL_Home;
    });


// -------------------------- //
// ----- FOOTER EFFECTS ----- //
// -------------------------- //

});
