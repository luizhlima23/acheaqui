<?php

class CropperComponent extends Component{
	
	public $components = array('Session');

	/**
	 * Move e/ou corta a imagem de acordo com os dados passados previamente
	 *
	 * @param string $data: json encoded, dados de corte da imagem;
	 * @param array $file: type file data array
	 * @param array $options: array de parametros ($dir=diretório de upload, $src=caminho de imagem existente)
	 */
	public function cropper_galeria_empresa($data=null, $file=null, $options=null){

		if(is_null($data) or is_null($file)) return false;
		$response = array('state'=>null, 'message'=>null, 'result'=>null);

		// prepara variáveis
		$data = $this->_data($data);
		if(is_null($options) or !is_array($options)){

			$options = array(
				'dir' => $this->_dir(),
				'src' => null,
				'name' => date('YmdHis')
			);
		}
		$dir = $options['dir'];
		$src_old = $options['src'];
		$name = $options['name'];

		if($file_src = $this->upload($file, $options)){

			if( $src = $this->crop($file_src, $data, $options) ){
					
				$response = array(
					'state'  => 200,
					'message' => 'Arquivo salvo com sucesso!',
					'result' => $src
				);

				// excluir arquivo temporário
				if (file_exists($file_src)) {
					unlink($file_src);
				}
				// excluir arquivo antigo
				if (file_exists($src_old)) {
					unlink($src_old);
				}
			}
		}
		else{

			$response['message'] = $this->error;
		}

		return $response;
	}

	private function _data($data=null) {
		
		if(!is_null($data)){

			$data = json_decode(stripslashes($data));
		}

		return $data;
	}

	private function _dir() {
		
		return 'uploads/';
	}

	private function upload($file=null, $options=null) {
		
		$errorCode = $file['error'];

		if($errorCode === UPLOAD_ERR_OK) {

			$type = exif_imagetype($file['tmp_name']);

			if($type) {

				$extension = image_type_to_extension($type);
				$name = $options['name'];
				$src_temp = TMP . $name . '-original' . $extension;

				if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

					if (file_exists($src_temp)) {
						unlink($src_temp);
					}

					$move = move_uploaded_file($file['tmp_name'], $src_temp);

					if ($move) {

						return $src_temp;
					}
					else {

						$this->error = 'Falha ao salvar o arquivo.';
					}
				}
				else{

					$this->error = 'Carregue uma imagem com os seguintes tipos: JPG, PNG, GIF';
				}
			}
			else {

				$this->error = 'Envie um arquivo de imagem.';
			}
		}
		else{

			$this->error = $this->codeToMessage($errorCode);
		}

		return false;
	}

	private function crop($src=null, $data=null, $options=null) {

		if(empty($src) or empty($data) or empty($options) or !is_array($options)) return false;
		if(!isset($options['dir']) or !isset($options['name'])) return false;

		if(isset($options['width'])){

			if(is_int($options['width'])) $crop_width = $options['width'];
		}

		if(isset($options['height'])){

			if(is_int($options['height'])) $crop_height = $options['height'];
		}

		// variáveis necessárias
		$type = exif_imagetype($src);
		$extension = image_type_to_extension($type);
		$dst = $options['dir'] . $options['name'] . '-croped' . $extension;
		
		switch ($type) {

			case IMAGETYPE_GIF:
				$src_img = imagecreatefromgif($src);
				break;

			case IMAGETYPE_JPEG:
				$src_img = imagecreatefromjpeg($src);
				break;

			case IMAGETYPE_PNG:
				$src_img = imagecreatefrompng($src);
				break;
		}

		if (!$src_img) {
			$this->error = "Falha ao ler o arquivo de imagem";
			return false;
		}

		$size = getimagesize($src);
		$size_w = $size[0]; // natural width
		$size_h = $size[1]; // natural height

		$src_img_w = $size_w;
		$src_img_h = $size_h;

		$degrees = $data->rotate;

		// Rotate the source image
		if (is_numeric($degrees) && $degrees != 0) {

			// PHP's degrees is opposite to CSS's degrees
			$new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

			imagedestroy($src_img);
			$src_img = $new_img;

			$deg = abs($degrees) % 180;
			$arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

			$src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
			$src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

			// Fix rotated image miss 1px issue when degrees < 0
			$src_img_w -= 1;
			$src_img_h -= 1;
		}

		$tmp_img_w = $data->width;
		$tmp_img_h = $data->height;
		$dst_img_w = (isset($crop_width))? $crop_width: 220;
		$dst_img_h = (isset($crop_height))? $crop_height: 220;

		$src_x = $data->x;
		$src_y = $data->y;

		if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
			$src_x = $src_w = $dst_x = $dst_w = 0;
		}
		else if ($src_x <= 0) {
			
			$dst_x = -$src_x;
			$src_x = 0;
			$src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
		}
		else if ($src_x <= $src_img_w) {

			$dst_x = 0;
			$src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
		}

		if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
			$src_y = $src_h = $dst_y = $dst_h = 0;
		}
		else if ($src_y <= 0) {

			$dst_y = -$src_y;
			$src_y = 0;
			$src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
		}
		else if ($src_y <= $src_img_h) {

			$dst_y = 0;
			$src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
		}

		// Scale to destination position and size
		$ratio = $tmp_img_w / $dst_img_w;
		$dst_x /= $ratio;
		$dst_y /= $ratio;
		$dst_w /= $ratio;
		$dst_h /= $ratio;

		$dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

		// Add transparent background to destination image
		imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
		imagesavealpha($dst_img, true);

		$result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

		if ($result) {
			if (!imagejpeg($dst_img, $dst)) {
				$this->error = "Falha ao salvar o arquivo de imagem cortada";
			}

			return $dst;
		}
		else {
			$this->error = "Falha ao cortar o arquivo de imagem";
		}

		imagedestroy($src_img);
		imagedestroy($dst_img);

		return true;
	}

	private function codeToMessage($code) {
		$errors = array(
			UPLOAD_ERR_INI_SIZE =>'O arquivo enviado excede a diretiva upload_max_filesize no php.ini',
			UPLOAD_ERR_FORM_SIZE =>'O arquivo enviado excede a diretiva MAX_FILE_SIZE que foi especificada no formulário HTML',
			UPLOAD_ERR_PARTIAL =>'O arquivo não foi enviado por completo',
			UPLOAD_ERR_NO_FILE =>'Nenhum arquivo foi enviado',
			UPLOAD_ERR_NO_TMP_DIR =>'Pasta temporária não encontrada',
			UPLOAD_ERR_CANT_WRITE =>'Falha ao gravar o arquivo no disco',
			UPLOAD_ERR_EXTENSION =>'File upload stopped by extension',
		);

		if (array_key_exists($code, $errors)) {
			return $errors[$code];
		}

		return 'Erro desconhecido';
	}

	public function getResult() {
		return !empty($this -> data) ? $this -> dst : $this -> src;
	}

	public function getMsg() {
		return $this -> msg;
	}

}

?>