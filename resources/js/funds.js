import $ from 'jquery';

async function fetchFunds() {
    try {

        const response = await fetch('/api/funds');
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const json = await response.json();
        return json;

    } catch (error) {
        console.error(error.message);
    }
}


$(async function () {

    const funds = await fetchFunds();
    funds.forEach((fund, index, array) => {
        const $tr = $('<tr>');
        $tr.append($('<td>').text(fund.symbol));
        $tr.append($('<td>').text(fund.name));
        $tr.append($('<td>').text(fund.description));
        $('table').append($tr);
    })


    $('table').on('click', 'tr', function () {
        $(this).closest('table').find('tr').removeClass('selected');
        $(this).addClass('selected');
    });
});


