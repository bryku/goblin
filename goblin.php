<?php
	function goblin_mimetype($path){
		$dir = explode(".", $path);
		$ext = end($dir);
		// Most Common Mimes
		if($ext == 'ico'){return "image/vnd.microsoft.icon";}
		if($ext == 'html'){return "text/html";}
		if($ext == 'css'){return "text/css";}
		if($ext == 'js'){return "text/javascript";}
		if($ext == 'json'){return "application/json";}
		// All Mimes
		$file = file('.mime_type.tsv');
		if($file){
			foreach($file as $line){
				if(str_starts_with($line, $ext)){
					$temp = explode("	",$line);
					return end($temp);
				}
			}
		}
		// Default
		return 'text/plain';
	}
	function goblin_SendFile($path){
		if(file_exists($path)){
			if(is_file($path)){
				header('Content-type: '.mime_type($path));
				header('Content-Length: '.filesize($path));
				$file = fopen($path, 'rb');
				fpassthru($file);
				fclose($file);
				die();
			}
		}
		http_response_code(404);
		echo "Not Found";
		die();
	}
?>
