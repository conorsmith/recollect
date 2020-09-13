<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Recollect</title>
</head>
<body>

<div class="container">

    <h1 style="text-align: center; margin-top: 0.4rem; margin-bottom: 1rem;">Recollect</h1>

    <div class="card" style="margin-bottom: 1rem; text-align: center;">
        <div class="card-body">
            <form method="POST" action="/open-table">
                <button type="submit" class="btn btn-primary">Create New Game</button>
            </form>
        </div>
    </div>

    <div class="card" style="text-align: center;">
        <div class="card-body">
            <form method="POST" action="/join-table">
                <div class="form-group">
                    <label for="exampleInputEmail1">Join Code</label>
                    <input type="text" class="form-control" name="code" maxlength="4">
                </div>
                <button type="submit" class="btn btn-primary">Join Game</button>
            </form>
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
