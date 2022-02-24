$(document).ready(function(){
// ---------------------------------------------- //
// ----- DEFINITION OF VARIABLES TO BE USED ----- //
// ---------------------------------------------- //
    let totalAnnualMsgs = $('#total_annualMsgs'),
        receivedMessages_label = $('#receivedMessages-label'),
        attendedMessages_label = $('#attendedMessages-label'),
        totalWeeklyReceivedMsgs = $('#total_weeklyReceivedMsgs'),
        totalWeeklyAttendedMsgs = $('#total_weeklyAttendedMsgs'),
        avgWeeklyReceivedMsgs = $('#avg_weeklyReceivedMsgs'),
        messageModal = $('#messageModal'),
        modalTitle = $('#modalTitle-Text'),
        modalMessage = $('#modalMessage-Text'),
        modalIcon = $('#modalIcon-Image'),
        modalClose = $('#btn-modalClose'),
        modalGotIt = $('#btn-modalGotIt');

    let language = 'english';
    if ((getCookie('1D5M9_7L5a3n0')==='english') || (getCookie('1D5M9_7L5a3n0')==='spanish')) {
        language = getCookie('1D5M9_7L5a3n0');
    }

// ---------------------------- //
// ----- LINKS DEFINITION ----- //
// ---------------------------- //


// ---------------------- //
// ----- STYLES FIX ----- //
// ---------------------- //
    if ($(window).width() < 376) {
        receivedMessages_label.parent().css({
            'font-size':'10px'
        });
        attendedMessages_label.parent().css({
            'font-size':'10px'
        });
    } else {
        receivedMessages_label.parent().css({
            'font-size':'12px'
        });
        attendedMessages_label.parent().css({
            'font-size':'12px'
        });
    }
    $(window).on('resize', function() {
        if ($(window).width() < 376) {
            receivedMessages_label.parent().css({
                'font-size':'10px'
            });
            attendedMessages_label.parent().css({
                'font-size':'10px'
            });
        } else {
            receivedMessages_label.parent().css({
                'font-size':'12px'
            });
            attendedMessages_label.parent().css({
                'font-size':'12px'
            });
        }
    });


// ---------------------------- //
// ----- CONTACT US TABLE ----- //
// ---------------------------- //
    $('.contactUs_isAttended').on('change', function() {
        let isAttended = $(this).is(':checked'),
            contactUs_id = $(this).parent().parent().parent().parent().attr('id');
        $.post(
            '/Admin/Email/ajaxUpdateIsAttended',
            {
                is_attended:isAttended,
                id:contactUs_id
            },
            function (response) {
            }
        );
    });


// -------------------------------------------- //
// ----- ANNUALLY RECEIVED MESSAGES GRAPH ----- //
// -------------------------------------------- //
    updateAnnuallyReceivedMessagesGraph();
    receivedMessages_label.on('change', function() {
        updateAnnuallyReceivedMessagesGraph();
    });
    function updateAnnuallyReceivedMessagesGraph() {
        $.post(
            '/Admin/Email/ajaxUpdateAnnuallyReceivedMessagesGraph?request=1',
            {
            },
            function (response) {
                ajaxResponse = JSON.parse(response); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    totalAnnualMsgs.text(ajaxResponse.data[0]);

                    // General configuration for the charts with Line gradientStroke
                    gradientChartOptionsConfiguration =  {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: '#fff',
                            titleFontColor: '#333',
                            bodyFontColor: '#666',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                        },
                        responsive: true,
                        scales:{
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: 'rgba(29,140,248,0.0)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    suggestedMin:ajaxResponse.data[3],
                                    suggestedMax: ajaxResponse.data[2],
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }],
                            xAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: 'rgba(220,53,69,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }]
                        }
                    };
                    $('#chartBig1-container').empty();
                    $('#chartBig1-container').append('<canvas id="chartBig1"></canvas>');
                    let ctx = document.getElementById("chartBig1").getContext("2d");
                    let gradientStroke = ctx.createLinearGradient(0,230,0,50);
                    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
                    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
                    let data = {
                        labels: ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'],
                        datasets: [{
                            label: "Data",
                            fill: true,
                            backgroundColor: gradientStroke,
                            borderColor: '#d048b6',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#d048b6',
                            pointBorderColor:'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#d048b6',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: ajaxResponse.data[1],
                        }]
                    };
                    let myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: gradientChartOptionsConfiguration
                    });
                } else {
                    setTimeout(function() {
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
    }


// -------------------------------------------- //
// ----- ANNUALLY ATTENDED MESSAGES GRAPH ----- //
// -------------------------------------------- //
    attendedMessages_label.on('change', function() {
        updateAnnuallyAttendedMessagesGraph();
    });
    function updateAnnuallyAttendedMessagesGraph() {
        $.post(
            '/Admin/Email/ajaxUpdateAnnuallyAttendedMessagesGraph?request=1',
            {
            },
            function (response) {
                ajaxResponse = JSON.parse(response); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    totalAnnualMsgs.text(ajaxResponse.data[0]);

                    // General configuration for the charts with Line gradientStroke
                    gradientChartOptionsConfiguration =  {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: '#fff',
                            titleFontColor: '#333',
                            bodyFontColor: '#666',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                        },
                        responsive: true,
                        scales:{
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: 'rgba(29,140,248,0.0)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    suggestedMin:ajaxResponse.data[3],
                                    suggestedMax: ajaxResponse.data[2],
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }],
                            xAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: 'rgba(220,53,69,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }]
                        }
                    };
                    $('#chartBig1-container').empty();
                    $('#chartBig1-container').append('<canvas id="chartBig1"></canvas>');
                    let ctx = document.getElementById("chartBig1").getContext("2d");
                    let gradientStroke = ctx.createLinearGradient(0,230,0,50);
                    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
                    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
                    let data = {
                        labels: ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'],
                        datasets: [{
                            label: "Data",
                            fill: true,
                            backgroundColor: gradientStroke,
                            borderColor: '#d048b6',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#d048b6',
                            pointBorderColor:'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#d048b6',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: ajaxResponse.data[1],
                        }]
                    };
                    let myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: gradientChartOptionsConfiguration
                    });
                } else {
                    setTimeout(function() {
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
    }


// ------------------------------------------ //
// ----- WEEKLY RECEIVED MESSAGES GRAPH ----- //
// ------------------------------------------ //
    updateWeeklyReceivedMessagesGraph();
    function updateWeeklyReceivedMessagesGraph() {
        $.post(
            '/Admin/Email/ajaxUpdateWeeklyReceivedMessagesGraph?request=1',
            {
            },
            function (response) {
                ajaxResponse = JSON.parse(response); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    totalWeeklyReceivedMsgs.text(ajaxResponse.data[0]);

                    gradientChartOptionsConfiguration =  {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },

                        tooltips: {
                            backgroundColor: '#fff',
                            titleFontColor: '#333',
                            bodyFontColor: '#666',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                        },
                        responsive: true,
                        scales:{
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    suggestedMin:ajaxResponse.data[3],
                                    suggestedMax: ajaxResponse.data[2],
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }],

                            xAxes: [{
                                barPercentage: 0.9,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }]
                        }
                    };
                    let ctx = document.getElementById("chartSmall1").getContext("2d");
                    let gradientStroke = ctx.createLinearGradient(0,230,0,50);
                    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
                    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
                    let data = {
                        labels: ['DOM', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB'],
                        datasets: [{
                            label: "Data",
                            fill: true,
                            backgroundColor: gradientStroke,
                            borderColor: '#2097ee',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#2097ee',
                            pointBorderColor:'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#2097ee',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: ajaxResponse.data[1],
                        }]
                    };
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: gradientChartOptionsConfiguration
                    });
                } else {
                    setTimeout(function() {
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
    }


// ------------------------------------------ //
// ----- WEEKLY ATTENDED MESSAGES GRAPH ----- //
// ------------------------------------------ //
    updateWeeklyAttendedMessagesGraph();
    function updateWeeklyAttendedMessagesGraph() {
        $.post(
            '/Admin/Email/ajaxUpdateWeeklyAttendedMessagesGraph?request=1',
            {
            },
            function (response) {
                ajaxResponse = JSON.parse(response); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    totalWeeklyAttendedMsgs.text(ajaxResponse.data[0]);

                    gradientChartOptionsConfiguration =  {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },

                        tooltips: {
                            backgroundColor: '#fff',
                            titleFontColor: '#333',
                            bodyFontColor: '#666',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                        },
                        responsive: true,
                        scales:{
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    suggestedMin:ajaxResponse.data[3],
                                    suggestedMax: ajaxResponse.data[2],
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }],

                            xAxes: [{
                                barPercentage: 0.9,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }]
                        }
                    };
                    let ctx = document.getElementById("chartSmall2").getContext("2d");
                    let gradientStroke = ctx.createLinearGradient(0,230,0,50);
                    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
                    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
                    let data = {
                        labels: ['DOM', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB'],
                        datasets: [{
                            label: "Data",
                            fill: true,
                            backgroundColor: gradientStroke,
                            borderColor: '#33dba9',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#2097ee',
                            pointBorderColor:'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#2097ee',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: ajaxResponse.data[1],
                        }]
                    };
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: gradientChartOptionsConfiguration
                    });
                } else {
                    setTimeout(function() {
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
    }


// -------------------------------------------------- //
// ----- AVERAGE WEEKLY RECEIVED MESSAGES GRAPH ----- //
// -------------------------------------------------- //
    updateAvgWeeklyReceivedMessagesGraph();
    function updateAvgWeeklyReceivedMessagesGraph() {
        $.post(
            '/Admin/Email/ajaxUpdateAvgWeeklyReceivedMessagesGraph?request=1',
            {
            },
            function (response) {
                ajaxResponse = JSON.parse(response); //Esto hace un match perfecto a codigo JSONs (excepto cuando se usan comas dentro de strings)
                if (ajaxResponse.status == 200) {
                    avgWeeklyReceivedMsgs.text(ajaxResponse.data[0]);

                    gradientChartOptionsConfiguration =  {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },

                        tooltips: {
                            backgroundColor: '#fff',
                            titleFontColor: '#333',
                            bodyFontColor: '#666',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                        },
                        responsive: true,
                        scales:{
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    suggestedMin:ajaxResponse.data[3],
                                    suggestedMax: ajaxResponse.data[2],
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }],

                            xAxes: [{
                                barPercentage: 0.9,
                                gridLines: {
                                    drawBorder: true,
                                    color: 'rgba(32,151,238,0.1)',
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 20,
                                    fontColor: "#9a9a9a"
                                }
                            }]
                        }
                    };
                    let ctx = document.getElementById("chartSmall3").getContext("2d");
                    let gradientStroke = ctx.createLinearGradient(0,230,0,50);
                    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
                    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
                    let data = {
                        labels: ['DOM', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB'],
                        datasets: [{
                            label: "Data",
                            fill: true,
                            backgroundColor: gradientStroke,
                            borderColor: '#e67300', //orange
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#2097ee',
                            pointBorderColor:'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#2097ee',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: ajaxResponse.data[1],
                        }]
                    };
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: gradientChartOptionsConfiguration
                    });
                } else {
                    setTimeout(function() {
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
    }


// ------------------------------------------ //
// ----- SEE CONTACT US MESSAGE DETAILS ----- //
// ------------------------------------------ //
    $('.readContactUsMessage').on('click', function(e) {
        e.preventDefault();
        let contactUsMessage = $(this).parent().parent().find('.contactUsMessage').text(),
            userName = $(this).text();

        //modal de exito
        messageModal.css({
            'display':'block',
            'padding-right':'17px'
        });
        modalClose.modal('toggle');
        messageModal.addClass('show');
        if (language=='spanish') {
            modalTitle.append("VER MENSAJE").addClass('text-success');
        }
        if (language=='english') {
            modalTitle.append("SEE MESSAGE").addClass('text-success');
        }
        modalMessage.append(userName + '<br><br>' + contactUsMessage);
        //modalIcon.prepend('<img src="/img/icons/icons8-ok-100.png"/>');
        modalGotIt.addClass('btn-success');
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
