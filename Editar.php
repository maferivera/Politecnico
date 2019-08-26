<?php //include 'includes/redirect.php';?>
<?php require_once("includes/header.php")?>
<?php
function mostrarError($error, $field){
  if(isset($error[$field]) && !empty($field)){
    $alerta='<div class="alert alert-danger">'.$error[$field].'</div>';
  }else{
    $alerta='';
  }
  return $alerta;
}
function setValueField($datos,$field, $textarea=false){
  if(isset($datos) && count($datos)>=1){
    if($textarea != false){
      echo $datos[$field];
    }else{
      echo "value='{$datos[$field]}'";
    }
  }
}
//Buscar Usuario
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])){
  header("location:index.php");
  }
$id=$_GET["id"];
$user_query=mysqli_query($db, "SELECT * FROM Estudiante WHERE user_id={$id}");
$user=mysqli_fetch_assoc($user_query);
if(!isset($user["user_id"]) || empty($user["user_id"])){
  header("location:index.php");
}
//Validar usuario
$error=array();
if(isset($_POST["submit"])){
  if(!empty($_POST["Document"])){
    $doc_validador=true;
   }else{
   $doc_validador=false;
    $error["Document"]="The document can't be empty";
  }

 if(!empty($_POST["Names"]) && strlen($_POST["Names"]<=20) && !is_numeric($_POST["Names"]) && !preg_match("/[0-9]/", $_POST["Names"])){
$nombre_validador=true;
}else{
$nombre_validador=false;
$error["Names"]="The name isn't valid";
}

  if(!empty($_POST["Second_Names"])&& !is_numeric($_POST["Second_Names"]) && !preg_match("/[0-9]/", $_POST["Second_Names"])){
      $apellidos_validador=true;
     }else{
     $apellidos_validador=false;
       $error["Second_Names"]="The second names can't be empty";
        }
     if(!empty($_POST["Direction"])){
       $direc_validador=true;
      }else{
      $direct_validador=false;
       $error["Direction"]="The direction can´t be empty";
        }
     if(!empty($_POST["Responsible"]) && filter_var($_POST["Responsible"])){
       $acud_validador=true;
      }else{
       $acud_validador=false;
       $error["Responsible"]="Enter a name of your responsible";
        }

        if(!empty($_POST["TelephoneA"]) && filter_var($_POST["TelephoneA"])){
          $tel_validador=true;
         }else{
          $tel_validador=false;
          $error["TelephoneA"]="Please enter a telephonic number";
           }

        //colocar entre comentarios par activar la actualización
     if(!empty($_POST["Password"]) && strlen($_POST["Password"]>=6)){
       $password_validador=true;
      }else{
      $password_validador=false;
       $error["Password"]="Enter a password of more than six digits";
        }

     if(isset($_POST["Rol"]) && is_numeric($_POST["Rol"])){
       $role_validador=true;
      }else{
      $role_validador=false;
       $error["Rol"]="Choose a user rol";
        }
        //nuevo código
        $image=null;
        if(isset($_FILES["Image"]) && !empty($_FILES["Image"]["tmp_name"])){
          if(!is_dir("uploads")){
            $dir = mkdir("uploads", 0777, true);
          }else{
            $dir=true;
          }
          if($dir){
            $filename= time()."-".$_FILES["Image"]["name"]; //concatenar función tiempo con el nombre de imagen
            $muf=move_uploaded_file($_FILES["Image"]["tmp_name"], "uploads/".$filename); //mover el fichero utilizando esta función
            $image=$filename;
            if($muf){
              $image_upload=true;
            }else{
              $image_upload=false;
              $error["Image"]= "The image hasn't been upload";
            }
          }
          //var_dump($_FILES["image"]);
          //die();
  	 	}
    //Actualizar Usuarios en la base de Datos
    if(count($error)==0){
      $sql= "UPDATE Estudiante set Name='{$_POST["Names"]}',"
      . "Document= '{$_POST["Documento"]}',"
      . "Second_Names= '{$_POST["Second_Names"]}',"
      . "Direction= '{$_POST["Direction"]}',"
      . "Responsible= '{$_POST["Responsible"]}',"
      . "TelephoneA= '{$_POST["TelephoneA"]}',";
      if(isset($_POST["Password"]) && !empty($_POST["Password"])){
        $sql.= "Password='".sha1($_POST["Password"])."', ";
     }
     //Código nuevo
     if(isset($_FILES["Image"]) && !empty($_FILES["Image"]["tmp_name"])){
       $sql.= "Image='{$image}', ";
    }
      $sql.= "Rol= '{$_POST["Rol"]}'WHERE user_id={$user["user_id"]};";
      $update_user=mysqli_query($db, $sql);
      if($update_user){
        $user_query=mysqli_query($db, "SELECT * FROM Estudiante WHERE user_id={$id}");
        $user=mysqli_fetch_assoc($user_query);
      }
    }else{
      $update_user=false;
    }
}
?>
<h2>Edit User <?php echo $user["user_id"]."-".$user["Names"]." ".$user["Second_Names"];?></h2>
<?php if(isset($_POST["submit"]) && count($error)==0 && $update_user !=false){?>
  <div class="alert alert-success">
    The user has been refreshed correctly !!
  </div>
<?php }elseif(isset($_POST["submit"])){?>
  <div class="alert alert-danger">
    The user hasn't been refreshed correctly !!
  </div>
<?php } ?>

