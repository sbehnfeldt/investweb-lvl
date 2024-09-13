import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";
import QuotesApi from "@/quotes-api.js";

$(async function () {

    const buildTable = (funds, quotes, transactions) => {
        let $table = $('<table>');

        let $thead = $('<thead>');
        let $tr    = $('<tr>');
        $tr.append($('<th>').text('Fund'));
        $tr.append($('<th>').text('Current Value'));
        $tr.append($('<th>').text('Quantity'));
        $tr.append($('<th>').text('Current Price'));
        $thead.append($tr);
        $table.append($thead);

        let $tbody = $('<tbody>');

        funds.forEach((fund) => {
            const t = transactions.filter((el) => {
                return el.fund_id == fund.id;
            });
            if (!t.length) {
                return;
            }

            const q = t.reduce((acc, val) => acc + val.quantity, 0);

            const $tr = $('<tr>');
            $tr.append($('<td>').text(`${fund.symbol}`));
            $tr.append($('<td>').text(`$${(q * quotes[fund.id].price).toFixed(2)}`));
            $tr.append($('<td>').text(`${q.toFixed(3)}`));
            $tr.append($('<td>').text(`$${(quotes[fund.id].price).toFixed(2)}`));
            $tbody.append($tr);
        });
        $table.append($tbody);
        return $table;
    }

    const P = [AccountsApi.accounts(), FundsApi.funds(), TransactionsApi.transactions(), QuotesApi.latest()]
    Promise.all(P)
        .then((values) => {
            // Build an array mapping fund ID to fund
            const funds = [];
            values[1].forEach((fund) => {
                funds[fund.id] = fund;
            });

            // Build an array mapping fund ID to quote
            const quotes = [];
            values[3].forEach((quote) => {
                quotes[quote.fund_id] = quote;
            });

            // Iterate through the Accounts
            const $accounts = $('.accounts');
            values[0].forEach((account) => {
                const $account = $('<div class="account">');

                const $h2      = $('<h2>').text(`${account.company}  ${account.description} (${account.identifier})`);
                $account.append($h2);

                // This account's transactions
                const transactions = values[2].filter((el) => {
                    return (el.account_id == account.id);
                });

                $account.append(buildTable(funds, quotes, transactions));
                $accounts.append($account);
            });
        })
        .catch((err) => {
            console.error(err);
        });

});
