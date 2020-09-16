<!doctype html>
<html lang="en" data-player-id="<?=$playerId?>" data-is-game-over="<?=$isGameOver?>">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Recollect</title>

    <style>
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
            font-family: 'Hind', sans-serif;
            font-size: 2rem;
            font-weight: 100;
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

        .symbol-circle {
            margin: 2.5rem auto;
            width: 6rem;
            height: 6rem;
            border-radius: 50%;
            border: 1rem solid #dd6c09;
        }

        .symbol-cross {
            margin: 2.5rem auto;
            background: #2cdd04;
            height: 6rem;
            position: relative;
            width: 2rem;
        }
        .symbol-cross:after {
            background: #2cdd04;
            content: "";
            height: 2rem;
            left: -2rem;
            position: absolute;
            top: 2rem;
            width: 6rem;
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
    </style>
</head>
<body>

<div class="surface d-flex justify-content-center align-items-center">

    <div class="card face-up-card"
         id="faceUpCard"
         style="<?=is_null($faceUpCard) ? "display: none;" : ""?>"
    >
        <div class="card-body d-flex justify-content-center align-items-center">
            <div>
            <div class="faceUpCard-category category-text"><?=$faceUpCard->category?></div>
            <div class="faceUpCard-symbol">
                <?php if (!is_null($faceUpCard)) : ?>
                    <?php require $faceUpCard->symbolTemplate; ?>
                <?php endif ?>
            </div>
            <div class="faceUpCard-category category-text" style="transform: rotateX(180deg) scale(-1, 1);"><?=$faceUpCard->category?></div>
            </div>
        </div>
    </div>

    <div id="emptyPlayPile"
         class="no-cards"
         style="<?=is_null($faceUpCard) ? "" : "display: none;" ?>"
    >
        You have no cards
    </div>

</div>

<div class="fixed-bottom" style="padding: 0.5rem; border-top: 1px solid #ddd; background-color: #fff;">
    <div class="d-flex justify-content-center">
        <form method="POST" action="/player/<?=$playerId?>/draw-card" style="margin: 0 0.2rem;">
            <button type="submit" id="drawButton" class="btn btn-primary" <?=$canDrawCard ? "" : "disabled"?>>Draw Card</button>
        </form>
        <form method="POST" action="/player/<?=$playerId?>/win-face-off" style="margin: 0 0.2rem;">
            <button type="submit" id="faceOffButton" class="btn btn-primary" <?=$canCompeteInFaceOff ? "" : "disabled"?>>Win Face Off</button>
        </form>
    </div>
</div>

<div class="modal" tabindex="-1" id="gameOverMessage">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="text-align: center;">
            <div class="modal-header">
                <h5 class="modal-title">Game Over</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong><?=$endOfGameStatus?></strong></p>
                <p>You won <?=$totalCardsWon?> card<?=$totalCardsWon === 1 ? "" : "s"?></p>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
    if ($("html").data("isGameOver") === 1) {
        $('#gameOverMessage').modal();
    }

    if ($("html").data("isGameOver") !== 1) {
        (function pollPlayerStatus() {
            $.ajax({
                method: "GET",
                url: "/player/" + $("html").data("playerId") + "/status",
                dataType: "json",
                success: function (response) {
                    console.log(response);

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
                        $("#drawButton").removeAttr("disabled");
                    } else {
                        $("#drawButton").attr("disabled", "disabled");
                    }

                    if (response.canCompeteInFaceOff) {
                        $("#faceOffButton").removeAttr("disabled");
                    } else {
                        $("#faceOffButton").attr("disabled", "disabled");
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
</script>

<template id="symbol-b379317c-d4df-4392-ae87-7eb54568387b"><?php require __DIR__ . "/Symbols/Circle.php"; ?></template>
<template id="symbol-2ad73bfd-9cf5-45c7-89dc-862f3e6fc4af"><?php require __DIR__ . "/Symbols/Diamond.php"; ?></template>
<template id="symbol-1b96336d-59fa-414d-b29b-b49823b90e14"><?php require __DIR__ . "/Symbols/Cross.php"; ?></template>

</body>
</html>
