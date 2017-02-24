<html>
<head>

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
</head>
<body>
<div id="result"></div>
<input type="submit" id="execute">
<script>
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

var url="./read_log.php";  
//$('#execute').click(function(){

	$.ajax({      
			type:"GET",  
			url:url,      
			success:function(args){   
					$("#result").html(args);      
			},   
			error:function(e){  
					alert(e.responseText);  
			}  
	});  
//})
</script>
</body>
</html>
