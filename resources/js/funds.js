import $ from 'jquery';


$(async function () {

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

    const $newFund    = $('#newFund');
    const $editFund   = $('#editFund');
    const $deleteFund = $('#deleteFund');

    const funds = await fetchFunds();
    funds.sort((a, b) => {
        if (a.symbol > b.symbol) {
            return 1;
        }
        if (a.symbol < b.symbol) {
            return -1;
        }
        return 0;
    }).forEach((fund) => {
        const $tr = $('<tr>');
        $tr.append($('<td>').text(fund.symbol));
        $tr.append($('<td>').text(fund.name));
        $tr.append($('<td>').text(fund.description));
        $tr.data(fund);
        $('table').append($tr);
    });


    $('table').on('click', 'tr', function () {
        $(this).closest('table').find('tr').removeClass('selected');
        $(this).addClass('selected');
        $editFund.removeAttr('disabled');
        $deleteFund.removeAttr('disabled');
    });

    $newFund.on('click', function () {
        window.location.href = '/funds/create';
    });

    $editFund.on('click', function () {
        const fund           = $('table').find('tr.selected').data();
        window.location.href = '/funds/' + fund.id + '/edit'
    });

    $deleteFund.on('click', function () {
        const fund = $('table').find('tr.selected').data();
        alert(`Delete fund ${fund.symbol}`);
    });
});
