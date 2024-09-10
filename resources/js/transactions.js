import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";

$(async function () {

    $('#newTransaction').on('click', () => window.location.href = '/transactions/create');

    const $table = $('table');
    const P      = [TransactionsApi.transactions(), AccountsApi.accounts(), FundsApi.funds()]
    Promise.all(P)
        .then((values) => {

            let accounts = [];
            values[1].forEach((account) => {
                accounts[account.id] = account;
            });

            let funds = [];
            values[2].forEach(async (fund) => {
                funds[fund.id]  = fund;
                fund.fetchQuote = fetch('/api/quotes/' + fund.symbol);
            });

            let responses = funds.map((fund) => fund.fetchQuote);

            Promise.all(responses)
                .then((quotes) => {

                })


            // Iterate through the Accounts
            values[0].forEach((transaction) => {
                const $tr = $('<tr>');
                $tr.append($('<td>').text(accounts[transaction.account_id].company));
                $tr.append($('<td>').text(accounts[transaction.account_id].identifier));
                $tr.append($('<td>').text(funds[transaction.fund_id].symbol));
                $tr.append($('<td>').text(transaction.acquired));
                $tr.append($('<td>').text(transaction.quantity));
                $tr.append($('<td>').text(transaction.avg_cost_basis));
                $tr.append($('<td>').text(funds[transaction.fund_id].value));


                $table.append($tr);
            });
        })
        .catch((err) => {
            console.error(err);
        });

});
