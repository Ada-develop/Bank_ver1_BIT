<?php 



if(file_exists(__DIR__.'/data.json') == 0){
    echo "Nera irasu";
}else{
    $data_from_file = file_get_contents(__DIR__.'/data.json');
    $data = json_decode($data_from_file, true);
    
    


usort($data, function ($a, $b) {
    return strtolower($a['surname']) <=> strtolower($b['surname']);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="./style.css" rel="stylesheet">
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
          <a class="nav-link active" aria-current="page" href="#">Sąskaitų sąrašas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../PAGES/sukurti_saskaita.php">Sūkurti sąskaitą</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php 

if(isset($_GET['delete']) && $_GET['delete'] == 'true'){
    echo "<div class='p-3 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3success'>Vartotojas - ".$_GET['name']." ".$_GET['surname']." buvo istrintas</div>";
}elseif(isset($_GET['delete']) && $_GET['delete'] == 'false'){
    echo "<div class='p-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3danger'> Negalima istrinti saskaitos jeigu joje yra lesu</div>";
} ?>
    <h1 style="text-align: center; margin-top:3%;margin-bottom:3%;">Sąskaitų sąrašas</h1>

    <div class="table-responsive-sm">
<table class="table" style="margin:0 auto;">
  <thead>
    <tr>
    <th scope="col">ID</th>
      <th scope="col">Vardas</th>
      <th scope="col">Pavardė</th>
      <th scope="col">IBAN</th>
      <th scope="col">Asmens kodas</th>
      <th scope="col">Lėšos</th>
      <th scope="col">Veiksmai</th>
    </tr>
  </thead>
  <tbody>
    <?php

    foreach($data as $val){
        echo '<tr><th scope="row">'.$val['id'].'</th><td>'.$val['name'].'</td><td>'.$val['surname'].'</td><td>'.$val['iban'].'</td><td>'.$val['personal_id'].'</td><td>'.$val['money'].' &euro;</td><td class="flx-tbl"> <a href="./delete.php?id='.$val['id'].'" class="btn btn-danger">Istrinti</a> <a href="./add_money_page.php?id='.$val['id'].'" class="btn btn-success">Lėšų operacijos</a><td></tr>';
    }
    ?>

</tbody>
</table>
    </div>


















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>