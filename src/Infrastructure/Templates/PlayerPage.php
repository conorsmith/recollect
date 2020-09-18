<div id="pageData" data-player-id="<?=$playerId?>" data-is-game-over="<?=$isGameOver?>"></div>

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
            <button type="submit" id="drawButton" class="btn btn-primary btn-game" <?=$canDrawCard ? "" : "disabled"?>>Draw Card</button>
        </form>
        <form method="POST" action="/player/<?=$playerId?>/win-face-off" style="margin: 0 0.2rem;">
            <button type="submit" id="faceOffButton" class="btn btn-primary btn-game" <?=$canCompeteInFaceOff ? "" : "disabled"?>>Win Face Off</button>
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

<template id="symbol-b379317c-d4df-4392-ae87-7eb54568387b"><?php require __DIR__ . "/Symbols/Circle.php"; ?></template>
<template id="symbol-2ad73bfd-9cf5-45c7-89dc-862f3e6fc4af"><?php require __DIR__ . "/Symbols/Diamond.php"; ?></template>
<template id="symbol-1b96336d-59fa-414d-b29b-b49823b90e14"><?php require __DIR__ . "/Symbols/Cross.php"; ?></template>

</body>
</html>
