<?php
$maxAge=3600;// max age in seconds, scans older that this will be deleted
if(isset($_GET['file'])){
	if(strrpos($_GET['file'], "/")>-1)
		$_GET['file']=substr($_GET['file'],strrpos($_GET['file'],"/")+1);
	$file=$_GET['file'];
	$file0=substr($file,0,strrpos($file,"."));
	echo '{"state":'.((@unlink("scans/Preview_$file0.jpg")&&@unlink("scans/Scan_$file"))?0:1).',"file":"'.$file.'"}';
}
else{
	echo "<pre>\n";
	$loc=$_SERVER['DOCUMENT_ROOT'].str_replace('cleaner.php','scans',$_SERVER['SCRIPT_NAME']);
	$lst=scandir($loc);
	for($i=2,$max=count($lst);$i<$max;$i++){
		if($lst[$i]!='.'&&$lst[$i]!='..'){
			if(time()-filemtime($loc.'/'.$lst[$i])>$maxAge){
				unlink($loc.'/'.$lst[$i]);
				echo "Removed: ".$loc.'/'.$lst[$i]."\n";
			}
		}
	}
	echo "</pre>\n";
}
?>
