<?php 

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

trait FileService {
    public function storeAs($file) {
        return Storage::putFileAs(
            'company/images/logo',
            $file,
            $file->hashName()
        );   
    }
}