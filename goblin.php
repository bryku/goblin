<?php
	function goblin_route($url, $callback){
		$treeGet = explode('/',$_GET['path']);
		$treeUrl = explode('/',$url);
		if(count($treeGet) != count($treeUrl)){return false;}
		if($url !== $_GET['path']){
			$max = count($treeGet);
			if(count($treeUrl) > $max){
				$max = count($treeUrl);
			}
			for($i = 0; $i < $max; $i++){
				echo  "&nbsp; &nbsp; ".$treeGet[$i]." === ".$treeUrl[$i]."<br>";
				if($treeUrl[$i] == "*"){continue;}
				if($treeUrl[$i] == $treeGet[$i]){continue;}
				return false;
			}
		}
		
		$callback($_GET['path'], $treeGet);
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
