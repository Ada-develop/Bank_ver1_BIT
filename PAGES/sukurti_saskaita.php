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






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="./styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Bankas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../PAGES/saskaitu_sarasas.php">Sąskaitų sąrašas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sūkurti sąskaitą</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php 

// POST DATA TO JSON
if($personal_id_flag === true && $name_flag === true && $surname_flag === true){
    $user = ['id' => rand(1,1000000), 'name' => $name, 'surname' => $surname, 'iban' => $iban, 'personal_id' => $personal_id, 'money' => (int)$_POST["money"] ];
    if(isset($_POST['submit'])){

        $flag_personal_id_exist = false;

        $users = json_decode(file_get_contents(__DIR__.'/data.json'));
        // foreach($users as $use){
        //     if($use -> personal_id == $personal_id){
                
        //         $flag_personal_id_exist = true;
                
        
        //         break;
        //     }
        
        // }

        if(filesize(__DIR__.'/data.json') == 0){
            $first_record = array($user);
    
            $data_to_save = $first_record;
        }elseif($flag_personal_id_exist == true){
            echo "Toks vartotojas jau egzsistuoja";
        }else{
            



            
            
            array_push($users,$user);
    
            $data_to_save = $users;
            
   
        }

        
    
        if(!file_put_contents(__DIR__.'/data.json',json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)){
            echo "Klaida irasant duomenis";
        }else{
            echo  "<div class='p-3 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3'>Vartotojas - ".$name. " ".$surname." buvo sukurtas</div>";
        }
    
    }
    
}



?>

    

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form" method="POST" style="width:50%; margin: 0 auto;">
    <h1 style="text-align: center;
    margin: 5%;">Sukūrti sąskaita</h1>
    <div class="row mb-5">
        <label class="col-sm-2 col-form-label">Vardas</label>
<div class="col-sm-10">
        <input type="text" name="name" class="form-control">
        </div>
        <span class="error"><?php  if(isset($name_error)) echo $name_error;?></span>
    </div>
    <div class="row mb-5">
        <label class="col-sm-2 col-form-label">Pavardė</label>
<div class="col-sm-10">
        <input type="text" name="surname" class="form-control">
        </div>
        <span class="error"><?php if(isset($surname_error)) echo $surname_error;?></span>
    </div>
    <div class="row mb-5">
        <label class="col-sm-2 col-form-label">IBAN</label>
<div class="col-sm-10">
        <input type="text" name="iban" value='<?php echo $iban ?>' readonly class="form-control-plaintext">
        </div>
    </div>
    <div class="row mb-5">
        <label class="col-sm-2 col-form-label">Asmens kodas</label>
        <div class="col-sm-10">
        <input type="text" name="personal_id" class="form-control">
        </div>
        <span class="error"><?php if(isset($personal_id_error)) echo $personal_id_error;?></span>
</div>
        <input type="hidden" name="money" value="0">
    
        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" style="width: 100%;">Sukūrti</button>
    </form>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>