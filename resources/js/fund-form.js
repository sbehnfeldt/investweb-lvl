import $ from 'jquery';

$(function () {
    console.log("Document ready");

    const $submit = $('#submitFormButton');
    const $cancel = $('#cancelFormButton');

    $cancel.on('click', function (e) {
        e.preventDefault();
        window.location.href = '/funds';
    });
});