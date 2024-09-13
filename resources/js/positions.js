import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";
import QuotesApi from "@/quotes-api.js";

$(async function () {

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


                // $account.append($('<h2>');
                $account.append($h2);

                // This account's transactions
                const transactions = values[2].filter((el) => {
                    return (el.account_id == account.id);
                });


                const $ul = $('<ul>');
                values[1].forEach((fund) => {
                    const t = transactions.filter((el) => {
                        return el.fund_id == fund.id;
                    });
                    if (!t.length) {
                        return;
                    }

                    const q = t.reduce((acc, val) => acc + val.quantity, 0);

                    $ul.append($('<li>').text(`${fund.symbol}: $${(q * quotes[fund.id].price).toFixed(2)} (${q.toFixed(3)} @ $${(quotes[fund.id].price).toFixed(2)})`))
                });
                $account.append($ul);
                $accounts.append($account);
            });
        })
        .catch((err) => {
            console.error(err);
        });

});
