<?php
	function goblin_route($route, $callback){
		$treeRoute = explode('/',$route);
		$treePath = explode('/',$_GET['path']);
		for ($i = 0; $i < count($treeRoute); $i++) {
			if($treeRoute[$i] == $treePath[$i]){continue;}
			if($treeRoute[$i] == "*"){continue;}
			return false;
		}
		$callback($_GET['path']);
		die();
	}
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
	function goblin_send_file($path){
		if(file_exists($path)){
			if(is_file($path)){
				header('Content-type: '.goblin_mimetype($path));
				header('Content-Length: '.filesize($path));
				$file = fopen($path, 'rb');
				fpassthru($file);
				fclose($file);
				die();
			}
		}
		http_response_code(410);
		echo "Gone";
		die();
	}
	function goblin_send_json($data){
		$json = json_encode($data);
		if($json){
			header('Content-type: application/json');
			echo $json;
			die();
		}
		http_response_code(422);
		echo "File Not Found";
		die();
	}
?>
