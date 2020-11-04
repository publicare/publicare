<?
global $_page;

//	include('../../../publicare.conf');
	include($_SERVER['DOCUMENT_ROOT'].'/../publicare.conf');
	require ("shortinclude2.php");
	require ("funcoes.php");
	
	$cod_blob = $_GET["cod_blob"];
	$width = $_GET["width"];
	$height = $_GET["height"];
	
	$subpasta = identificaPasta($cod_blob);
	
	if (defined('_BLOBDIR'))
	{
	
		$sql = 'select arquivo from tbl_blob where cod_blob='.$cod_blob;
		$rs = $_db->ExecSQL($sql);
		
//		echo $sql;
		
		$filename = $rs->fields['arquivo'];
		$filetype = strtolower(preg_replace('/\A.*?\./is','',$filename));
		
//		echo $filename;
		
		switch ($filetype)
		{
			case 'gif':
				$im=ImageCreateFromGif(_BLOBDIR.$subpasta.'/'.$cod_blob.'.'.$filetype);
				break;
			
			case 'jpg':
				$im=ImageCreateFromJPEG(_BLOBDIR.$subpasta.'/'.$cod_blob.'.'.$filetype);
				break;
			
			case 'png':
				$im=ImageCreateFromPNG(_BLOBDIR.$subpasta.'/'.$cod_blob.'.'.$filetype);
				break;
		}

	$x=ImageSX($im);
	$y=ImageSY($im);
	

	}
	if ($width || $height)
	{
		$x=ImageSX($im);
		$y=ImageSY($im);
	
		if (!$width)
			$width=ceil($x*$height/$y);
		if (!$height)
			$height=ceil($width*$y/$x);
		if ($filetype=='jpg')
			$newim=ImageCreateTrueColor($width,$height);
		else
			$newim=ImageCreate($width,$height);
		
		ImageCopyResampled($newim,$im,0,0,0,0,$width,$height,$x,$y);
		$im=$newim;
	}
	switch ($filetype)
	{
		case 'gif':
			ImageGif($im);
			break;
		
		case 'jpg':
			ImageJpeg($im);
			break;
		
		case 'png':
			ImagePNG($im);
			break;
	}
?>
