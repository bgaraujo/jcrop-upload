
$(document).ready(function (e) {
	$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		$("#message").empty();
		$('#loading').show();

		$.ajax({
			url: "ajax_php_file.php",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			dataType: 'json',
			success: function(data){
				$('#loading').hide();
				console.log(data);
			}
		});
	}));

	function uploadSusscess(){

	}

// Function to preview image after validation
	$(function() {
		$("#file").change(function() {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
				$('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				console.log("false");
				return false;
			}else{
				console.log("true");
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
	});

	function imageIsLoaded(e) {
		//$("#image_modal").show();
		$('#previewing').attr('src', e.target.result);
		//$('#previewing').attr('width', '250px');
		//$('#previewing').attr('height', '230px');
		$('#previewing').Jcrop({
			onChange: showPreview,
			onSelect: showPreview,
			aspectRatio: 1,
    		onSelect: updateCoords
		});
	};

	function showPreview(coords){
		var rx = 100 / coords.w;
		var ry = 100 / coords.h;

		$('#preview').css({
			width: Math.round(rx * 500) + 'px',
			height: Math.round(ry * 370) + 'px',
			marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			marginTop: '-' + Math.round(ry * coords.y) + 'px'
		});
	}

	function updateCoords(c){
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };

});