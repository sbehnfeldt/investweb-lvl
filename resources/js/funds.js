import $ from 'jquery';


$(async function () {

    async function fetchFunds() {
        try {

            const response = await fetch('/api/funds');
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            return json;

        } catch (error) {
            console.error(error.message);
        }
    }

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
            $tr.append($('<td>').text(fund.description));
            $tr.data(fund);
            $fundsTable.append($tr);
        });
    }

    function clearTable() {
        $fundsTable.empty();
    }

    const $newFund    = $('#newFund');
    const $viewFund   = $('#viewFund');
    const $editFund   = $('#editFund');
    const $deleteFund = $('#deleteFund');
    const $fundsTable = $('table');

    const funds = await fetchFunds();
    populateTable(funds);


    $('table').on('click', 'tr', function () {
        $(this).closest('table').find('tr').removeClass('selected');
        $(this).addClass('selected');
        $viewFund.removeAttr('disabled');
        $editFund.removeAttr('disabled');
        $deleteFund.removeAttr('disabled');
    });

    $newFund.on('click', function () {
        window.location.href = '/funds/create';
    });

    $viewFund.on('click', function () {
        const fund           = $('table').find('tr.selected').data();
        window.location.href = '/funds/' + fund.id
    });

    $editFund.on('click', function () {
        const fund           = $('table').find('tr.selected').data();
        window.location.href = '/funds/' + fund.id + '/edit'
    });

    $deleteFund.on('click', function () {
        const fund = $('table').find('tr.selected').data();

        fetch(`/funds/${fund.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(async data => {
                console.log("Success: ", data);
                clearTable();
                const funds = await fetchFunds();
                populateTable(funds);
            })
            .catch(error => {
                console.error("Error: ", error);
            });
    });
});
