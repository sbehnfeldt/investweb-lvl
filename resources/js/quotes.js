import $ from 'jquery';
import QuotesApi from "@/quotes-api.js";

$(async function () {

    $('#fetchQuotes').on('click', () => window.location.href = '/quotes/fetch');

    const clearTable = () => {
        $table.find('tbody').empty();
    }

    const populateTable = (quotes) => {
        quotes.forEach((quote) => {
            const $tr = $('<tr>');
            $tr.append($('<td>').text(quote.symbol));
            $tr.append($('<td>').text(quote.latest_trading_day));
            $tr.append($('<td>').text(`$${quote.price}`));
            $table.append($tr);
        });
    };

    const $table = $('table');
    const quotes = await QuotesApi.latest();

    clearTable();
    populateTable(quotes.sort((a, b) => {
        if (a.latest_trading_day < b.latest_trading_day) return -1;
        if (a.latest_trading_day > b.latest_trading_day) return 1;
        return 0;
    }));
});