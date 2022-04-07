'use strict';
$(document).ready(function() {

    // Idle timeout
    $.sessionTimeout({
        heading: 'h5',
        title: 'This is a demo call to upgrade to pro',
        message: 'To Continue using services upgrade',
        warnAfter: 86400,
        redirAfter: 150000,
        keepAliveUrl: '/',
        redirUrl: '/',
        logoutUrl: '/payment_options',
        keepBtnText: "Maybe Later",
        logoutBtnText:"Upgrade To Pro",
        logoutBtnClass: 'btn btn-inverse',
        keepBtnClass: 'btn btn-primary'
    });

});
