<?php

// VALIDATION

if(file_exists(__DIR__.'/data.json') == 0){
    $file = fopen(__DIR__.'/data.json', 'a');
    fclose($file);
}

function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$iban = 'LT1270440';

foreach(range(0,10) as $number){
    $iban = $iban . rand(0,9);
}

$name = $surname = $personal_id = "";
$name_flag = $surname_flag = $personal_id_flag = false;

$personal_id_pattern = "/^[3-6][0-9][0-9][0-1][0-9][0-3][0-9]..../";


if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(empty($_POST["name"])){
        $name_error = "Prasau iveskite varda";
       
    }elseif(strlen($_POST["name"]) < 3){
        $name_error = "Vardas negali buti trumpesnis nei 3 simboliai";
        
    }elseif(preg_match("/\w/i", $_POST["name"])){
        $name = test_input($_POST["name"]);
        $name_flag = true;
        

    }

    if(empty($_POST["surname"])){
        $surname_error = "Prasau iveskite pavarde";
        
    }elseif(strlen($_POST["surname"]) < 3){
        $surname_error = "Pavardė negali buti trumpesnis nei 3 simboliai";
        
    }elseif(preg_match("/\w/i", $_POST["surname"])){
        $surname = test_input($_POST["surname"]);
        $surname_flag = true;
        

    }

    // PERSONAL ID VALIDATION 
    if(empty($_POST["personal_id"])){
        $personal_id_error = "Prasau iveskite asmens koda";
        
    }elseif(!preg_match($personal_id_pattern,$_POST["personal_id"])){
        $personal_id_error = "Neateisingas Asmens kodas";
    }else{
        $personal_id = $_POST["personal_id"];
        $personal_id_flag = true;
        
    }

 

    
    
}
// POST DATA TO JSON
if($personal_id_flag === true && $name_flag === true && $surname_flag === true){
    $user = ['id' => rand(1,1000000), 'name' => $name, 'surname' => $surname, 'iban' => $iban, 'personal_id' => $personal_id, 'money' => (int)$_POST["money"] ];
    if(isset($_POST['submit'])){

        if(filesize(__DIR__.'/data.json') == 0){
            $first_record = array($user);
    
            $data_to_save = $first_record;
        }else{
            $users = json_decode(file_get_contents(__DIR__.'/data.json'));
    
            array_push($users,$user);
    
            $data_to_save = $users;
        }
    
        if(!file_put_contents(__DIR__.'/data.json',json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)){
            echo "Klaida irasant duomenis";
        }else{
            echo  "Irasyta";
            echo $iban;
        }
    
    }
    
}









?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sukurti saskaita</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form" method="POST">
        <label>Vardas</label>
        <input type="text" name="name">
        <span class="error"><?php  if(isset($name_error)) echo $name_error;?></span>
        <label>Pavardė</label>
        <input type="text" name="surname">
        <span class="error"><?php if(isset($surname_error)) echo $surname_error;?></span>
        <label>IBAN</label>
        <input type="text" name="iban" value='<?php echo $iban ?>' readonly>
        <label>Asmens kodas</label>
        <input type="text" name="personal_id">
        <span class="error"><?php if(isset($personal_id_error)) echo $personal_id_error;?></span>
        <input type="hidden" name="money" value="0">
        <button type="submit" name="submit">Sukūrti</button>
    </form>
</body>
</html>