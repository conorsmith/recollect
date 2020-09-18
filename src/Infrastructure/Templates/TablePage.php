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
</style>

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
