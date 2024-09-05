import $ from 'jquery';
import AccountsApi from "@/accounts-api.js";

$(async function () {
    const clearTable = () => $resourceTable.empty();

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
    const $newAccount    = $('#newAccount');
    const $viewAccount   = $('#viewAccount');
    const $editAccount   = $('#editAccount');
    const $deleteAccount = $('#deleteAccount');

    const accounts = await AccountsApi.accounts();
    populateTable(accounts);

    $accountsTable.on('click', 'tr', function () {
        $(this).closest('table').find('tr').removeClass('selected');
        $(this).addClass('selected');
        $viewAccount.removeAttr('disabled');
        $editAccount.removeAttr('disabled');
        $deleteAccount.removeAttr('disabled');
    });

    $newAccount.on('click', () => window.location.href = '/accounts/create');
    $viewAccount.on('click', () => window.location.href = '/accounts/' + $('table').find('tr.selected').data().id);
    $editAccount.on('click', () => window.location.href = '/accounts/' + $('table').find('tr.selected').data().id + '/edit');

    $deleteAccount.on('click', async function () {
        $viewAccount.attr('disabled', true);
        $editAccount.attr('disabled', true);
        $deleteAccount.attr('disabled', true);
        await AccountsApi.delete($('table').find('tr.selected').data().id);
        clearTable();
        populateTable(await AccountsApi.accounts());
    });
});
