<?php

// Link a la fuente (https://fonts.google.com/specimen/Courgette)
$fontname = 'font/Courgette.ttf';
// Espaciado inicial del texto
$i=0;
//Calidad de la imagen JPG 0-100
$quality = 90;

function create_image($user){
		global $i;
		global $fontname;	
		global $quality;
		//echo $user;
		$file = "covers/".md5($user[0]['name'].$user[1]['name'].$user[2]['name']).".jpg";	
	
	//Si ya existe, no se crea (Se quita para depurar)	
	if (!file_exists($file)) {	
			

			// Imagen base utilizada para poner texto encima
			$im = imagecreatefromjpeg("imagen1_calendario.jpg");
			
			// Se generan los colores a utilizar
			$color['white'] = imagecolorallocate($im, 255, 255, 255);
			$color['green'] = imagecolorallocate($im, 55, 189, 102);
			$color['black'] = imagecolorallocate($im, 0, 0, 0);
			$color['red'] = imagecolorallocate($im, 255, 0, 0);
 

			// Definimos la linea de inicio del texto
			$height=0;
			$y=0;
			$numLin=0;
		//Calculamos las lineas para centrar el texto verticalmente.
		foreach ($user as $value){	
			if(strlen($value['name'])>0)
				$numLin=$numLin+1;
		}

		if($numLin==1)
			$y = imagesy($im) - $height - 400;
		else
			$y = imagesy($im) - $height - 4200;

 		//Posición inicial del texto
 		$x=1300;
		// Recorremos el array y escribimos el texto	
		foreach ($user as $value){
			// Función de calculo del centro de la imagen.
			//$x = center_text($value['name'], $value['font-size']);	

			imagettftext($im, $value['font-size'], 0, $x, $y+$i, $color[$value['color']], $fontname,$value['name']);
			// Añadimos 50px de desplazamiento a la siguiente linea
			$i = $i+200;	
			//Desplazamiento de la siguiente linea de texto
			$x = $x+120;
			
		}
			// Creamos la imagen
			imagejpeg($im, $file, $quality);
			
	}
						
		return $file;	
}

function center_text($string, $font_size){

			global $fontname;

			$image_width = 800;
			$dimensions = imagettfbbox($font_size, 0, $fontname, $string);
			
			return ceil(($image_width - $dimensions[4]) /1);				
}



	$user = array(
	
		array(
			'name'=> 'La Oficina de Software Libre', 
			'font-size'=>'100',
			'color'=>'white'),
			
		array(
			'name'=> 'Quiere desearte unas felices fiestas',
			'font-size'=>'70',
			'color'=>'white'),
			
		array(
			'name'=> '¡Y un próspero año nuevo!',
			'font-size'=>'70',
			'color'=>'white'
			)
			
	);
	
	
	if(isset($_POST['submit'])){
	
	$error = array();
	
		if(strlen($_POST['nombre'])==0){
			$error[] = 'Inserta Titulo';
		}
		
		//if(strlen($_POST['dedicatoria'])==0){
		//	$error[] = 'Inserta Primera Dedicatoria';
		//}		

		//if(strlen($_POST['dedicatoria2'])==0){
		//	$error[] = 'Please enter an email address';
		//}
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_POST['nombre'], 
			'font-size'=>'120',
			'color'=>'white'),
			
		array(
			'name'=> $_POST['dedicatoria'],
			'font-size'=>'90',
			'color'=>'white'),
			
		array(
			'name'=> $_POST['dedicatoria2'],
			'font-size'=>'90',
			'color'=>'white'
			)
			
	);		
		
	}
		
	}
// run the script to create the image
$filename = create_image($user);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generador de Postales Navideñas de la Oficina de Software Libre</title>
<style>

* {

    font-family: 'Alef', sans-serif;

}


input{
	border:1px solid #ccc;
	padding:8px;
	font-size:14px;
	width:300px;
	}
	
.submit{
	width:110px;
	background-color:#FF6;
	padding:3px;
	border:1px solid #FC0;
	margin-top:20px;}	

body{
    display: table-cell;
    vertical-align: middle;
	background-image: url("font/back.jpeg");
	background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: right; 
    display: flex;
    margin: 1%;
    }


html {display:table; width:100%;}
body { text-align:center; vertical-align:middle;}

input{
	float: right;
	display: inline;
	}
label{
	float: left;
	display: inline;
	padding: 9px;
    font-size: 14px;
    width: 300px;
	}
.formulario{
	margin: auto;

}

.divimagen{
    margin: 2%;
    padding: 1%;
    width: 60%;
    background: rgba(255, 255, 255, 0.7);
    margin-left: auto;
    margin-right: auto;
}
.cuerpo{
	margin: 2%;
        width: 40%;
	background: rgba(255, 255, 255, 0.7);
	padding: 1%;
	margin-left: 0%;
}





</style>

</head>

<body>

<div class="divimagen">
<p style="font-size: 20px;    color: red;    width: 80%;"><b> 1. Esta es la imagen elegida</b></p>
<img src="<?=$filename;?>?id=<?=rand(0,1292938);?>" width="80%" height="90%"/><br/><br/>
</div>

<div class="cuerpo">



<p style="font-size:  20px; color: red; width: 40%;display:  inline-table;"><b> 2. Introduce el texto</b></p>
<div class="formulario">
	<form action="" method="post">
	<label for="name">Linea Principal*</label>
	<input required type="text" value="<?php if(isset($_POST['nombre'])){echo $_POST['nombre'];}?>" name="nombre" maxlength="30" placeholder="Nombre"><br/>
	<label for="dedicatoria">Dedicatoria linea 1</label>
	<input required type="text" value="<?php if(isset($_POST['dedicatoria'])){echo $_POST['dedicatoria'];}?>" name="dedicatoria" placeholder="Dedicatoria Linea 1"><br/>
	<label for="dedicatoria2">Dedicatoria linea 2</label>
	<input required type="text" value="<?php if(isset($_POST['dedicatoria2'])){echo $_POST['dedicatoria2'];}?>" name="dedicatoria2" placeholder="Dedicatoria Linea 2"><br/>
	
<p style="font-size:  20px; color: red; width: 100%;display:  inline-table;"><b> 3. Actualiza tu imagen</b></p>
	<input name="submit" type="submit" class="btn btn-primary" value="Actualizar Imagen" style="margin: 3%;" />
<p style="font-size:  20px; color: red; width: 100%;display:  inline-table;"><b> 4. Descarga la felicitación</b></p>
	<input value="Descargar Imagen" type="submit" onclick="document.getElementById('<?=$filename;?>').click()" style="margin: 3%;"/>
	<a id="<?=$filename;?>" href="<?=$filename;?>"" download hidden></a>
<p style="font-size:  0px; color: red; width: 100%;display:  inline-table;"> 4. Descarga la felicitación</p>
		<input style="margin: 3%;" value="Volver a la Web" type="button" class="button_active" onclick="location.href='http://osl.ugr.es/generador-de-felicitaciones-navidenas-de-la-oficina-de-software-libre/';" />

	</form>
</div>

</div>

</body>
</html>
