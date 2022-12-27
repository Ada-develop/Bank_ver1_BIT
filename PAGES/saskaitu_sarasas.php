<?php 



if(file_exists(__DIR__.'/data.json') == 0){
    echo "Nera irasu";
}else{
    $data_from_file = file_get_contents(__DIR__.'/data.json');
    $data = json_decode($data_from_file);
    
    


    usort($data, function ($a, $b) {
        return strtolower($a->surname) <=> strtolower($b->surname);
    });

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saskaitu sarasas</title>
</head>
<body>
    <h1>Saskaitu sarasas</h1>
    <ul class="user-list">
    <?php

    foreach($data as $val){
        echo '<li> ID : '.$val->id.' Vardas :'.$val -> name.' Pavardė :'.$val -> surname.' IBAN :'.$val -> iban.' Asmens kodas :'.$val -> personal_id.' Lesos :'.$val -> money.' </li> <a href="">Istrinti</a> <a href="./add_money.php">Prideti lesu</a>';
    }
    ?>
    </ul>
</body>
</html>