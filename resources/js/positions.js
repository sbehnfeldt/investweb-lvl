import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";

$(async function () {

    const P = [AccountsApi.accounts(), FundsApi.funds(), TransactionsApi.transactions()]
    Promise.all(P)
        .then((values) => {
            // Build an array mapping fund ID to fund
            const funds = [];
            values[1].forEach((fund) => {
                funds[fund.id] = fund;
            });
            console.log(funds);

            // Iterate through the Accounts
            const $accounts = $('.accounts');
            values[0].forEach((account) => {
                const $account = $('<div class="account">');

                $account.append('<h2>').text(`${account.company}  ${account.description} ( ${account.identifier})`);
                $accounts.append($account);

                // This account's transactions
                const transactions = values[2].filter((el) => {
                    return (el.account_id == account.id);
                });


                values[1].forEach((fund) => {
                    const t = transactions.filter((el) => {
                        return el.fund_id == fund.id;
                    });
                    console.log(t);
                    if (!t.length) {
                        return;
                    }

                    const q = t.reduce((acc, val) => acc + val.quantity, 0);
                    $account.append($('<p>').text(`${fund.symbol}: ${q}`))
                });
            });
        })
        .catch((err) => {
            console.error(err);
        });

});
