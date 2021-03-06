/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import Places from 'places.js'


// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
//
//
//
// let inputAdress = document.querySelector('#adresse')
// if (inputAdress !== null) {
//     let place = Places({
//         container: inputAdress
//     })
//     place.on('change', e => {
//         document.querySelector("#actu_ville").value = e.suggestion.city
//         document.querySelector("#actu_codePostal").value = e.suggestion.postcode
//         document.querySelector("#actu_lat").value = e.suggestion.latlng.lat
//         document.querySelector("#actu_lng").value = e.suggestion.latlng.lng
//
//     })
// }



$('.carousel').carousel({
    interval: 5000
});


jQuery(function ($) {

    var current = null;
    var tp = parseInt($('#miniature a:first span.titre').css('top'));
    //let lft = parseInt($('#miniature a:first span.description').css('left'));

    $('#miniature a').mouseover(function(){

        if (current && $(this).index() != current.index()) {

            current.find('span.bg').stop().fadeOut();
            current.find('span.titre').show().animate({
                top: tp + 25,
                opacity: 0
            });
            current.find('span.description').show().animate({
                top: tp + 25,
                opacity: 0
            });
        }
        if (current && $(this).index == current.index()) {
            return null;
        }

        $(this).find('span.bg').hide().stop().fadeTo(500,0.7);
        $(this).find('span.titre').stop().css({
            opacity: 0,
            top : tp + 50
        }).animate({
            opacity: 1,
            top: tp + 200
        });
        $(this).find('span.description').stop().css({
            opacity: 0,
            top : tp + 80

        }).animate({
            opacity: 1,
            top: tp + 230
        });
        current = $(this);
    });

});

// $('#facebook').mouseover(function () {
//
// }).animate
