<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileUploadService {

	public function uploadFile($file, $path){
		
		if($file) {

			$name   = time() . $file->getClientOriginalName();
			$location = $path.'/'. $name;

			//Save file
			
			Storage::put($location, File::get($file));
			$file_name  = $file->getClientOriginalName();
			$file_type  = $file->extension();
			$filePath   = 'storage/'.$path.'/'. $name;

			return [
					'name' => $file_name,
					'type' => $file_type,
					'path' => $filePath,
					'size' => $this->fileSize($file)
			];

		}
	}

	public function fileSize($file, $precision = 2){   
			
			$size = $file->getSize();
			if ( $size > 0 ) {
					$size = (int) $size;
					$base = log($size) / log(1024);
					$suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
					return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
			}

			return $size;
	}
}