<form action="" method="POST" enctype="multipart/form-data">
  <label for="Document">Document:
  <input type="number" name="Document" class="form-control" <?php setValueField($user, "Document");?>/>
  <?php echo mostrarError($error, "Document");?>
  </label>
  </br></br>

    <label for="Names">Names:
    <input type="text" name="Names" class="form-control" <?php setValueField($user, "Names");?>/>
    <?php echo mostrarError($error, "Names");?>
    </label>
    </br></br>

    <label for="Second_Names">Second Names:
        <input type="text" name="Second_Names" class="form-control" <?php setValueField($user, "Second_Names");?>/>
        <?php echo mostrarError($error, "Second_Names");?>
    </label>
    </br></br>

    <label for="Direction">Direction:
        <input type="text" name="Direction" class="form-control"><?php setValueField($user, "Direction");?>
        <?php echo mostrarError($error, "Direction");?>
    </label>
    </br></br>

    <label for="Responsible">Responsible:
        <input type="text" name="Responsible" class="form-control" <?php setValueField($user, "Responsible");?>/>
        <?php echo mostrarError($error, "Responsible");?>
    </label>
    </br></br>

    <label for="TelephoneA">Telephone responsible:
        <input type="text" name="TelephoneA" class="form-control" <?php setValueField($user, "TelephoneA");?>/>
        <?php echo mostrarError($error, "TelephoneA");?>
    </label>
    </br></br>
    <label for="Image">
      <?php if($user["Image"] != null){?>
        Imagen de Perfil: <img src="uploads/<?php echo $user["Image"] ?>" width="100"/><br/>
      <?php } ?>
        Actualizar Imagen de Perfil:
        <input type="file" name="Image" class="form-control"/>
        <!--Nuevo Código-->
    </label>
    </br></br>
    <label for="Password">Password:
        <input type="Password" name="Password" class="form-control"/>
        <?php echo mostrarError($error, "Password");?>
    </label>
    </br></br>
    <label for="Rol" class="form-control">Rol:
        <select name="Rol">
        <option value="0" <?php if($user["Rol"]==0){echo "selected='selected'";}?>>Normal</option>
            <option value="1" <?php if($user["Rol"]==1){echo "selected='selected'";}?>>Administrator</option>
        </select>
        <?php echo mostrarError($error, "Rol");?>
    </label>
    </br></br>
    <input type="submit" value="Submit" name="submit" class="btn btn-success"/>
</form>
<?php require_once("includes/footer.php")?>
