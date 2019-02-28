<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="add.php" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>
    <input class="form__input<?=(isset($errors['name'])) ? ' form__input--error' : NULL;?>" type="text" name="name" id="name" value="<?=htmlspecialchars($task['name']) ?: NULL?>" placeholder="Введите название">
    <?=(isset($errors['name'])) ? '<p class="form__message">' . $errors['name'] . '</p>' : NULL;?>
  </div>

  <div class="form__row">
    <label class="form__label" for="project">Проект</label>
    <select class="form__input form__input--select<?=(isset($errors['project'])) ? ' form__input--error' : NULL;?>" name="project" id="project">
      <?php foreach ($categories as $categories_value):?>
        <option value="<?=$categories_value['id'];?>"<?=($task['project'] === $categories_value['id']) ? 'selected' : NULL?>><?=$categories_value['title'];?></option>
      <?php endforeach; ?>
    </select>
    <?=(isset($errors['project'])) ? '<p class="form__message">' . $errors['project'] . '</p>' : NULL;?>
  </div>

  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>
    <input class="form__input form__input--date<?=(isset($errors['date'])) ? ' form__input--error' : NULL;?>" type="date" name="date" id="date" value="<?=($task['date'] && !$errors['date']) ? $date_value = date('Y-m-d', strtotime(strip_tags($task['date']))) : NULL;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?=(isset($errors['date'])) ? '<p class="form__message">' . $errors['date'] . '</p>' : NULL;?>
  </div>

  <div class="form__row">
    <label class="form__label " for="preview">Файл</label>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="preview" id="preview" value="">
      <label class="button button--transparent<?=(isset($errors['preview'])) ? ' form__input--error' : NULL;?>" for="preview">
        <span>Выберите файл</span>
      </label>
    </div>
    <?=(isset($errors['preview'])) ? '<p class="form__message">' . $errors['preview'] . '</p>' : NULL;?>
  </div>
<?=(!empty($errors)) ? '<p style="font-style: italic; color: #f84646;">Пожалуйста, исправьте ошибки в форме</p>' : NULL;?>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
  </div>
</form>
