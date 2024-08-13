import $ from 'jquery';

$(function () {

    $('table').on('click', 'tr', function () {
        console.log(this);
        console.log($(this));
        $(this).addClass('selected');
    });
});


