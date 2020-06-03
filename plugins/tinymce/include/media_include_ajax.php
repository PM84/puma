<?php

$url = isset($_POST['InclURL']) ? $_POST['InclURL'] : null;
$iLauf=1;
$srcArr=array();
$srcArr=get_all_src($url);

echo "<h3>IFrame</h3>";
foreach( $srcArr['iframe'] as $src){

	$src_post="<iframe src='$src' seamless='seamless'></iframe><br><p>Quelle: <a href='$url' target=blank><b>$url</b></a></p>";
?>
<div style='float:left; border: solid gray 1px; border-radius:5px; width:110px; height:150px; margin:5px; padding:5px; box-shadow: 0px 0px 5px #888' class='PUMAMediaLIst' data-src='<?php echo $src; ?>' data-mediaID='<?php echo $iLauf; ?>'><iframe style='width:100px; height:100px;' src='<?php echo $src; ?>'></iframe><div><div  class='btn btn-default btn-block PUMAMediaInclude' style="margin-top:5px;"  data-src="<?php echo $src_post; ?>" data-mediaID='<?php echo $iLauf; ?>' >Einbinden</div></div></div>
<?php
	$iLauf++;
}
echo "<div style='clear:both;'></div><h3>Images</h3>";
foreach( $srcArr['img'] as $src){
	$src_post="<img src='$src'><br><p>Quelle: <a href='$url' target=blank><b>$url</b></a></p>";
?>
<div style='float:left; border: solid gray 1px; border-radius:5px; width:110px; height:150px; margin:5px; padding:5px; box-shadow: 0px 0px 5px #888' class='PUMAMediaLIst' data-src='<?php echo $src; ?>' data-mediaID='<?php echo $iLauf; ?>'><img style='width:100px; height:100px;' src='<?php echo $src; ?>'><div><div class='btn btn-default btn-block PUMAMediaInclude'  style="margin-top:5px;" data-src="<?php echo $src_post; ?>" data-mediaID='<?php echo $iLauf; ?>'>Einbinden</div></div></div>
<?php
	$iLauf++;
}


function get_all_src($url){
	$retArr=array();
	$urlParts=parse_url($url);
	libxml_use_internal_errors(true);
	$document = new DOMDocument();
	$document->loadHTML(file_get_contents($url));
	libxml_use_internal_errors(false);
	$lst = $document->getElementsByTagName('iframe');

	$retArr['iframe']=array();
	for ($i=0; $i<$lst->length; $i++) {
		$iframe= $lst->item($i);
		$src=$iframe->attributes->getNamedItem('src')->value;
		$suchmuster= '/^(http|https):[\/]*/';
		$trefferArr="";
		if (preg_match_all($suchmuster, $src, $trefferArr)) {
			if(filter_Blacklist($src)){
				// 				if(strpos($url,"wikipedia.org")!==false){
				array_push($retArr['iframe'],$src);
				// 				}else{
				// 					array_push($retArr['iframe'],$src);
				// 				}
			}
		}else{
			$swfSimulationPath= $urlParts["scheme"]."://".$urlParts['host'].$src;
			if(filter_Blacklist($src)){
				array_push($retArr['iframe'],$swfSimulationPath);
			}
		}
	}

	$lst = $document->getElementsByTagName('img');
	$retArr['img']=array();
	for ($i=0; $i<$lst->length; $i++) {
		// 		var_dump($retArr['img']);
		$iframe= $lst->item($i);
		$src=$iframe->attributes->getNamedItem('src')->value;
		$suchmuster= '/^(http|https):[\/]*/';
		$trefferArr="";
		if (preg_match_all($suchmuster, $src, $trefferArr)) {
			if(filter_Blacklist($src)){
				if(strpos($url,"wikipedia.org")!==false){
					array_push($retArr['img'],$src);
				}else{
					array_push($retArr['img'],$src);
				}
			}
		}else{
			if(filter_Blacklist($src)){
				if(strpos($url,"wikipedia.org")===FALSE){
					$swfSimulationPath= $urlParts["scheme"]."://".$urlParts['host'].$src;
					// 					$swfSimulationPath= $urlParts["scheme"]."://".$src;
					array_push($retArr['img'],$swfSimulationPath);
				}else{
					if(strpos($src,"static/images/")===FALSE){
						$swfSimulationPath= $urlParts["scheme"].":".$src;
						array_push($retArr['img'],$swfSimulationPath);
					}else{
						$swfSimulationPath= $urlParts["scheme"]."://".$urlParts['host'].$src;
						array_push($retArr['img'],$swfSimulationPath);
					}
				}
				// 				array_push($retArr['img'],$swfSimulationPath);
			}
		}
	}
	// 	var_dump($retArr);
	return $retArr;
}


function filter_Blacklist($src){

	$Blacklist_iframe=array("https://www.leifiphysik.de/sites/default/jhs-footer/footer.html");


	$Blacklist_img=array("https://www.leifiphysik.de/sites/all/themes/leifi_responsive/images/login_lock.png","https://www.leifiphysik.de/sites/default/files/medien/leifi-physik-logo_0.jpg", "https://www.leifiphysik.de/sites/default/files/medien/mechanik_0.png", "https://www.leifiphysik.de/sites/default/files/medien/optik_0.png", "https://www.leifiphysik.de/sites/default/files/medien/elektrizitat_0.png", "https://www.leifiphysik.de/sites/default/files/medien/elektronik_32x30_0_0.png","https://www.leifiphysik.de/sites/default/files/medien/waermelehre_0.png","https://www.leifiphysik.de/sites/default/files/medien/akkustik_32x30.png","https://www.leifiphysik.de/sites/default/files/medien/quantenphysik_32x30_0.png","https://www.leifiphysik.de/sites/default/files/medien/astronomie_0.png","https://www.leifiphysik.de/sites/default/files/medien/atomphysik_0.png","https://www.leifiphysik.de/sites/default/files/medien/kernphysik_32x30_4.png","https://www.leifiphysik.de/sites/default/files/medien/relativitat_0.png","https://www.leifiphysik.de/sites/default/files/medien/ubergreifend_0.png","https://www.leifiphysik.de/sites/default/files/joachim-herz-stiftung-logo-neu.jpg","https://www.leifiphysik.de/sites/all/modules/leifi/img/search.png","https://www.leifiphysik.de/sites/default/files/medien/auftrieb_overview_slide.jpg","https://www.leifiphysik.de/sites/default/files/medien/mechanik_0.png","https://www.leifiphysik.de/sites/all/modules/leifi/img/br_up.png","https://www.leifiphysik.de/sites/default/files/print-icon.png","https://www.leifiphysik.de/sites/default/files/medien/feedback_0.png","https://www.leifiphysik.de/sites/all/modules/print/icons/print_icon.gif","https://www.leifiphysik.de/sites/all/modules/print/icons/pdf_icon.gif","https://www.leifiphysik.de/sites/all/modules/leifi/img/feedback.jpg","https://www.leifiphysik.de/sites/default/files/facebook-footer.png" );

	if(in_array($src,$Blacklist_iframe)==false && in_array($src,$Blacklist_img)==false){
		return true;
	}else{
		return false;
	}
}