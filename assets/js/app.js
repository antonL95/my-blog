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

    $('.showMenu').click((e) => {
        openMenu(e)
    })
    $('#dismiss, .nav-item, .overlay').click((e) => {
        closeMenu(e)
    })
    $(document).keyup((e) => {
        if (e.key === "Escape") {
            if ($('.overlay').hasClass('active')) {
                e.preventDefault();
                $('#sidebar').hide(400)
                $('.overlay').toggleClass('active');
            }
        }
    });

    $(".navbar-brand").hide();

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


$(document).scroll(function () {
    let y = $(document).scrollTop(),
        image = $(".navbar-brand")

    if (y >= 400) {
        //show the image and make the header fixed
        image.show(400);
        $('.navbar').css('background-color', '#fff')
    } else {
        //put the header in original position and hide image
        image.hide(400);
        $('.navbar').css('background-color', 'transparent')
    }
});

function closeMenu(e) {
    e.preventDefault();
    $('#sidebar').hide(400)
    $('.overlay').toggleClass('active');
}

function openMenu(e) {
    e.preventDefault();
    $('#sidebar').show(400)
    $('.overlay').toggleClass('active');
}

function scrollTop(event) {
    let scrolling = new ScrollOnClick();
    let target = $('main');
    scrolling.scrollTo(target, 0, 100, event);
}
