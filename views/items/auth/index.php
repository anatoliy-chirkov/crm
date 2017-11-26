    <div class="container auth">
        <div class="col-sm-3 col-sm-offset-4 col-xs-12">
            <h2>My CRM</h2>
            <form class="form-signin" role="form" method="POST">
                <div class="form-group">
                    <input name="name" type="text" class="form-control" placeholder="Имя" required autofocus>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Пароль" required>
                </div>
                <input name="auth" type="hidden" value="true">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
            <br>
            <?php if ($_POST['name']) { echo "Неверное имя пользователя или пароль!"; } ?>
        </div>
    </div> <!-- /container -->