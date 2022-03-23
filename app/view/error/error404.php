<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 404 Page</title>
    <link href="https://fonts.googleapis.com/css?family=Anton|Passion+One|PT+Sans+Caption" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_ASSET . '/'; ?>error/styles.css">
    <link rel="shortcut icon" href="<?php echo BASE_ASSET . '/'; ?>error/error.png" type="image/png">
</head>

<body translate="no">
<!-- Error Page -->
<div class="error">
    <div class="container-fluid">
        <div class="col-xs-12 ground-color text-center">
            <div class="container-error-404">
                <div class="clip">
                    <div class="shadow"><span class="digit thirdDigit">4</span></div>
                </div>
                <div class="clip">
                    <div class="shadow"><span class="digit secondDigit">0</span></div>
                </div>
                <div class="clip">
                    <div class="shadow"><span class="digit firstDigit">4</span></div>
                </div>
            </div>
            <h2 class="h1">Sorry! Page not found</h2>
        </div>
    </div>
</div>
<!-- Error Page -->
<script id="rendered-js">
    function random() {
        return Math.floor(Math.random() * 9) + 1;
    }
    const selector1 = document.querySelector('.firstDigit');
    const selector2 = document.querySelector('.secondDigit');

    let loop1, loop2, loop3, time = 30, i = 0, number, selector3 = document.querySelector('.thirdDigit');

    loop3 = setInterval(function () {
        if (i > 40) {
            clearInterval(loop3);
            selector3.textContent = "4";
        } else {
            selector3.textContent = random();
            i++;
        }
    }, time);
    loop2 = setInterval(function () {
        if (i > 80) {
            clearInterval(loop2);
            selector2.textContent = "0";
        } else {
            selector2.textContent = random();
            i++;
        }
    }, time);
    loop1 = setInterval(function () {
        if (i > 100) {
            clearInterval(loop1);
            selector1.textContent = "4";
        } else {
            selector1.textContent = random();
            i++;
        }
    }, time);
</script>
</body>

</html>