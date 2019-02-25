<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="add.php" method="post" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>

    <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите название">
  </div>

  <div class="form__row">
    <label class="form__label" for="project">Проект</label>

    <select class="form__input form__input--select" name="project" id="project">
      <?php foreach ($categories as $categories_value):?>
        <option value="<?=$categories_value['id'];?>"><?=$categories_value['title'];?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>

    <input class="form__input form__input--date" type="date" name="date" id="date" value="" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
  </div>

  <div class="form__row">
    <label class="form__label" for="preview">Файл</label>

    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="preview" id="preview" value="">

      <label class="button button--transparent" for="preview">
        <span>Выберите файл</span>
      </label>
    </div>
  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
  </div>
</form>
