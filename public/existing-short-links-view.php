<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tracked sites</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body {
            display: grid;
            justify-content: center;
            align-content: center;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        a {
            color: black;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        button {
            margin: 4px;
        }
    </style>
</head>
<body>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div id="tableRoot"></div>
<script>
    let serverURL = "http://" + window.location.hostname + ":8000";
    let request = new URLSearchParams([['action-name', 'get-links']]);

    axios({
        method: 'GET',
        url: serverURL,
        params: request
    }).then((response) => {
        let root = document.body;

        if (response.data.length === 0) {
            let note = document.createElement("div");
            note.innerHTML = "No existing short links";
            root.appendChild(note);
        } else {
            let tableRoot = document.getElementById("tableRoot");
            let baseTable = document.createElement("table");
            baseTable.innerHTML = '<table><th> </th><th>Long link</th><th>Short link</th><th>Creation date</th></table>';
            response.data.forEach((table) => {
                let deleteButton = document.createElement("button");
                deleteButton.innerText = "-";
                deleteButton.addEventListener("click", () => {
                    axios.post(serverURL, {
                        'action-name': 'delete-url',
                        'short_link': table.short_link
                    }).then(() => window.location.reload());
                });
                let regenerateButton = document.createElement("button");
                regenerateButton.innerText = "Regenerate";
                regenerateButton.addEventListener("click", () => {
                    axios.post(serverURL, {
                        'action-name': 'update-url',
                        'long_link': table.long_link
                    }).then(() => window.location.reload());
                });

                let longLink = document.createElement("a");
                longLink.href = table.long_link;
                longLink.text = longLink.href;

                let shortLink = document.createElement("a");
                shortLink.href = table.short_link;
                shortLink.text = shortLink.href;

                let row = document.createElement("tr");

                let buttonsContainer = document.createElement("td");
                let longLinkContainer = document.createElement("td");
                let shortLinkContainer = document.createElement("td");
                let dateContainer = document.createElement("td");

                dateContainer.innerText = table.creation_date;

                row.appendChild(buttonsContainer);
                row.appendChild(longLinkContainer);
                row.appendChild(shortLinkContainer);
                row.appendChild(dateContainer);

                buttonsContainer.appendChild(deleteButton);
                buttonsContainer.appendChild(regenerateButton);

                longLinkContainer.appendChild(longLink);

                shortLinkContainer.appendChild(shortLink);

                baseTable.appendChild(row);
            });
            tableRoot.appendChild(baseTable);
        }
    });

</script>
</body>
</html>
