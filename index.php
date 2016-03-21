<html>
	<head>
		<title>Ajax Image Upload Using PHP and jQuery</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.Jcrop.js"></script>

		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

		<link rel="stylesheet" href="style.css" />

	</head>
	<body>
		<div class="main">
			<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
				<div id="selectImage">
					<label>Selecione a imagem</label><br/>
					<input type="file" name="file" id="file" required />
					<input type="submit" value="Upload" class="submit" />
				</div>


				<input type="hidden" id="x" name="x" />
	            <input type="hidden" id="y" name="y" />
	            <input type="hidden" id="w" name="w" />
	            <input type="hidden" id="h" name="h" />
			</form>
		</div>
		<h4 id='loading' hidden>loading..</h4>
	</body>
	<div id="image_modal" class="" >
		<img id="previewing" src="noimage.png" />
	</div>
</html>

<script src="script.js"></script>
