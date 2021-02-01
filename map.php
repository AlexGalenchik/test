<?php
  // Входные параметры
$id = $_GET['id']
 ?>
<html>
<head>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" href="materialize/css/materialize.css"> -->

<style>
#content {
	position: absolute;
	top: 10px;
	z-index: -1;
}
 
div.switch {
	height: 25px;
	z-index: 2;
	margin-top: 37px;
	padding-top: 20px;
}

div#rapper{
	z-index: -1;
}
 
</style>


</head>

<body> 
<div class="switch">
    <label>
      <span>Слой БС  On</span>
	  
      <input type="checkbox" id="choose">
      <span class="lever"> Off </span>
	  
      
    </label>
</div>

<div id="rapper">

	<div class="map first" style="display: none">	
<script type="text/javascript" alt="загрузка карты..." charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A8176eaa89287c55f0bfe41c343e465a836f20a1703144d04acceb55dba0cbb04&amp;width=100%&amp;height=800&amp;lang=ru_RU&amp;scroll=true"></script>
	

	</div>
    <div class="map second">
	
		<script type="text/javascript" alt="загрузка карты..." charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A8bdbcd15edc746797b84b11e5377029c6b0eae4796f61e0dcfd13f25225ab02f&amp;width=100%&amp;height=800&amp;lang=ru_RU&amp;scroll=true"></script>
			
	
</div>
<h3>Загружается карта...Ждите.</h3>
 </div>
 
<script>
document.querySelector('#choose').onclick = function () {
	let first = document.querySelector('.first');
 	let second = document.querySelector('.second');
 	 
	if (this.checked) {
			first.style.display = 'block';
		second.style.display = 'none';
		 
	}
    else{
	first.style.display = 'none';
		second.style.display = 'block';
	}
}


 </script> 
 
 
 
</body>


</html>

