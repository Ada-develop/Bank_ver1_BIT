<?php 

$data_from_file = file_get_contents(__DIR__.'/data.json');
$data = json_decode($data_from_file);
    
$id = (int) $_GET['id'];

foreach($data as $user){
    if($user -> id == $id){
        $user -> money += (int)$_POST['money'];
        file_put_contents(__DIR__.'/data.json', json_encode($data));

        break;
    }

}

header("Location: http://localhost/Bank/PAGES/add_money_page.php?id=".$id);

    