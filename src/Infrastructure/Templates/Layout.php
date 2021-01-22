<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <title>Recollect</title>

    <style>

        .logo {
            text-align: center;
            margin: 1rem auto;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }
        .logo span {
            color: #4563a7;
        }

        .btn {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .btn-game {
            font-weight: 500;
            font-size: 1rem;
        }

        .code-letter {
            background-color: #fff;
            margin: 0 0.4rem;
            width: 3rem;
            line-height: 3rem;
            text-align: center;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            font-weight: 800;
        }

        .surface {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-radial-gradient(
                    circle at center,
                    #fcfcfc,
                    #fcfcfc 20px,
                    #f8f8f8 20px,
                    #f8f8f8 40px
            );
        }

        .no-cards {
            font-family: 'Alegreya Sans', sans-serif;
            font-size: 2rem;
            font-weight: 300;
        }

        .face-up-card {
            margin: 1rem auto;
            width: 20rem;
            min-height: 30rem;
        }

        .category-text {
            line-height: 1.2;
            font-family: 'Hind', sans-serif;
            font-size: 3rem;
            font-weight: 500;
            text-align: center;
        }

        .symbol-asterisk {
            margin: 2.5rem auto;
            width: 6rem;
            height: 6rem;
        }
        .symbol-asterisk .cross {
            background: #ab550f;
            height: 6rem;
            margin-left: 2.5rem;
            position: relative;
            width: 1rem;
        }
        .symbol-asterisk .cross:after {
            background: #ab550f;
            content: "";
            height: 1rem;
            margin-left: -2.5rem;
            position: absolute;
            top: 2.5rem;
            width: 6rem;
        }
        .symbol-asterisk .rotated-cross {
            background: #ab550f;
            height: 6rem;
            margin-left: 2.5rem;
            margin-top: -6rem;
            position: relative;
            width: 1rem;
            transform: rotateY(0deg) rotate(45deg);
        }
        .symbol-asterisk .rotated-cross:after {
            background: #ab550f;
            content: "";
            height: 1rem;
            margin-left: -2.5rem;
            position: absolute;
            top: 2.5rem;
            width: 6rem;
        }

        .symbol-circle {
            margin: 2.5rem auto;
            width: 6rem;
            height: 6rem;
            border-radius: 50%;
            border: 1rem solid #dd6c09;
        }

        .symbol-diamond {
            margin: 2.5rem auto;
            width: 0;
            height: 0;
            border: 3rem solid transparent;
            border-bottom-color: #ffe600;
            position: relative;
            top: -3rem;
        }
        .symbol-diamond:after {
            content: '';
            position: absolute;
            left: -3rem;
            top: 3rem;
            width: 0;
            height: 0;
            border: 3rem solid transparent;
            border-top-color: #ffe600;
        }

        .symbol-dots {
            margin: 2.5rem auto;
            width: 6rem;
            height: 6rem;
        }
        .symbol-dots .dot {
            float: left;
            margin: 0.2rem;
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 50%;
            background-color: #dd093a;
        }

        .symbol-grate {
            margin: 2.5rem auto;
            width: 6rem;
            height: 6rem;
        }
        .symbol-grate .horizontal-lines {
            padding-top: 0.5rem;
        }
        .symbol-grate .horizontal-line {
            background-color: #0a72f3;
            height: 1rem;
            width: 6rem;
            margin-bottom: 1rem;
        }
        .symbol-grate .vertical-lines {
            margin-top: -6.5rem;
            padding-left: 0.5rem;
        }
        .symbol-grate .vertical-line {
            float: left;
            background-color: #0a72f3;
            height: 6rem;
            width: 1rem;
            margin-right: 1rem;
        }
        .symbol-grate .vertical-line:last-child {
            margin-right: 0;
        }

        .symbol-lines {
            margin: 2.5rem auto;
            width: 5rem;
            height: 6rem;
        }
        .symbol-lines .line {
            float: left;
            width: 1.5rem;
            height: 6rem;
            background-color: #d03dce;
        }
        .symbol-lines .line:first-child {
            margin-right: 2rem;
        }

        .symbol-plus {
            margin: 2.5rem auto;
            background: #2cdd04;
            height: 6rem;
            position: relative;
            width: 2rem;
        }
        .symbol-plus:after {
            background: #2cdd04;
            content: "";
            height: 2rem;
            left: -2rem;
            position: absolute;
            top: 2rem;
            width: 6rem;
        }

        .symbol-waves {
            margin: 2.3rem auto 2.5rem;
            width: 6rem;
            height: 6rem;
        }

        .symbol-waves .wave {
            height: 4rem;
            background: linear-gradient(135deg, #c64ac4 25%, transparent 25%) -4rem -2rem,
            linear-gradient(-135deg, #c64ac4 25%, transparent 25%) -4rem -2rem,
            linear-gradient(45deg, #c64ac4 25%, transparent 25%) -2rem -2rem,
            linear-gradient(-45deg, #c64ac4 25%, transparent 25%) -2rem -2rem;
            background-size: 4rem 4rem;
            transform: scaleY(0.8);
        }

        .symbol-waves .wave:last-child {
            margin-top: -1rem;
        }
    </style>
</head>
<body>

<?=$content?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
    if ($("#pageData").length > 0) {
        if ($("#pageData").data("isGameOver") === 1) {
            $('#gameOverMessage').modal();
        }

        let debuggingInactivePage = (new URLSearchParams(window.location.search)).get('inactive') !== null;

        if ($("#pageData").data("isGameOver") !== 1
            && !debuggingInactivePage
        ) {
            (function pollPlayerStatus() {
                $.ajax({
                    method: "GET",
                    url: "/player/" + $("#pageData").data("playerId") + "/status",
                    dataType: "json",
                    success: function (response) {
                        if (response.faceUpCard === null) {
                            $("#emptyPlayPile").show();
                            $("#faceUpCard").hide();
                        } else {
                            $("#faceUpCard .faceUpCard-category").text(response.faceUpCard.category);
                            $("#faceUpCard .faceUpCard-symbol").html(
                                $("#symbol-" + response.faceUpCard.symbolId).html()
                            );
                            $("#faceUpCard").show();
                            $("#emptyPlayPile").hide();
                        }

                        if (response.canDrawCard) {
                            $("#drawButton").show();
                        } else {
                            $("#drawButton").hide();
                        }

                        if (response.canCompeteInFaceOff) {
                            $("#faceOffButton").show();
                        } else {
                            $("#faceOffButton").hide();
                        }

                        if (response.isGameOver) {
                            location.reload();
                        }
                    },
                    complete: function () {
                        setTimeout(function () {
                            pollPlayerStatus()
                        }, 1000);
                    },
                    timeout: 500
                });
            })();
        }
    }
</script>

</body>
</html>
