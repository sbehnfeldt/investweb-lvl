import $ from 'jquery';
import AccountsApi from "@/accounts-api.js";

$(async function () {
    const clearTable = () => $accountsTable.empty();

    const populateTable = (accounts) => {
        accounts.sort((a, b) => {
            if (a.company > b.company) {
                return 1;
            }
            if (a.company < b.company) {
                return -1;
            }
            return 0;
        }).forEach((account) => {
            const $tr = $('<tr>');
            $tr.append($('<td>').text(account.company));
            $tr.append($('<td>').text(account.identifier));
            $tr.append($('<td>').text(account.description));
            $tr.data(account);
            $accountsTable.append($tr);
        });

    }

    const $accountsTable = $('table');
    const accounts       = await AccountsApi.accounts();
    populateTable(accounts);

});
