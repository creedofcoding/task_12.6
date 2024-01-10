<?php
//исходный массив
$example_persons_array = [
    [
        'fullname' => 'ИвАНов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'СтеПАНова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'ПАЩенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'ГРОМОВ Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'СЛаВин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'ЦОЙ Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'БыСТрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'ЛогиНова Маргарита Антоновна',
        'job' => 'UI/UX designer',
    ],
    [
        'fullname' => 'ШМАТКО Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'БАРДО Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'ШварцНЕГЕР Арнольд Густавович',
        'job' => 'babysitter',
    ],
    [
        'fullname' => 'Hello World Worldovic',
        'job' => 'babysitter',
    ],
];


$personID = $example_persons_array[random_int(0, count($example_persons_array) - 1)]['fullname'];

function getPartsFromFullname($fullName){
    $exploded = explode(" ", $fullName);
    $separated = [
        'surname' => mb_convert_case($exploded[0], MB_CASE_TITLE, "UTF-8"),
        'name' => mb_convert_case($exploded[1], MB_CASE_TITLE, "UTF-8"),
        'patronomyc' => mb_convert_case($exploded[2], MB_CASE_TITLE, "UTF-8"),
    ];

    return $separated;
}

function getFullnameFromParts($surname, $name, $patronomyc){
    $surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8");
    $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE, "UTF-8");

    $fullName = [$surname, $name, $patronomyc];
    return implode(' ', $fullName);
}

function getShortName($fullName){
    $separated = getPartsFromFullname($fullName);
    $short_name = $separated["surname"] . ' ' . mb_substr($separated["name"], 0, 1) . ". " . mb_substr($separated["patronomyc"], 0, 1) . ".";

    return $short_name;
}

function getGenderFromName($fullName){
    $separated = getPartsFromFullname($fullName);

    $gender = 0;
    
    if(mb_substr($separated["surname"], -2, 2) == "ва"){
        $gender = -1;
    } elseif(mb_substr($separated["surname"], -1, 1) == "в"){
        $gender = 1;
    }else{
        $gender = 0;
    }
    
    $genderName = mb_substr($separated["name"], -1, 1);

    if($genderName == "a"){
        $gender = -1;
    } elseif($genderName == "й" || $genderName == "н"){
        $gender = 1;
    }else{
        $gender = 0;
    }

    if(mb_substr($separated["patronomyc"], -3, 3) == "вна"){
        $gender = -1;
    } elseif(mb_substr($separated["patronomyc"], -2, 2) == "ич"){
        $gender = 1;
    }else{
        $gender = 0;
    }

    if(($gender <=> 0) === 1){
        return "Male";
    } elseif(($gender <=> 0) === -1){
        return "Female";
    }else{
        return "Undefined";
    }
}

function getGenderDescription($array){
    $male = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Male");
    });

    $female = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Female");
    });

    $und = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Undefined");
    });

    $sum = count($male) + count($female) + count($und);
    $maleCheck =  round(count($male) / $sum * 100, 2);
    $femaleCheck = round(count($female) / $sum * 100, 2);
    $undCheck = round(count($und) / $sum  * 100, 2);

    echo <<<HEREDOC
    Гендерный состав аудитории:<br>
    ---------------------------<br>
    Мужчины - $maleCheck%<br>
    Женщины - $femaleCheck%<br>
    Не удалось определить - $undCheck%<br>
    HEREDOC;
}

function getPerfectPartner($surname, $name, $patronomyc, $array){
    $fullName = getFullnameFromParts($surname, $name, $patronomyc);
    $mainGender = getGenderFromName($fullName);   

    $randPerson = $array[rand(0,count($array)-1)]["fullname"];
    $randGender = getGenderFromName($randPerson);
    
    while ($mainGender == $randGender || $randGender === "Undefined"){
        $randPerson = $array[rand(0, count($array)-1)]["fullname"];
        $randGender = getGenderFromName($randPerson);
    }

    $shMainPerson = getShortName($fullName);
    $shRandPerson = getShortName($randPerson);
    $percent = rand(50, 100) + rand(0, 99) / 100;

    echo <<<HEREDOC
    $shMainPerson + $shRandPerson =<br>
    ♡ Идеально на $percent% ♡
    HEREDOC;
}