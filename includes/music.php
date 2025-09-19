<!DOCTYPE html>
<html lang="en">
<head>
<title>SnakeBeings Audio</title>

    
    
<style type="text/css">
    body {
	background-color: #cccccc;
	margin-left: 12px;
	
}
 <!-- HIGHLIGHT LISTS OF SONGS -->
.active {
    background: #f00;
}
    
  div {
    float: left;
  }
  span {
    color: blue;
  }
  a:link {
	color: #0A00FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0A00FF;
}
a:hover {
	text-decoration: none;
	color: #07F529;
}
a:active {
	text-decoration: none;
	color: #0A00FF;
}
</style>
    

</head>
<body>
<h2>GitHubDemo files: Sound only</h2><br>
<h4><a href="https://circuit47.com">www.circuit47.com</a></h4>
<br>
  
  
  
  
  <br>
 
<br>
<audio id="myAudio" controls width="300" height="32" autoplay>
  <source src="<?php echo($song2);?>" type="audio/mpeg">
Your browser does not support the audio element. </audio>

<p>

			<br>
  <script>
				//TRANSFERE THE PHP VARIABLE LIST OF SONGS $SONG2 INTO THE JAVASCRIPT VAR NUM AND var somany = $howmanysongs;
				var num = <?php echo $song2 ?>;
				


				var aud = document.getElementById( "myAudio" );
				aud.onended = function () {

					window.location.replace( '<?php echo $pageName ?>?song=' + num );
				};
			</script>



			<br><br>
	
	
<br><br>
<br>
</html>