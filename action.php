<?php

require_once 'db.php';
$db = new DataBase();


if(isset($_POST['action'])&& $_POST['action'] == "view"){
    $output = '';
    $data = $db->read();
    
   
  
    if($db->totalRowCount()>0){
        $output .='<table class="table table-striped table-sm table-bordered">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Modelo</th>
                <th>Valor de compra R$</th>
                <th>Valor de venda R$</th>
                <th>Quantidade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($data as $row){
            $output.='<tr class="text-center text secondary">
            <td>'.$row['id']. '</td>
            <td>'.$row['modelo']. '</td>
            <td>'.$row['compra']. '</td>
            <td>'.$row['venda']. '</td>
            <td>'.$row['quantidade']. '</td>
            <td>
            <a href="#" title="Detalhes" class="text-success infoBtn" id="'.$row['id']. '"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;
            
            <a href="#" title="Editar" class="text-primary editBtn" data-toggle="modal" data-target ="#editModal" id="'.$row['id'].'"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
           
            <a href="#" title="Apagar" class="text-danger delBtn" id="'.$row['id'].'"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
            </td></tr> '
       ; }
        $output.='</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class ="text-center text-secondary mt-5">:( Modelo não encontrado!</h3>';
    }
}

if(isset($_POST['action'])&& $_POST['action']== "insert"){
    $fmodelo = $_POST['fmodelo'];
    $fcompra = $_POST['fcompra'];
    $fvenda = $_POST['fvenda'];
    $fquantidade= $_POST['fquantidade'];
    
    $db->insert($fmodelo,$fcompra,$fvenda,$fquantidade);

}
if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $db->getUserbyId($id);
    echo json_encode($row);
}

if(isset($_POST['action'])&& $_POST['action'] == "update"){
    $id = $_POST['id'];
    $fmodelo = $_POST['fmodelo'];
    $fcompra = $_POST['fcompra'];
    $fvenda = $_POST['fvenda'];
    $fquantidade= $_POST['fquantidade'];

    $db->update($id,$fmodelo,$fcompra,$fvenda,$fquantidade);
}
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];

    $db->delete($id);
}

if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    $row = $db->getUserbyId($id);
    echo json_encode($row);
}

if(isset($_GET['export']) && $_GET['export'] == "excel"){
    header("Content-type: application/xls");
    header("Content-Disposition: attachment; filename=users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $db->read();
    echo '<table border ="1">';
    echo '<tr><th>Id</th><th>Modelo</th><th>valor de compra</th><th>valor de venda</th><th>quantidade</th></tr>';

    foreach($data as $row){
        echo '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['modelo'].'</td>
            <td>'.$row['compra'].'</td>
            <td>'.$row['venda'].'</td>
            <td>'.$row['quantidade'].'</td>

        </tr>';
    }

    echo '</table>';
}

?>
