<?php 

##############################################################################################################
#### @Autor    : Dyego Fernandes de Sousa                                                                 ####
#### @Date     : 2005-07-28 (28/07/2005)                                                                  ####
#### @Title    : OO in PHP (Programação Orientada à Objetos em PHP)                                       ####
#### @SubTitle : Bar Code Geranation with the FEBRABAN Standard                                           ####
####             (Gerador de Código de Barras para Boleto padrão FEBRABAN)                                ####
#### @License  : BSD                                                                                      ####
#### @email    : dyegofernandes@centauronet.com.br, dyegofern@hotmail.com                                 ####
#### @Commnets :________________________________________________________________________________________  ####
#### |@@ Baseado em Script de encontrado na url: http://phpbrasil.com/scripts/source.php/id/1845, Cujo  | ####
#### |  autor é: MARCOLINO, Alexandre de Jesus ( marcolino@facil.com )                                  | ####
#### |@@ This Script is based in other script hosted in: http://phpbrasil.com/scripts/source.php/id/1845| ####
#### |  the autor of this base scriptis: MARCOLINO, Alexandre de Jesus ( marcolino@facil.com )          | ####
#### |__________________________________________________________________________________________________| ####
##############################################################################################################
class cd_barra {
var $file;
var $into;

var $cd_barras = array(
						0=>"00110",
						1=>"10001",
						2=>"01001",
						3=>"11000",
						4=>"00101",
						5=>"10100",
						6=>"01100",
						7=>"00011",
						8=>"10010",
						9=>"01010"
					);
	function cd_barra($value,$into=1, $filename = 'barcode.gif') { 
	  $lower = 1 ; $hight = 50;          
	  $this->into = $into;
          $this->file = $filename;
	  for($count1=9;$count1>=0;$count1--){ 
		for($count2=9;$count2>=0;$count2--){   
		  $count = ($count1 * 10) + $count2 ; 
		  $text = "" ; 
		  for($i=1;$i<6;$i++){ 
			$text .=  substr($this->cd_barras[$count1],($i-1),1) . substr($this->cd_barras[$count2],($i-1),1); 
		  } 
		  $this->cd_barras[$count] = $text; 
	   } 
	  } 
	
		  //$img 		= imagecreate($lower*95+300,$hight+30);
		  $img 		= imagecreate(395,73);    
		  $cl_black = imagecolorallocate($img, 0, 0, 0); 
		  $cl_white = imagecolorallocate($img, 255, 255, 255); 
	
	/*
		Criando o fundo para a imagem
		It Creates the background to the image
	*/             
		   
		  imagefilledrectangle($img, 0, 0, $lower*95+1000, $hight+30, $cl_white); 
		   
	/*
		Iniciando o Código de Barras
		It Begins the bar code
	*/
		  imagefilledrectangle($img, 1,5,1,65,$cl_black); 
		  imagefilledrectangle($img, 2,5,2,65,$cl_white); 
		  imagefilledrectangle($img, 3,5,3,65,$cl_black); 
		  imagefilledrectangle($img, 4,5,4,65,$cl_white); 
	
	/*
		Varrendo o Código de Barras
		Scaning the bar code
	*/
	
	$thin = 1 ; 
	if(substr_count(strtoupper($_SERVER['SERVER_SOFTWARE']),"WIN32")){
		//O tamanho para windows tem que ser 3
		// For windows, the wide bar has = 3
 		$wide = 3;
	} else {
			$wide = 2.72;
	   }
	$pos   = 5 ; 
	$text = $value ; 
	if((strlen($text) % 2) <> 0){ 
		$text = "0" . $text; 
	} 
	
	/*
		Desenhando...
		Drawing...
	*/
	while (strlen($text) > 0) { 
	  $i = round($this->barra_left($text,2)); 
	  $text = $this->barra_right($text,strlen($text)-2); 
	   
	  $f = $this->cd_barras[$i]; 
	   
	  for($i=1;$i<11;$i+=2){ 
		if (substr($f,($i-1),1) == "0") { 
		  $f1 = $thin ; 
		}else{ 
		  $f1 = $wide ; 
		} 
	
	/* 
		Imprimindo uma barra preta 
		Printing the black bar
	*/    
	  imagefilledrectangle($img, $pos,5,$pos-1+$f1,65,$cl_black)  ; 
	  $pos = $pos + $f1 ;   
	   
	  if (substr($f,$i,1) == "0") { 
		  $f2 = $thin ; 
		}else{ 
		  $f2 = $wide ; 
		} 
	
	/* 
		Imprimindo uma barra branca 
		Printing the white bar
	*/ 
	  imagefilledrectangle($img, $pos,5,$pos-1+$f2,65,$cl_white)  ; 
	  $pos = $pos + $f2 ;   
	  } 
	} 
	
	/*
		Fechando o Código de Barras
		Closing the bar code
	*/
	
	imagefilledrectangle($img, $pos,5,$pos-1+$wide,65,$cl_black); 
	$pos=$pos+$wide; 
	
	imagefilledrectangle($img, $pos,5,$pos-1+$thin,65,$cl_white); 
	$pos=$pos+$thin; 
	
	
	imagefilledrectangle($img, $pos,5,$pos-1+$thin,65,$cl_black); 
	$pos=$pos+$thin; 
	
	$this->put_img($img);
	} 
	
	function barra_left($input,$comp){ 
		return substr($input,0,$comp); 
	} 
	
	function barra_right($input,$comp){ 
		return substr($input,strlen($input)-$comp,$comp); 
	} 
	/*
		Método Para Colocar a imagem no Browser
		Method to put the image
	*/
	function put_img($image,$file='test.gif'){
		if($this->into){
			imagegif($image,$this->file);
		} else {
					header("Content-type: image/gif");
					imagegif($image);
			   }
		imagedestroy($image);
	}
}