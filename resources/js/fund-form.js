import $ from 'jquery';
import FundsApi from './funds-api.js';

$(async function () {
    let $form               = $('form');
    let $nameControl        = $form.find('[name=name]');
    let $symbolControl      = $form.find('[name=symbol]');
    let $assetClassControl  = $form.find('[name=asset_class]')
    let $descriptionControl = $form.find('[name=description]');

    const $submit = $('#submitFormButton');
    const $cancel = $('#cancelFormButton');


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

        let fund = await FundsApi.fund(id);
        $nameControl.val(fund.name);
        $symbolControl.val(fund.symbol);
        $assetClassControl.val(fund.asset_class);
        $descriptionControl.val(fund.description);
    }


    $cancel.on('click', function (e) {
        e.preventDefault();
        window.location.href = '/funds';
    });
});
