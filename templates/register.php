<h2 class="content__main-heading">Регистрация аккаунта</h2>

<form class="form" action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>
        <input class="form__input<?=(isset($errors['email'])) ? ' form__input--error' : NULL;?>" type="text" name="email" id="email" value="<?=htmlspecialchars($register['email']) ?: NULL?>" placeholder="Введите e-mail">
        <?=(isset($errors['email'])) ? '<p class="form__message">' . $errors['email'] . '</p>' : NULL;?>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>
        <input class="form__input<?=(isset($errors['password'])) ? ' form__input--error' : NULL;?>" type="password" name="password" id="password" value="<?=htmlspecialchars($register['password']) ?: NULL?>" placeholder="Введите пароль">
        <?=(isset($errors['password'])) ? '<p class="form__message">' . $errors['password'] . '</p>' : NULL;?>
    </div>

    <div class="form__row">
        <label class="form__label" for="name">Имя <sup>*</sup></label>
        <input class="form__input<?=(isset($errors['name'])) ? ' form__input--error' : NULL;?>" type="password" name="name" id="name" value="<?=htmlspecialchars($register['name']) ?: NULL?>" placeholder="Введите пароль">
        <?=(isset($errors['name'])) ? '<p class="form__message">' . $errors['name'] . '</p>' : NULL;?>
    </div>

    <div class="form__row form__row--controls">
        <?=(!empty($errors)) ? '<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>' : NULL;?>
        <input class="button" type="submit" name="" value="Зарегистрироваться">
    </div>
</form>
