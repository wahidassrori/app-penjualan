<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button id="new">New Tab</button>

    <script>
        const baru = document.querySelector('#new');

        baru.addEventListener('click', () => {
            window.open('invoice_pdf.php', '_blank');
        });
    </script>


</body>

</html>