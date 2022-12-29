<?php 

$data_from_file = file_get_contents(__DIR__.'/data.json');
$data = json_decode($data_from_file,true);
    
$id = $_GET['id'];

foreach($data as $index => $user){
    
    if($user['id'] == $id){
        if((int)$user['money'] > 0){
            header("Location: http://localhost/Bank/PAGES/saskaitu_sarasas.php?delete=false");
            break;
    }else{
        unset($data[$index]);
        header('Location: http://localhost/Bank/PAGES/saskaitu_sarasas.php?delete=true&name='.$user['name'].'&surname='.$user['surname']);
        break;
        }

    }

}

file_put_contents(__DIR__.'/data.json', json_encode($data));



