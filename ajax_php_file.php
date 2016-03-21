<?php
if(isset($_FILES["file"]["type"])){
	$validextensions = array("jpeg", "jpg", "png");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = end($temporary);
	if (
			(
				($_FILES["file"]["type"] == "image/png") || 
				($_FILES["file"]["type"] == "image/jpg") || 
				($_FILES["file"]["type"] == "image/jpeg")
			) && 
			($_FILES["file"]["size"] < 2000000) && 
			in_array($file_extension, $validextensions)
		){
		if ($_FILES["file"]["error"] > 0){
			echo json_encode(array("error"=>$_FILES["file"]["error"]));
		}else{
			if (file_exists("upload/" . $_FILES["file"]["name"])) {
				echo json_encode(array("error"=>$_FILES["file"]["name"]."already exists"));
			}else{
				$tmp     = $_FILES['file']['tmp_name'];
				$ext     = explode('.',$_FILES["file"]["name"]);
				$cName   = uniqid().".".$ext[1];
				$pasta   = 'upload/';
				$permiti = array('jpg', 'jpeg', 'png');
				$upload  = move_uploaded_file($tmp, "upload/".$cName);
				$width   = $_POST['w'];
				$height  = $_POST['h'];
				echo json_encode(resize_crop_image($width, $height, $pasta.'/'.$cName, $pasta.'/'.$cName));
	/*
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				echo json_encode(Array("name"=>$_FILES["file"]["name"]));
*/
			}
		}
	}else{
		echo json_encode(array("error"=>"Invalid file Size or Type"));
	}
}





	function resize_crop_image($width, $height, $source_file, $dst_dir, $quality = 60){

		$imgsize = getimagesize($source_file);
		$max_width = 400;
		$max_height = 400;
		$mime = $imgsize['mime'];
		//resize and crop image by center
		switch($mime){
			case 'image/gif':
				$image_create = "imagecreatefromgif";
				$image = "imagegif";
			break;
			//resize and crop image by center
			case 'image/png':
				$image_create = "imagecreatefrompng";
				$image = "imagepng";
				$quality = 6;
			break;
			//resize and crop image by center
			case 'image/jpeg':
				$image_create = "imagecreatefromjpeg";
				$image = "imagejpeg";
				$quality = 60;
			break;

			default:
				return false;
			break;
		}

		$dst_img = imagecreatetruecolor($max_width, $max_height);
		$src_img = $image_create($source_file);
		$width_new = $height * $max_width / $max_height;
		$height_new = $width * $max_height / $max_width;
		if($width_new > $width){
			$h_point = (($height - $height_new) / 2);
			imagecopyresampled($dst_img, $src_img, 0, 0 , $_POST['x'], $_POST['y'], $max_width, $max_height, $width, $height_new);
		}else{
			$w_point = (($width - $width_new) / 2);
			imagecopyresampled($dst_img, $src_img,0,0, $_POST['x'], $_POST['y'], $max_width, $max_height, $width_new, $height);
		}
		$image($dst_img, $dst_dir, $quality);
		if($dst_img)
			imagedestroy($dst_img);
		if($src_img)
			imagedestroy($src_img);
  	}

?>