<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Recollect</title>

    <style>
        body {
            --stripe: #f8f8f8;
            --bg: #fcfcfc;

            background: linear-gradient(135deg, var(--bg) 25%, transparent 25%) -50px 0,
            linear-gradient(225deg, var(--bg) 25%, transparent 25%) -50px 0,
            linear-gradient(315deg, var(--bg) 25%, transparent 25%),
            linear-gradient(45deg, var(--bg) 25%, transparent 25%);
            background-size: 100px 100px;
            background-color: var(--stripe);
        }

        .code-letter {
            background-color: #fff;
            margin: 0 0.4rem;
            width: 3rem;
            line-height: 3rem;
            text-align: center;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }
    </style>

</head>
<body>

<div class="container" style="font-family: 'Hind', sans-serif;">

    <div style="max-width: 20rem; margin: 0 auto;">

        <h1 style="text-align: center; margin: 1rem auto; font-weight: 100; text-transform: uppercase; letter-spacing: 0.1rem;"><span style="color: #666;">Re</span>collect</h1>

        <hr>

        <div class="d-flex justify-content-center" style="font-weight: 100; font-size: 2.4rem; margin: 2rem 0;">
            <div class="code-letter"><?=$joinCode[0]?></div>
            <div class="code-letter"><?=$joinCode[1]?></div>
            <div class="code-letter"><?=$joinCode[2]?></div>
            <div class="code-letter"><?=$joinCode[3]?></div>
        </div>

        <div class="card" style="margin-bottom: 1rem; text-align: center;">
            <div class="card-body">
                <p><?=$numberOfPlayers?> player<?=$numberOfPlayers === 1 ? " has" : "s have"?> joined</p>

                <form method="POST" action="/seat/<?=$seatId?>/start-game">
                    <button type="submit" class="btn btn-primary btn-block" <?=$numberOfPlayers === 1 ? "disabled" : ""?>>Start Game</button>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
