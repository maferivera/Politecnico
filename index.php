<?php
//include 'includes/redirect.php';
include 'includes/header.php';

$users = mysqli_query($db, "SELECT * FROM Estudiante");
$num_total_users=mysqli_num_rows($users);
if($num_total_users>0){
	$rows_per_page=3;
	$page=false;
	if(isset($_GET["page"])){
		$page=$_GET["page"];
	}
	if(!$page){
		$start=0;
		$page=1;
	}else{
		$start=($page-1) * $rows_per_page;
	}
	$total_pages=ceil($num_total_users / $rows_per_page);
	$sql="SELECT * FROM Estudiante ORDER BY user_id DESC LIMIT {$start}, {$rows_per_page};";
	$users=mysqli_query($db, $sql);
}else{
	echo "There isn't users";
}
?>
<table class="table">
	<tr>
		<th>Document</th>
		<th>Names</th>
		<th>Second Names</th>
		<th>Direction</th>
		<th>Responsible</th>
		<th>Telephone responsible</th>
		<th>See/Edit</th>
	</tr>
	<?php while ($user = mysqli_fetch_assoc($users)) { ?>
	<tr>
		<td><?=$user["Document"]?></td>
		<td><?=$user["Names"]?></td>
		<td><?=$user["Second_Names"]?></td>
		<td><?=$user["Direction"]?></td>
		<td><?=$user["Responsible"]?></td>
		<td><?=$user["TelephoneA"]?></td>

		<td>
			<a href="ver.php?id=<?=$user["user_id"]?>" class="btn btn-success">See</a>
			<a href="editar.php?id=<?=$user["user_id"]?>" class="btn btn-warning">Edit</a>
			<?php if(isset($_SESSION["logged"]) && $_SESSION["logged"]["Rol"] == 1){ ?>
				<a href="borrar.php?id=<?=$user["user_id"]?>" class="btn btn-danger">Delete</a>
			<?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
<?php if($num_total_users>=1){?>
	<ul class="pagination">
		<li><a href="?page=<?=($page-1)?>"><<</a></li>
		<?php for($i=1; $i<=$total_pages; $i++){ ?>
			<?php if($page==$i){ ?>
				<li class="disabled"><a href="#"><?=$i?></a></li>
			<?php } else{ ?>
				<li><a href="?page=<?=$i?>"><?=$i?></a></li>
			<?php } ?>
			<?php } ?>
			<li><a href="?page=<?php $show_page=($page+1); if($show_page <= $total_pages){ echo $show_page;}else{ echo $total_pages;}?>">>></a></li>
	</ul>
<?php } ?>

<?php include("includes/footer.php")?>
