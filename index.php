<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <?php include 'functions.php'; ?>

  <div class="container">
    <h1>Обработка строк</h1>
    <button class="btn btn-primary" id="update_btn" name="update_btn" onClick="window.location.reload( true );">Обновить страницу</button>

    <h2>ФИО в отдельных строках</h2>
    <?php
    $fullname = getPartsFromFullname($personID);
    echo $fullname['surname'] . '<br/>';
    echo $fullname['name'] . '<br/>';
    echo $fullname['patronomyc'];
    ?>

    <h2>ФИО в одной строке</h2>
    <?php
    $surname = $fullname['surname'];
    $name = $fullname['name'];
    $patronomyc = $fullname['patronomyc'];

    $person = getFullnameFromParts($surname, $name, $patronomyc);
    echo $person;
    ?>

    <h2>Сокращенное ФИО</h2>
    <?php
    $reduction = getShortName($personID);
    echo $reduction;
    ?>

    <h2>Гендерный состав аудитории:</h2>
    <?php
    getGenderDescription($example_persons_array);
    ?>

    <h2>Подбор пары из массива</h2>
    <?php
    getPerfectPartner($surname, $name, $patronomyc, $example_persons_array);
    ?>

    <h2>Подбор пары из формы</h2>

    <form method="POST" action="index.php">
      <div class="mb-3 row">
        <label for="input_surname" class="col-sm-2 col-form-label">Фамилия:</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="input_surname" id="input_surname" required placeholder="Ваша фамилия">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="input_name" class="col-sm-2 col-form-label">Имя:</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="input_name" id="input_name" required placeholder="Ваше имя">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="input_patronomyc" class="col-sm-2 col-form-label">Отчество:</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="input_patronomyc" id="input_patronomyc" required placeholder="Ваше отчество">
        </div>
      </div>

      <input type="submit" name="send" value="Отправить" class="btn btn-primary">
    </form>

    <br>

    <?php

    if (isset($_POST)) {
      $input_surname = isset($_POST['input_surname']) ? $_POST['input_surname'] : "Калита";
      $input_name = isset($_POST['input_name']) ? $_POST['input_name'] : "Иван";
      $input_patronomyc = isset($_POST['input_patronomyc']) ? $_POST['input_patronomyc'] : "Данилович";
      
      getPerfectPartner($input_surname, $input_name, $input_patronomyc, $example_persons_array);
    } ?>

  </div>

</body>

</html>