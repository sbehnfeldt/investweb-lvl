import $ from 'jQuery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";

$(async function () {

    const P = [AccountsApi.accounts(), FundsApi.funds(), TransactionsApi.transactions()]
    Promise.all(P)
        .then((values) => {
            const $accounts = $('.accounts');

            // Iterate through the Accounts
            values[0].forEach((account) => {
                console.log(`Account ${account.id}`);
                const $account = $('<div class="account">');

                $account.append('<h2>').text(account.company + ': ' + account.identifier);
                $accounts.append($account);

                // This account's transactions
                const transactions = values[2].filter((el) => {
                    return (el.account_id == account.id);
                });

                // Iterate through each fund, finding all transactions
                values[1].forEach((fund) => {
                    const t = transactions.filter((el) => {
                        return el.fund_id == fund.id;
                    });
                    if (!t) {
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
