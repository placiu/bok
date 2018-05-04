<div class="jumbotron mt-4">
    <div class="row">
        <div class="col">
            <h1 class="display-5">BIURO OBSŁUGI KLIENTA</h1>
            <p class="lead">Zaloguj się aby porozmawiać z naszym konsultantem.</p>
            <hr class="my-4">
            <p>Zarejestruj się, jeżeli nie posiadasz konta.</p>
            <p class="lead">
                <a class="btn btn-danger btn-lg" href="RegisterController.php" role="button">Rejestracja</a>
            </p>
        </div>
        <div class="col-5">
            <form class="form-signin" action="" method="POST">
                <h3>Zaloguj się</h3>
                <label for="login" class="sr-only">Login</label>
                <input type="text" id="login" name="login" class="form-control mt-5" placeholder="Login" title="Login" data-toggle="popover" data-trigger="focus" data-content="Min 3 znaki. Minimum jedna litera." data-placement="right" required>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control mt-2" placeholder="Hasło" title="Hasło" data-toggle="popover" data-trigger="focus" data-content="Min 6 znaków. Minimum jedna wielka litera i cyfra." data-placement="right" required>
                <button class="btn btn-lg btn-success btn-block mt-2" type="submit" disabled>Zaloguj się</button>
            </form>
        </div>
    </div>
</div>
