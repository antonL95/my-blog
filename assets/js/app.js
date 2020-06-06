/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
let $ = require('jquery');

import ScrollOnClick from './components/scrolling';
import axios from 'axios';
import Cookies from './components/cookies';


require('bootstrap');

$(document).ready(function () {
    let cookies = new Cookies();
    cookies.init();
    $('.cookies-consent').on('closed.bs.alert', () => {
        cookies.setCookie('consent', 1, 365);
    });

    $('[data-toggle="popover"]').popover();
    let scrolling = new ScrollOnClick();
    scrolling.init();

    $('#con form').submit((e) => {
        e.preventDefault();
        let data = $(e.currentTarget).serialize();
        axios({
            method: 'post',
            url: contactFormUrl,
            data: data,
            responseType: 'json',
        }).then((response) => {
            if (response.data.success == 1) {
                $('.success').fadeIn();
                gtag('event', 'send', {
                    'event_label': 'send-ok',
                    'event_category': 'contact-form',
                    'event_value': 1,
                    'non_interaction': true
                });
            } else {
                $('.error').fadeIn();
                gtag('event', 'send', {
                    'event_label': 'send-ok',
                    'event_category': 'contact-form',
                    'event_value': 0,
                    'non_interaction': true
                });
            }
        }).catch((error) => {
            $('.error').fadeIn();
            gtag('event', 'send', {
                'event_label': 'send-ok',
                'event_category': 'contact-form',
                'event_value': 0,
                'non_interaction': true
            });
        })
    })

});
