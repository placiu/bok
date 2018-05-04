<div class="jumbotron mt-4">
    <div class="row">
        <div class="col">
            <h1 class="display-5">BIURO OBSŁUGI KLIENTA</h1>
            <p class="lead">Utwórz konto, aby nawiązać kontakt z konsultantem.</p>
            <hr class="my-4">
            <p>Zaloguj się, jeżeli posiadasz już konto.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="LoginController.php" role="button">Zaloguj się</a>
            </p>
        </div>
        <div class="col-5">
            <form class="form-signin" action="" method="post">
                <h3>Zarejestruj się</h3>
                <label for="login" class="sr-only">Login</label>
                <input type="text" id="login" name="login" class="form-control mt-5" placeholder="Login" title="Login" data-toggle="popover" data-trigger="focus" data-content="Min 3 znaki. Minimum jedna litera." data-placement="right" required>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password1" name="password1" class="form-control mt-2" placeholder="Hasło" title="Hasło" data-toggle="popover" data-trigger="focus" data-content="Min 6 znaków. Minimum jedna wielka litera i cyfra." data-placement="right" required>
                <input type="password" id="password2" name="password2" class="form-control mt-2" placeholder="Powtórz hasło" title="Hasło" data-toggle="popover" data-trigger="focus" data-content="Hasła muszą być jednakowe!" data-placement="right" required>
                <button class="btn btn-lg btn-danger btn-block mt-2" type="submit" disabled>Zarejestruj</button>
            </form>
        </div>
    </div>
</div>