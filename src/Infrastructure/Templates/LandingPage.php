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

        <div class="card" style="text-align: center;">
            <div class="card-body">
                <form method="POST" action="/join-table" autocomplete="off">
                    <div class="form-group">
                        <input type="text" class="form-control" name="code" maxlength="4" required placeholder="Join Code">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Play</button>
                </form>
            </div>
        </div>

        <div style="text-align: center; font-weight: 100; margin: 1rem auto;">OR</div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/open-table">
                    <button type="submit" class="btn btn-primary btn-block">Create New Game</button>
                </form>
            </div>
        </div>

    </div>

</div>
