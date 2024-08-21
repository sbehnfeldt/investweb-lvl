import $ from 'jquery';
import api from './funds-api.js';

$(async function () {
    console.log("Document ready");

    let $form               = $('form');
    let $nameControl        = $form.find('[name=name]');
    let $symbolControl      = $form.find('[name=symbol]');
    let $descriptionControl = $form.find('[name=description]');

    // Strip useless whitespace (if any) from the value in the "Description" text box.
    // Any whitespace between opening and closing tags of a <textarea> element
    // is interpreted as an actual value, not ignored (as we would prefer).
    // Some code formatters/prettiers might not account for this and so
    // may split the open and close tags onto separate lines.
    $descriptionControl.val($descriptionControl.val().trim());

    // See if we are creating a new fund record or editing an existing one
    let href = window.location.href.split('/');
    if ('edit' === href.pop()) {
        let id = href.pop();

        let fund = await api.fund(id);
        $nameControl.val(fund.name);
        $symbolControl.val(fund.symbol);
        $descriptionControl.val(fund.description);
    }


    const $submit = $('#submitFormButton');
    const $cancel = $('#cancelFormButton');

    $cancel.on('click', function (e) {
        e.preventDefault();
        window.location.href = '/funds';
    });
});
