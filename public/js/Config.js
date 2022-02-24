
let APP_ENV = true,
    APP_URL = 0,
    URL_Home = '',
    URL_Aboutus = 'Aboutus/index',
    URL_Services = 'Services/index',
    URL_Pricing = 'Pricing/index',
    URL_Portfolio = '',
    URL_Login = 'Login/index',
    URL_Register = 'Register/index',
    URL_DEA = 'Dea/Index',
    URL_PRIVACYPOLITICS = 'CompanyPolitics/privacyPolitics',
    URL_TERMSANDCONDITIONS = 'CompanyPolitics/termsAndConditions',
    URL_Twitter = '',   //DraftMedia Twitter
    URL_Facebook = '',  //DraftMedia Facebook
    URL_Instagram = '', //DraftMedia Instagram
    URL_Github = '',    //DraftMedia Github
    URL_CesarM_Twitter = '',
    URL_CesarM_Facebook = 'https://www.facebook.com/cesar.miranda.161214',
    URL_CesarM_Dribbble = '',
    URL_GreciaJ_Twitter = '',
    URL_GreciaJ_Facebook = '',
    URL_GreciaJ_Dribbble = '',
    URL_NaharaU_Twitter = '',
    URL_NaharaU_Facebook = '',
    URL_NaharaU_Dribbble = '',
    URL_MyProfile = 'UserProfile/index',
    URL_MyRequestedServices = 'UserRequests/index',
    URL_DeaUploadFiles = 'Dea/uploadFiles',
    URL_PaypalCheckout = 'Paypal/paypalCheckout',
    URL_CloseSession = 'Login/logout',
    URL_AdminSummary = 'Admin/Summary/index';

if (APP_ENV) {
    APP_URL = 'http://localhost/';
}
if (!APP_ENV) {
    APP_URL = 'https://www.draftmedia.com.mx/';
}