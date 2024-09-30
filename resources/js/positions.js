import $ from 'jquery';
import TransactionsApi from "@/transactions-api.js";
import FundsApi from "@/funds-api.js";
import AccountsApi from "@/accounts-api.js";
import QuotesApi from "@/quotes-api.js";

$(async function () {

    const fundsMap  = [];
    const quotesMap = [];


    // Calculate the future value of a transaction.
    // This is simply the standard foruma: V' = Ve^(rt) customized for this application
    const calculateFutureValue = ({avg_cost_basis, quantity, acquired}, latest_trading_day, rate) => {
        const P = avg_cost_basis * quantity;
        const T = (new Date(latest_trading_day) - new Date(acquired)) / (1000 * 60 * 60 * 24); // Time interval in ms
        return P * Math.pow(Math.E, (rate / 365.25) * T);
    }

    // Determine how close one value (the guess) is to another value (the tru value)
    const epsilon = (vTrue, vGuess) => {
        return Math.abs((vTrue - vGuess) / vTrue);
    }


    /**
     * Calculate and return the ROI based on a single investment
     *
     * @param quantity
     * @param avg_cost_basis
     * @param acquired
     * @param totalQuantity
     * @param latest_trading_day
     * @param price
     * @returns {number}
     */
    const getSimpleAnnualizedRoi = (
        {quantity, avg_cost_basis, acquired},
        totalQuantity,
        {latest_trading_day, price}) => {

        const initialValue     = quantity * avg_cost_basis;
        const currentValue     = totalQuantity * price;
        const initialDate      = new Date(acquired);
        const currentDate      = new Date(latest_trading_day);
        const differenceInMs   = currentDate - initialDate;
        const differenceInDays = differenceInMs / (1000 * 60 * 60 * 24);

        return (Math.pow(currentValue / initialValue, 365.25 / differenceInDays) - 1);
    }


    /**
     * Calculate and return the annualized ROI of multiple distinct investments
     *
     * @param transactions
     * @param totalQty
     * @param latest_trading_day
     * @param price
     * @returns {number}
     */
    const getXirr = (transactions, totalQty, {latest_trading_day, price}) => {


        // First, for each day on which any money was invested,
        // calculate what the return WOULD have been if ALL the money had been invested on that day
        const total_cost_basis = transactions.reduce((acc, cur) => acc + (cur.avg_cost_basis * cur.quantity), 0);
        const rois             = transactions.map((t) => getSimpleAnnualizedRoi({
            quantity: 1,
            avg_cost_basis: total_cost_basis,
            acquired: t.acquired
        }, totalQty, {latest_trading_day, price}))


        // Pick the highest and lowest of those returns; the actual return must be in between
        let roi0 = Math.min(...rois);
        let roi1 = Math.max(...rois);
        if (roi0 === roi1) {
            return roi0;
        }

        let pv;
        let roi;

        // Repeatedly calculate what the present value of all the transactions for the fund WOULD be
        // for the current lowest and highest guesses at the ROI.
        // Calculate a new ROI guess based upon how close the true present value is to each of the high and low guesses.
        // Calculate what the present value of all the transactions for the fund WOULD be
        // for that new guess at ROI.
        // Determine how close that value is to the true present value:
        // - if too high, reduce the upper ROI;
        // - if too low, increase the lower ROI;
        // - if within some specified tolerance ("epsilon"), then... well, close enough, and return the ROI guess.
        do {
            // Calculate what the present value would have been
            // if all the money were invested at the LOWEST rate of return
            let pv0 = transactions.reduce((acc, cur) => {
                return acc + calculateFutureValue(cur, latest_trading_day, roi0);
            }, 0);

            // Calculate what the present value would have been
            // if all the money were invested at the HIGHEST rate of return
            let pv1 = transactions.reduce((acc, cur) => {
                return acc + calculateFutureValue(cur, latest_trading_day, roi1);
            }, 0);
            // console.log(`${Number(100 * roi0).toFixed(2)}% => $${Number(pv0).toFixed(2)}, ${Number(100 * roi1).toFixed(2)}% => $${Number(pv1).toFixed(2)}`);


            let ratio = ((totalQty * price) - pv0) / (pv1 - pv0);
            roi       = roi0 + (ratio * (roi1 - roi0));
            pv        = transactions.reduce((acc, cur) => {
                return acc + calculateFutureValue(cur, latest_trading_day, roi);
            }, 0);
            // console.log(`${Number(totalQty * price).toFixed(2)}: ${Number(100 * roi).toFixed(2)} => $${Number(pv).toFixed(2)}: ${Math.abs(pv / (totalQty * price))}`);

            if (pv > totalQty * price) {
                roi1 = roi;
            } else {
                roi0 = roi;
            }
            // console.log(epsilon(totalQty * price, pv));

        } while (epsilon(totalQty * price, pv) > .0001);

        // console.log(`*** ${Number(100 * roi).toFixed(2)} ***`)
        return roi;
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

            console.log(fund.symbol);

            const q = t.reduce((acc, val) => acc + val.quantity, 0);

            const $tr = $('<tr>');
            $tr.append($('<td>').text(`${fund.symbol}`));
            $tr.append($('<td>').text(`$${(q * quotes[fund.id].price).toFixed(2)}`));
            $tr.append($('<td>').text(`${q.toFixed(3)}`));
            $tr.append($('<td>').text(`$${(quotes[fund.id].price).toFixed(2)}`));
            $tr.append($('<td>').text(Number(100 * getAnnualizedRoi(t, quotes[fund.id])).toFixed(2) + '%'));
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
