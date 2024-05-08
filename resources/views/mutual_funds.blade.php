<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/style.css">

        <!-- Fonts -->

        <!-- Styles -->
        <style></style>

        <title>InvestWeb</title>
    </head>

    <body>
        <header>
            <nav>
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/mutual_funds">Mutual Funds</a>
                    </li>
                </ul>
            </nav>
        </header>

        <main>
            <h1>Mutual Funds</h1>
            <table>
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </main>

        <footer></footer>

    </body>
</html>
