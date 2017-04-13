<?php
error_reporting(E_ALL);
#region//Определение страницы и задание head и title
if (!empty($_GET["pageType"])) {
    $typeOfPage = $_GET["pageType"];

    if ($typeOfPage == "main") {
        $head = 'Главная' . ' ' . 'страница';
        $fieldsetClass = "main-container-fieldset-main";
    } else
        if ($typeOfPage == "animals") {
            $head = "Животные";
            $fieldsetClass = "main-container-fieldset-animals";
        }
}
else
{
    $head = "Главная страница";
    $fieldsetClass = "main-container-fieldset-main";
}
$title = "Животные";
#endregion

#region//Работа со зверушками
$animals_array = [
    'Africa' => ['Giraffa camelopardalis', 'Panthera', 'Hippopotamus amphibius', 'Elephantidae', 'Lepilemur aeeclis'],//Жираф, лев, бегемот, слон, лемур:)
    'Eurasia' => ['Rangifer tarandus', 'Canidae', 'Phasianus colchicus', 'Ursus arctos', 'Canis lupus'],//Благородный олень, лисица, фазан, бурый медведь, волк:)
    'Antarctic' => ['Aptenodytes forsteri', 'Mirounga', 'Phocidae'],//Императорский пингвин, морской слон, тюлень:)
    'Australia' => ['Macropus rufus', 'Sarcophilus harrisii', 'Crocodylus porosus', 'Dromaius novaehollandiae', 'Tachyglossus aculeatus', 'Philoria frosti']//Рыжий кенгуру, тасманийский дьявол, крокодил, эму, ехидна, лягушка:)
];//Основной массив для всех животных

$double_name_animals = [];//Массив для названий животных, состоящих из двух слов

$count = 0;
$double_name_animals_count = [];//Массив для сохранения количества животных с именами, состоящими из двух слов - в каждом регионе

foreach ($animals_array as $countries => $animal_mas) {
    foreach ($animal_mas as $value) {
        if (!stripos($value, " ") == false)//Проверяем строку на наличие пробела
        {
            $double_name_animals [] = $value;
            $count++;
        }
    }
    $double_name_animals_count [] = $count;
    $count = 0;
}

$first_parts_of_names = [];//Массив для первых частей названий животных
$second_parts_of_names = [];//Массив для вторых частей названий животных

foreach ($double_name_animals as $value) {
    $first_parts_of_names [] = stristr($value, " ", true);//Выбираем только первую часть животного
    $second_parts_of_names [] = stristr($value, " ");//Выбираем только вторую часть животного
}

$fantastic_animals = [];//Массив для новых, фантастических животных

foreach ($first_parts_of_names as $value) {
    $rand_key = array_rand($second_parts_of_names);//Генерируем ключ случайного животного из массива $second_parts_of_names[]
    $fantastic_animals [] = "$value"." $second_parts_of_names[$rand_key]";//Соединяем первую часть жиотного со второй, выбранной рандомно
    unset($second_parts_of_names[$rand_key]);//Удаляем уже использованную вторую часть из массива $second_parts_of_names[]
}

#endregion
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title><?php echo $title; ?></title>
</head>
<body>
<header class="header-container">
    <div class="header-container__h1">
        <h1 class="header-h1"><?php echo $head; ?></h1>
        <a class="header-container-link" href="animals.php?pageType=main">Главная</a>
        <a class="header-container-link" href="animals.php?pageType=animals">Животные</a>
    </div>

</header>

<div class="main-container">
    <fieldset class="<?php echo $fieldsetClass?>">
        <?php if ($head === "Животные") {
            echo "<h2 class=\"main-container-fieldset-animals-h2\">Список всех фантастичеких зверей!</h2>";
            foreach ($fantastic_animals as $value) {
                echo "$value<br>";
            }
            echo "<br><h2 class=\"main-container-fieldset-animals-h2\">Список фантастических зверей по странам!</h2>";
            foreach ($animals_array as $countries => $real_animals) {
                echo "<h2>$countries</h2>";
                foreach ($real_animals as $real_animals_value) {
                    foreach ($fantastic_animals as $fantastic_animals_value) {
                        if (stristr($real_animals_value, " ", true) == stristr($fantastic_animals_value, " ", true))//Проверка животных на принадлеэность к  региону
                        {
                            echo "$fantastic_animals_value, ";
                        }
                    }
                }
            }
        }
        else {
            echo "<h1 class=\"main-container-h1\">Фантастичские звери и места их обитания!</h1>";
            echo "<h2 class=\"main-container-h2\">Животные!</h2>";
        }
        ?>

    </fieldset>
</div>
</body>
</html>