<?php

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL & ~WARNING);

$categoria=$_GET['categoria'];
$page=$_GET['page'];


if(!isset($page))
{
	$url = 'http://pedrocosta.heliohost.org/multimedia/categoria.php?page=1&categoria='.$categoria;
echo'
<script>
window.location.href = "'.$url.'";
</script>
';
	
}
$conn= mysqli_connect("65.19.141.67","pofc24_multimedi","multimedia","pofc24_multimedia") or die ("Unable to connect to the database");
$aux=($page - 1) * 6 ;
$raux=mysqli_query($conn,"SELECT id FROM livros WHERE catergoria LIKE '{$categoria}' ");
$limit=6;

$lastpage=ceil(($raux->num_rows)/$limit);

if(isset($_POST['nextpage']))
{
    if($page==$lastpage || $lastpage==0)
    {
    		$url = 'http://pedrocosta.heliohost.org/multimedia/categoria.php?page='.$page.'&categoria='.$categoria;
echo'
<script>
window.location.href = "'.$url.'";
</script>
';
       
    }
    else {
        $page++;
           		$url = 'http://pedrocosta.heliohost.org/multimedia/categoria.php?page='.$page.'&categoria='.$categoria;
echo'
<script>
window.location.href = "'.$url.'";
</script>
';
    }

}
if(isset($_POST['backpage']))
{
    if($page==1)
    {
            		$url = 'http://pedrocosta.heliohost.org/multimedia/categoria.php?page=1&categoria='.$categoria;
echo'
<script>
window.location.href = "'.$url.'";
</script>
';
    }
    else{
        $page--;
            		$url = 'http://pedrocosta.heliohost.org/multimedia/categoria.php?page='.$page.'&categoria='.$categoria;
echo'
<script>
window.location.href = "'.$url.'";
</script>
';
    }
}
?>


<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Livros para Crianças">

	<title> Books4Kids &ndash; Livros para Crianças </title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">

	<link rel="stylesheet" href="style.css">



</head>


<body>




	<nav>
		<div id="logo">Books4Kids  </div>
		<img src="img/book_logo.png" style="height: 40px; width:40px; margin-top:15px">
		<label for="drop" class="toggle">Menu</label>
		<input type="checkbox" id="drop">
		<ul class="menu">


			<li>
				<form method="GET" action="searchbar.php">
					<input name="se "type="text" style="margin-top: 20px; text-align: center" class="pure-input-rounded" placeholder="insira um titulo" >
					<button name="sub" type="submit" class="pure-button pure-button-primary">Search</button>
					<?php
					if(isset($_GET['sub']))
					{
						$aux=$_GET['se'];
						header('location: searchbar.php?page=1&search='.$aux);
					}
					?>

				</form>

			</li>
			<li><a href="top.php">Top10</a></li>
			<li>
				<!-- First Tier Drop Down -->
				<label for="drop-1" class="toggle">Categorias +</label>
				<a href="#">Categorias</a>
				<input type="checkbox" id="drop-1"/>
				<ul>
					<li><a href="categoria.php?page=1&categoria=Conto">Conto</a></li>
					<li><a href="categoria.php?page=1&categoria=Animacao">Animação</a></li>
                    <li><a href="categoria.php?page=1&categoria=Desporto">Desporto</a></li>
                    <li><a href="categoria.php?page=1&categoria=Astronomia">Astronomia</a></li>
                    <li><a href="categoria.php?page=1&categoria=Animais">Animais</a></li>

				</ul>

			</li>

				<li><a href="books4kids.php?page=1">BACK</a></li>
		</ul>
	</nav>



	<form method="POST">
		<?php
		$stuff=mysqli_query($conn,"SELECT name,autor,imagem,link FROM livros WHERE catergoria LIKE '{$categoria}' LIMIT ".$aux." , 6");
		while($row = mysqli_fetch_array($stuff))
		{
			?>
			<div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-3" style="margin-right: 10px;margin-left: -70px;">
				<div class="component">
					<ul class="align">
						<li>
							<figure class='book'>

								<!-- Front -->

								<ul class='hardcover_front'>
									<li>

										<img src="<?php echo $row["imagem"];?>" alt="<?php echo $row["name"];?>" height="220" width="180">
									</li>
									<li>

									</li>
								</ul>

								<!-- Pages -->

								<ul class='page'>
									<li></li>
									<li>
										<!--<a class="btn" href="#">ler</a>-->
										<a href="<?php echo $row["link"];?>" class="btn">ler </a>
									</li>
									<li></li>
									<li></li>
									<li></li>
								</ul>

								<!-- Back -->

								<ul class='hardcover_back'>
									<li></li>
									<li></li>
								</ul>
								<ul class='book_spine'>
									<li></li>
									<li></li>
								</ul>
								<figcaption>
									<h1> <?php echo $row["name"];?> </h1>
									<span> <?php echo $row["autor"];?> </span>
									<!--<p>Website dedicated to sharing resources</p>-->
								</figcaption>
							</figure>
						</li>
					</ul>
				</div>
			</div>

		<?php } ?>


		<div method="POST" class="pure-button-group pure-u-1 form-box"  style="margin-top: 100px;border: 0">
			<?php if($page>1)
			{?>
				<button type="submit" name="backpage" class="pure-button">Page <?php echo $page-1 ?></button>
			<?php } ?>
			<button type="submit" name="nextpage" class="pure-button">Page <?php echo $page+1 ?></button>

		</div>
	</form>









	<div class="content">
		<div class="pure-g">
			<div class="l-box-lrg pure-u-2 pure-u-md-5-5">
				<form class="pure-u-1 form-box" style="margin-top: 20px" method="GET">
					<fieldset style="border:0">
					</form>
					<h2>Submit a Book:</h2>
					<span> The link should have all the information about your book.</span>
					<form class="pure-form" method="GET">
						<input type="text" placeholder="book URL" required>
						<input type="text" placeholder="Email" required>
						<button type="submit" name="send" class="pure-button">Submit</button>
						<?php
						if(isset($_GET['send']))
						{
							$page++;
							header('location: books4kids.php?page=1');
						}
						?>
					</form>
				</div>
			</div>
		</div>

		<div class="footer" >
			© 2017 Books4Kids! Inc. All rights reserved. - Projeto Multimedia 1 - Paulo Bento Nº: 33959, Pedro Costa Nº: 31179,Rafael Rodrigues Nº: 34204.

		</div>


		<?php
		mysqli_close($conn);
		?>
	</body>
	</html>
