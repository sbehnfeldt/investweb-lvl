import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";
import QuotesApi from "@/quotes-api.js";

$(async function () {

    $('#newTransaction').on('click', () => window.location.href = '/transactions/create');

    const $newTransaction    = $('#newTransaction');
    const $viewTransaction   = $('#viewTransaction');
    const $editTransaction   = $('#editTransaction');
    const $deleteTransaction = $('#deleteTransaction');
    const $importTransaction = $('#importTransaction');

    const $table = $('table');
    const P      = [TransactionsApi.transactions(), AccountsApi.accounts(), FundsApi.funds(), QuotesApi.latest()]
    Promise.all(P)
        .then((values) => {

            // Map account ID to corresponding account
            let accountsMap = [];
            values[1].forEach((account) => {
                accountsMap[account.id] = account;
            });

            // Map fund ID to corresponding fund
            let fundsMap = [];
            values[2].forEach(async (fund) => {
                fundsMap[fund.id] = fund;
            });

            // Map fund ID to corresponding quote
            let quotesMap = [];
            values[3].forEach((quote) => {
                quotesMap[quote.fund_id] = quote;
            });


            // Construct table, one row per Transaction
            values[0].forEach((transaction) => {
                const $tr = $('<tr>');
                $tr.append($('<td>').text(accountsMap[transaction.account_id].company));
                $tr.append($('<td>').text(accountsMap[transaction.account_id].identifier));
                $tr.append($('<td>').text(fundsMap[transaction.fund_id].symbol));
                $tr.append($('<td>').text(transaction.acquired));
                $tr.append($('<td>').text(transaction.quantity));
                $tr.append($('<td>').text('$' + transaction.avg_cost_basis.toFixed(2)));
                $tr.append($('<td>').text('$' + (transaction.quantity * quotesMap[transaction.fund_id].price).toFixed(2)));


                $table.append($tr);
            });
        })
        .catch((err) => {
            console.error(err);
        });

    $newTransaction.on('click', () => window.location.href = '/transactions/create');
    $viewTransaction.on('click', () => window.location.href = '/transactions/' + $('table').find('tr.selected').data().id);
    $editTransaction.on('click', () => window.location.href = '/transactions/' + $('table').find('tr.selected').data().id + '/edit');
    $deleteTransaction.on('click', async function () {
        alert("Delete");
    });
    $importTransaction.on('click', () => window.location.href = '/transactions/import');
});

