import $ from 'jquery';
import AccountsApi from "./accounts-api.js";
import FundsApi from "./funds-api.js";

$(async function () {

    // Fetch Accounts and Funds to fill in corresponding drop-down lists
    const $accountList = $('select[name=account_id]');
    const $fundList    = $('select[name=fund_id]');

    $('#cancelFormButton').on('click', function (e) {
        e.preventDefault();
        window.location.href = '/transactions';
    });

    Promise.all([AccountsApi.accounts(), FundsApi.funds()])
        .then((values) => {
            values[0].sort((a, b) => {
                if (`${a.company} ${a.description} (${a.identifier})` > `${b.company} ${b.description} (${b.identifier})`) {
                    return 1;
                }
                if (`${a.company} ${a.description} (${a.identifier})` < `${b.company} ${b.description} (${b.identifier})`) {
                    return -1;
                }
                return 0;
            }).forEach((account) => {
                $accountList.append($('<option>').attr('value', account.id).text(`${account.company} ${account.description} (${account.identifier})`))
            });

            values[1]
                .sort((a, b) => {
                    if (a.symbol > b.symbol) {
                        return 1;
                    }
                    if (a.symbol < b.symbol) {
                        return -1;
                    }
                    return 0;
                }).forEach((fund) => {
                $fundList.append($('<option>').attr('value', fund.id).text(fund.symbol));
            });

        });

});