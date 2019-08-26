<?php //include 'includes/redirect.php';?>
<?php require_once 'includes/header.php';?>
<?php
function mostrarError($error, $field){
  if(isset($error[$field]) && !empty($field)){
    $alerta='<div class="alert alert-danger">'.$error[$field].'</div>';
  }else{
    $alerta='';
  }
  return $alerta;
}
function setValueField($error,$field, $textarea=false){
  if(isset($error) && count($error)>=1 && isset($_POST[$field])){
    if($textarea != false){
      echo $_POST[$field];
    }else{
      echo "value='{$_POST[$field]}'";
    }
  }
}
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
       $error["Second_Names"]="The Second names aren't valids";
        }
     if(!empty($_POST["Direction"])){
       $direc_validador=true;
      }else{
      $direc_validador=false;
       $error["Direction"]="The direction can't be empty";
        }
        if(!empty($_POST["Responsible"])){
          $acud_validador=true;
         }else{
         $acud_validador=false;
          $error["Responsible"]="Enter a name of your responsible";
           }
           if(!empty($_POST["TelephoneA"])){
             $tel_validador=true;
            }else{
            $tel_validador=false;
             $error["TelephoneA"]="The telephone can't be empty";
              }
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
      //Crear una carpeta nuevo código
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
    //Insertar Usuarios en la base de Datos
    if(count($error)==0){
      $sql= "INSERT INTO Estudiante VALUES(NULL,'{$_POST["Document"]}', '{$_POST["Names"]}', '{$_POST["Second_Names"]}', '{$_POST["Direction"]}', '{$_POST["Responsible"]}', '{$_POST["TelephoneA"]}','".sha1($_POST["Password"])."', '{$_POST["Rol"]}', '{$image}');"; //colocar image
      $insert_user=mysqli_query($db, $sql);
    }else{
      $insert_user=false;
    }
}
?>
<h1>Create Users</h1>
<?php if(isset($_POST["submit"]) && count($error)==0 && $insert_user !=false){?>
  <div class="alert alert-success">
    The user has been created correctly !!
  </div>
<?php } ?>
<form action="crear.php" method="POST" enctype="multipart/form-data">
  <label for="Document">Document:
  <input type="number" name="Document" class="form-control" <?php setValueField($error, "Document");?>/>
  <?php echo mostrarError($error, "Document");?>
  </label>
  </br></br>

    <label for="Names">Names:
    <input type="text" name="Names" class="form-control" <?php setValueField($error, "Names");?>/>
    <?php echo mostrarError($error, "Names");?>
    </label>
    </br></br>

    <label for="Second_Names">Second Names:
        <input type="text" name="Second_Names" class="form-control" <?php setValueField($error, "Second_Names");?>/>
        <?php echo mostrarError($error, "Second_Names");?>
    </label>
    </br></br>

    <label for="Direction">Direction:
        <input type="text" name="Direction" class="form-control"><?php setValueField($error, "Direction");?>
        <?php echo mostrarError($error, "Direction");?>
    </label>
    </br></br>

    <label for="Responsible">Responsible:
        <input type="text" name="Responsible" class="form-control" <?php setValueField($error, "Responsible");?>/>
        <?php echo mostrarError($error, "Responsible");?>
    </label>
    </br></br>

    <label for="TelephoneA">Telephone:
        <input type="text" name="TelephoneA" class="form-control" <?php setValueField($error, "TelephoneA");?>/>
        <?php echo mostrarError($error, "TelephoneA");?>
    </label>
    </br></br>

    <label for="Password">Password:
        <input type="Password" name="Password" class="form-control"/>
        <?php echo mostrarError($error, "Password");?>
    </label>

    </br></br>
    <label for="Rol" class="form-control">Rol:
        <select name="Rol">
        <option value="0">Normal</option>
            <option value="1">Administrator</option>
        </select>
        <?php echo mostrarError($error, "Rol");?>
    </label>
    </br></br>

    <label for="Image">Image:
        <input type="file" name="Image" class="form-control"/>
    </label>
    </br></br>
    <input type="submit" value="Submit" name="submit" class="btn btn-success"/>
</form>
<?php require_once 'includes/footer.php'; ?>
