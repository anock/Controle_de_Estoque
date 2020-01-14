<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Estoque</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>


</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#"><i class="fas fa-archive " > </i> Controle de estoque</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Venda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Relatório</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center text-danger font-weight-normal my-3">Controle de Estoque Versão 1.0</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-primary">Todos os modelos</h4>

        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal"  data-target="#addModal"><i class="fas fa-folder-plus"></i>&nbsp;&nbsp;Adicionar Produto</button>

            <a href="action.php?export=excel" class="btn btn-success m-1 float-right"><i class="fas fa-table fa-lg"></i>&nbsp;&nbsp;Exportar para Excel</a>


        </div>
       

    </div>
    <hr class="my-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive " id="ShowUser"></div>
           <!--   <h3 class="text-center text-success" style="margin-top:150px;">Carregando...</h3> -->
        </div>
    </div>


</div>
 <!-- The Modal -->
 <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Produto</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
          <form action="" method="post" id="form-data">
            
              <div class ="form-group">
                  <input type="text" name="fmodelo" class="form-control" placeholder="Modelo"required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fcompra"class="form-control" placeholder="Valor de compra"required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fvenda" class="form-control" placeholder="Valor de venda"required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fquantidade" class="form-control" placeholder="Quantidade"required>
              </div>
              <div class ="form-group">
                  <input type="submit" name="insert" id="insert" value="Adicionar" class="btn btn-danger btn-block">
              </div>
          </form>
        </div>
       </div>
    </div>
  </div>


   <!-- Modal EDIT-->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">editar Produto</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
          <form action="" method="post" id="edit-form-data">
          <input type="hidden" name="id" id="id">
              <div class ="form-group">
                  <input type="text" name="fmodelo" class="form-control"  id="fmodelo" required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fcompra"class="form-control" id="fcompra"  required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fvenda" class="form-control" id="fvenda" required>
              </div>
              <div class ="form-group">
                  <input type="text" name="fquantidade" class="form-control" id = "fquantidade" required>
              </div>
              <div class ="form-group">
                  <input type="submit" name="update" id="update" value="Atualizar" class="btn btn-primary btn-block">
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
    $(document).ready(function(){
     

        showAllUsers();

        function showAllUsers(){
            $.ajax({
                url: "action.php",
                type: "POST",
                data:{action:"view"},
                success:function(response){
                   console.log(response); 

                   $("#ShowUser").html(response);
                   $("table").DataTable({
                     order:[0,'desc']
                   });
                }
            })
        }
        //insert ajax request
        $("#insert").click(function(e){
          if($("#form-data")[0].checkValidity()){
            e.preventDefault();
            $.ajax({ 
              url:"action.php",
              type: "POST",
              data: $("#form-data").serialize()+"&action=insert",
              success:function(response){
                Swal.fire({
                  title:'Produto adicionado!',
                  type: 'seccess'
                })
                $("#addModal").modal('hide');
                $("#form-data")[0].reset();
                showAllUsers();
              }
            });
          }

        });
        //Edit produto

        $("body").on("click",".editBtn",function(e){
          e.preventDefault();
          edit_id = $(this).attr('id');
          $.ajax({
            url: "action.php",
            type:"POST",
            data:{edit_id:edit_id},
            success:function(response){
              data = JSON.parse(response);
              $("#id").val(data.id);
              $("#fmodelo").val(data.modelo);
              $("#fcompra").val(data.venda);
              $("#fvenda").val(data.compra);
              $("#fquantidade").val(data.quantidade);
            }
          })
        });
          //update ajax request
          $("#update").click(function(e){
          if($("#edit-form-data")[0].checkValidity()){
            e.preventDefault();
            $.ajax({ 
              url:"action.php",
              type: "POST",
              data: $("#edit-form-data").serialize()+"&action=update",
              success:function(response){
                Swal.fire({
                  title:'Produto atualizado!',
                  type: 'success'
                })
                $("#editModal").modal('hide');
                $("#edit-form-data")[0].reset();
                showAllUsers();
              }
            });
          }

        });

        //delete ajax 

        $("body").on("click", ".delBtn", function(e){
          e.preventDefault();
          var tr= $(this).closest('tr');
          del_id = $(this).attr('id');

          Swal.fire({
          title: 'Esta certo disso?',
          text: "Produto será deletado do banco de dados!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, Deletar!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url:"action.php",
              type:"POST",
              data:{del_id:del_id},
              success:function(response){
               tr.css('background-color','#ff6666');
               Swal.fire(
                 'Deletado!',
                 'Produto deletado com sucesso!',
                 'success'
               )
               showAllUsers();
              }
            });
          }
        
        });

        });
        // detalhes

        $("body").on("click" , ".infoBtn",function(e){
          e.preventDefault();
          info_id = $(this).attr('id');
          $.ajax({
            url:"action.php",
            type:"POST",
            data:{info_id:info_id},
            success:function(response){
              //console.log(response);
              data = JSON.parse(response);
              Swal.fire({
                title:'<strong>Produto Info: ID('+data.id+')</strong>',
                type:'info',
                html: '<b>Modelo : </b>'+ data.modelo + '<br><b>Valor de compra  :  </b>' + data.compra +' <br><b> Valor de venda  :  </b>'+data.venda+'<br><b> Quantidade  :  </b>'+data.quantidade,
                showCancelButton: true
              })
            }
          })

        });

    });
    </script>
</body>
</html>