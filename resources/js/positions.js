import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";
import QuotesApi from "@/quotes-api.js";

$(async function () {

    const fundsMap  = [];
    const quotesMap = [];


    /**
     * Calculate and return the ROI based on a single investment
     *
     * @param transactions
     * @param totalQuantity
     * @param latest_trading_day
     * @param price
     * @returns {number}
     */
    const getSimpleAnnualizedRoi = ({quantity, avg_cost_basis, acquired}, totalQuantity, {
        latest_trading_day,
        price
    }) => {

        const initialValue     = quantity * avg_cost_basis;
        const currentValue     = totalQuantity * price;
        const initialDate      = new Date(acquired);
        const currentDate      = new Date(latest_trading_day);
        const differenceInMs   = currentDate - initialDate;
        const differenceInDays = differenceInMs / (1000 * 60 * 60 * 24);

        return (Math.pow(currentValue / initialValue, 365.25 / differenceInDays) - 1) * 100;
    }

    /**
     * Calculate and return the ROI based upon multiple distinct investments
     *
     * @param transactions
     * @param totalQty
     * @param latest_trading_day
     * @param price
     * @returns {number}
     */
    const getXirr = (transactions, totalQty, {latest_trading_day, price}) => {

        return 0;
    }


    /**
     * Get the return on investment for one or more transactions based upon a quote containing the current price
     *
     * @param transactions All transactions for a given fund (including transactions with 0 cost basis)
     * @param quote The market price for a fund on a specified date
     *
     * @returns {number}
     */
    const getAnnualizedRoi = (transactions, quote) => {

        // Total number of shares in a fund, based on all transactions
        const quantity = transactions.reduce((acc, cur) => acc + cur.quantity, 0);

        // Total number of actual investments (ie, filter out transactions resulting from dividend re-investment)
        const t = transactions.filter((el) => el.avg_cost_basis !== 0);

        if (1 === t.length) {
            // Total number of shares of this fund
            return getSimpleAnnualizedRoi(t[0], quantity, quote);
        }

        return getXirr(t, quantity, quote);
    }

    /**
     * Build an HTML table summarizing holdings of each fund in the account
     *
     * @param account  The account to build the table for
     * @param funds All the funds
     * @param quotes All the quotes
     * @param transactions  All the transactions associated with this account
     * @returns {*|jQuery|HTMLElement}
     */
    const buildTable = (account, funds, quotes, transactions) => {
        let $table = $('<table>');

        let $thead = $('<thead>');
        let $tr    = $('<tr>');
        $tr.append($('<th>').text('Fund'));
        $tr.append($('<th>').text('Current Value'));
        $tr.append($('<th>').text('Quantity'));
        $tr.append($('<th>').text('Current Price'));
        $tr.append($('<th>').text('Annualized ROI'));
        $thead.append($tr);
        $table.append($thead);

        let $tbody = $('<tbody>');

        funds.forEach((fund) => {
            const t = transactions.filter((el) => {
                return el.account_id == account.id && el.fund_id == fund.id;
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
            $tr.append($('<td>').text(Number(getAnnualizedRoi(t, quotes[fund.id])).toFixed(2) + '%'));
            $tbody.append($tr);
        });
        $table.append($tbody);
        return $table;
    }

    //
    const calculateAccountValue = (transactions) => {
        let accountValue = 0;
        fundsMap.forEach((fund) => {
            const t = transactions.filter((el) => {
                return el.fund_id === fund.id;
            });
            if (!t.length) {
                return;
            }
            const q = t.reduce((acc, val) => acc + val.quantity, 0);
            accountValue += q * quotesMap[fund.id].price;
        });
        return accountValue;

    }

    /**
     *
     * @param account The account being built around
     * @param transactions The specified account's transactions
     * @returns {*|jQuery|HTMLElement}
     */
    const buildAccountSection = (account, transactions) => {
        const $account = $('<section class="account">');

        const $h3 = $('<h3>').text(`${account.company}  ${account.description} (${account.identifier})`);
        $account.append($h3);

        $account.append($('<p>').text(`Account Value: $${parseFloat(calculateAccountValue(transactions).toFixed(2)).toLocaleString('en-US')}`));

        $account.append(buildTable(account, fundsMap, quotesMap, transactions));

        return $account;
    }


    // Fetch accounts, funds, transactions and latest quotes from the server,
    // then build the page once all of the calls are returned
    const P = [AccountsApi.accounts(), FundsApi.funds(), TransactionsApi.transactions(), QuotesApi.latest()]
    Promise.all(P)
        .then((values) => {

            // Map fund ID to the fund
            values[1].forEach((fund) => {
                fundsMap[fund.id] = fund;
            });

            // Map fund ID to its latest quote
            values[3].forEach((quote) => {
                quotesMap[quote.fund_id] = quote;
            });

            // Build an "account" <section> for each account
            const $accounts = $('.accounts');

            values[0].forEach((account) => {
                $accounts.append(buildAccountSection(account, values[2].filter((el) => {
                    return (el.account_id === account.id);
                })));
            });
        })
        .catch((err) => {
            console.error(err);
        });
});
