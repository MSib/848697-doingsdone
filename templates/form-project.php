<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form"  action="project.php" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="project_name">Название <sup>*</sup></label>

    <input class="form__input<?=(isset($errors['name'])) ? ' form__input--error' : NULL;?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
    <?=(isset($errors['name'])) ? '<p class="form__message">' . $errors['name'] . '</p>' : NULL;?>
  </div>

  <div class="form__row form__row--controls">
    <?=(!empty($errors)) ? '<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>' : NULL;?>
    <input class="button" type="submit" name="" value="Добавить">
  </div>
</form>
