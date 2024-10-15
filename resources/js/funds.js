import $ from 'jquery';
import FundsApi from "@/funds-api.js";

$(async function () {

    function populateTable(funds) {
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
            $tr.append($('<td>').text(fund.asset_class ? fund.asset_class.charAt(0).toUpperCase() + fund.asset_class.slice(1) : ''));
            $tr.data(fund);
            $fundsTable.append($tr);
        });
    }

    function clearTable() {
        $fundsTable.empty();
    }

    const $newFund    = $('#newResource');
    const $viewFund   = $('#viewResource');
    const $editFund   = $('#editResource');
    const $deleteFund = $('#deleteResource');
    const $fundsTable = $('table');

    const funds = await FundsApi.funds();
    populateTable(funds);


    $fundsTable.on('click', 'tr', function () {
        $(this).closest('table').find('tr').removeClass('selected');
        $(this).addClass('selected');
        $viewFund.removeAttr('disabled');
        $editFund.removeAttr('disabled');
        $deleteFund.removeAttr('disabled');
    });

    $newFund.on('click', () => window.location.href = '/funds/create');
    $viewFund.on('click', () => window.location.href = '/funds/' + $('table').find('tr.selected').data().id);
    $editFund.on('click', () => window.location.href = '/funds/' + $('table').find('tr.selected').data().id + '/edit');

    $deleteFund.on('click', async function () {
        $viewFund.attr('disabled', true);
        $editFund.attr('disabled', true);
        $deleteFund.attr('disabled', true);
        await FundsApi.delete($('table').find('tr.selected').data().id);
        clearTable();
        populateTable(await FundsApi.funds());
    });
});
