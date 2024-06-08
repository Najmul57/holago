<?php
namespace App\Http\Traits;

use Exception;
use Intervention\Image\Facades\Image;

trait FileUploadTrait{

	/*
	*	Start file uploading
	*/
	protected function uploadFile($type,$data){
		$filename = $this->fileUploadProcess($data);
		if ($type == 'image') {
			$this->uploadImage($data,$filename);
		}else{
			move_uploaded_file($data['file'], $data['path'] . '/' . $filename);
		}
		return $filename;
	}


	/*
	* Upload Image file
	*/
	protected function uploadImage($data,$filename){
		$image = Image::make($data['file']);
		if (@$data['size']) {
			$size = explode('x', $data['size']);
			$image->resize($size[0], $size[1]);
		}
		$image->save($data['path'] . '/' . $filename);
	}

	/*
	* File upload process
	*/
	private function fileUploadProcess($data){
		$path = $this->createFolder($data['path']);
    	if (!$path) throw new Exception('Path not found');
    	if ($data['prevFile']) {
    		$this->deleteFile($data['path'].'/'.$data['prevFile']);
    	}
    	return $this->getFileName($data['file']);
	}


	/*
	* Make directory if not exist
	*/
	private function createFolder($locat){
		if (!file_exists($locat)){
    		return mkdir($locat, 0755, true);
		}else{
			return true;
		}
	}


	/*
	* Delete file if exist
	*/
	protected function deleteFile($locat){
		if(file_exists($locat) && is_file($locat)){
       		@unlink($locat);
	    }
	}

	/*
	* Generate filename
	*/
	private function getFileName($file){
		return $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
	}
}
