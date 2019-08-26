<?php
// Inicio sesiones
session_start();

if(isset($_SESSION["logged"])){
	header("Location: index.php");
}
?>
  <?php
	if(isset($_SESSION["error_login"])){ ?>
		<div class="alert alert-danger"><?=$_SESSION["error_login"]?></div>
	<?php }?>
  <?php require_once 'includes/header.php'; ?>
  <h2>IDENTIFICATE</h2>
  <div class="col-lg-5" style="padding-left:0px;">
    <?php if(isset($_SESSION["error_login"])){?>
      <div class="alert alert-danger"><?=$_SESSION["error_login"]?></div>

    <?php } ?>
	<form action="login-user.php" method="POST">
		Document: <input name="Document" type="number"  class="form-control" />
		Password: <input name="Password" type="password"  class="form-control" />
		<br/>
		<input type="submit" class="btn btn-success" name="submit" value="ENTER"/>
	</form>
</div>
<div class="clearfix"></div>
<?php require_once 'includes/footer.php'; ?>
