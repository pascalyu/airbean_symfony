/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import $ from 'jquery';
import 'select2';
import 'bootstrap';
import 'bootstrap-datepicker';
import 'select2/dist/css/select2.css';
import 'bootstrap/dist/css/bootstrap.css';

import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';

import '../css/app.css';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');



// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.




console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function () {

    $('#property1_city').select2();
    $('#search-select2').select2({
        maximumSelectionLength: 1
    });
    $('.custom-file-input').on('change', function (event) {
        var inputFile = event.currentTarget;
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
    });
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("setDate", new Date());


    $("#rent_personNbr").on("change", function () {
        $("#person-nbr").html($("#rent_personNbr").val());

        var priceAllPersons = calculPriceAllPersons(parseInt($("#price-per-day").html()), $("#rent_personNbr").val());
        $("#price-all-persons").html(priceAllPersons);


    });
    $(".price-changer").on("change", function () {


        $("#total-price").html(calculTotalPrice());
    })
    $("#total-price").html(calculTotalPrice());
   



    function calculPriceAllPersons($pricePerDay, $personNbr) {
        return $pricePerDay * $personNbr;
    }
    function calculTotalPrice() {
        var dayNbr = days_between(new Date($("#rent_startDateAt").val()), new Date($("#rent_endDateAt").val()));

        var price = calculPriceAllPersons(parseInt($("#price-per-day").html()), $("#rent_personNbr").val());

        return dayNbr * price;
    }
    function days_between(date1, date2) {

        // The number of milliseconds in one day
        const ONE_DAY = 1000 * 60 * 60 * 24;
        // Calculate the difference in milliseconds
        const differenceMs = Math.abs(date2 - date1);
        // Convert back to days and return
        return Math.round(differenceMs / ONE_DAY)+1;

    }
});