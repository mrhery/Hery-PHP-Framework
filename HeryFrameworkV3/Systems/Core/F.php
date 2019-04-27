<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class F{
	public function __construct(){	}
	
	public static function URLEncode($url){
		return urlencode($url);
	}
	
	public static function URLDecode($url, $cpecialChar = false){
		if($specialChars == true){
			$url = self::HTMLChars($url);
		}
		return urldecode($url);
	}
	
	public static function URLSlugEncode($url){
		$url = str_replace("-", "x00", $url);
		$url = str_replace(" ", "-", $url);
		$url = str_replace("&", "x01", $url);
		$url = str_replace("?", "x02", $url);
		$url = str_replace("#", "x03", $url);
		$url = str_replace("/", "x04", $url);
		$url = str_replace("\\", "x05", $url);
		
		return $url;
	}
	
	public static function URLSlugDecode($url, $specialChars = false){
		$url = str_replace("-", " ", $url);
		$url = str_replace("x00", "-", $url);
		$url = str_replace("x01", "&", $url);
		$url = str_replace("x02", "?", $url);
		$url = str_replace("x03", "#", $url);
		$url = str_replace("x04", "/", $url);
		$url = str_replace("x05", "\\", $url);
		
		if($specialChars == true){
			$url = htmlspecialchars($url);
		}
		return $url;
	}
	
	public static function StringChar($str){
		return htmlspecialchars($str);
	}
	
	public static function Encode64($string){
		return base64_encode($string);
	}
	
	public static function Decode64($string){
		return base64_decode($string);
	}
	
	public static function Extract($method){
		$json = json_encode($method);
		return json_decode($json);
	}
	
	public static function Encrypt($string = ""){
		$salt = "5a7347f6fda4a346760af782d2ec126f7b9873ea9a7f2bb1fee9abdfd5f4dfc9";
		$string = $string . $salt;
		return hash("sha256", $string);
	}
	
	public static function UniqKey($prefix = ""){
		return $prefix . uniqid();
	}
	
	public static function GetDate($time = 0, $full = false){
		if($time < 1){
			$time = time() + 28800;
		}else{
			$time = time() + $time;
		}
		
		if($full){
			$date = gmdate("d-M-Y H:i:s\ ", $time);
		}else{
			$date = date("d-M-Y", $time);
		}
		return $date;
	}
	
	public static function GetTime($date = ""){
		if(empty($date)){
			$time = time() + 28800;
		}else{
			$time = strtotime($date);
		}
		return $time;
	}
	
	public static function URLParams($encode = false){
		$host = $_SERVER["HTTP_HOST"];
		$request_uri = $_SERVER["REQUEST_URI"];
		$uri = $host . $request_uri;
		$x = parse_url($uri);
		
		if($encode){
			$x = F::Encode64($x["query"]);
		}else{
			$x = $x["query"];
		}
		
		return $x;
	}
	
	public static function TrimWord($string, $limit){
		if (strlen($string) > $limit){
			$string = substr($string, 0, $limit) . ' ...';
		}
		return $string;
	}
	
	public static function ObjInArray($array, $index, $value)
    {
        foreach($array as $arrayInf) {
            if($arrayInf->{$index} == $value) {
                return $arrayInf;
            }
        }
        return null;
    }
    
    public static function String($string){
    	return htmlspecialchars($string);
    }
    
    #UplodImage() Method
    #This method is an automatic resizing the vector and quality for uploaded image
    #
    #How to use?
    #
    #	$pathinfo = pathinfo($_FILES["file"]["name"]);
    #	$bool = F::UploadImage($_FILES["file"]["tmp_name"], "path/to/upload", $pathinfo["extension"], 550, 368);
    #
    public static function UploadImage($temp, $path, $file_type, $dw = "", $dh = ""){
    	$source_image = FALSE;
    	
    	if(empty($dw) OR empty($dh)){
    		$dw = 550;
    		$dh = 368;
    	}
	
		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($temp);
		}
		elseif (preg_match("/png|PNG/", $file_type)) {
			
			if (!$source_image = @imagecreatefrompng($temp)) {
				$source_image = imagecreatefromjpeg($temp);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($temp);
		}		
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($temp);
		}
	
		$ow = imageSX($source_image);
		$oh = imageSY($source_image);
		
		$o_aspect = $ow / $oh;
		$d_aspect = $dw / $dh;
		
		
		if($o_aspect >= $d_aspect){
			$n_width = $dw;
			$n_height = $oh / ($ow / $dw);
		}else{
			$n_height = $dh;
			$n_width = $ow / ($oh / $dh);
		}
		
		$virtual_image = imagecreatetruecolor($dw, $dh);
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);
		
		
		
		$con = imagecopyresampled($virtual_image, $source_image, (0 - ($n_width - $dw) / 2), (0 - ($n_height - $dh) / 2), 0, 0, $n_width, $n_height, $ow, $oh);
	
		
		if (@imagejpeg($virtual_image, $path, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			$a["ow"] = $ow;
			$a["oh"] = $oh;
			$a["original_aspect"] = $o_aspect;
			$a["desire_aspect"] = $d_aspect;
			//echo json_encode($a);
			return true;
		} else {
			return false;
		}
    }
}

?>