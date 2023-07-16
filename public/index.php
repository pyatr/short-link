<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Short links</title>

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

        a {
            color: black;
        }
    </style>
</head>
<body>
<a href="existing-short-links-view.php" style="margin-top: 16px">View existing short links</a>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    function isValidHttpUrl(possibleURL) {
        let url;
        try {
            url = new URL(possibleURL);
        } catch (_) {
            return false;
        }
        return url.protocol === "http:" || url.protocol === "https:" || url.startsWith("www");
    }

    let serverURL = "http://" + window.location.hostname + ":8000";
    if (window.location.pathname === "" || window.location.pathname === "/") {
        let form = document.createElement("form");
        form.id = "url-addition-form";
        form.method = "post";
        form.innerHTML = '<label for="url_to_shorten">Enter URL</label><br>' +
            '<input type="text" id="url_to_shorten" name="url_to_shorten"><br>' +
            '<input type="hidden" name="action-name" value="add-url">' +
            '<input type="submit" style="margin-top: 1rem" value="Submit"><br></form>';
        document.body.appendChild(form);
        form.addEventListener('submit', function (e) {
            const errors = [];

            let formData = new FormData(form);

            let urlInput = document.getElementById("url_to_shorten");
            let urlData = formData.get("url_to_shorten");

            urlInput.style.borderColor = "#000000";
            if (urlData === "") {
                urlInput.style.borderColor = "#FF0000";
                errors.push("No URL");
            }

            if (!isValidHttpUrl(urlData)) {
                urlInput.style.borderColor = "#FF0000";
                errors.push("Is not URL");
            }

            e.preventDefault();
            if (errors.length > 0) {
                return;
            }

            axios.post(serverURL, formData).then((response) => {
                let message = document.createElement("div");
                if (response.data !== "failed") {
                    let link = response.data;
                    message.innerHTML = `Your short link is </br><a href="${link}">${link}</a>`;
                } else {
                    message.innerHTML = 'Failed to create short link';
                }
                document.body.removeChild(form);
                document.body.appendChild(message);
            });
        });
    } else {
        let request = new URLSearchParams([['action-name', 'get-long-link'], ['short_link', window.location.pathname.replace(/\//,'')]]);

        axios({
            method: 'GET',
            url: serverURL,
            params: request
        }).then((response) => {
            window.open(response.data, "_self");
        });
    }
</script>
</body>
</html>
