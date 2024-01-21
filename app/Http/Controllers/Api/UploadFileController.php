<?php

namespace App\Http\Controllers\Api;

use App\Dto\UploadFileDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $request->file('file');
        $file_uploaded_path = $file->store($request->folder_name, ['disk' => 'public_uploads']);
        $url = '';
        $url = Storage::disk('public_uploads')->url($file_uploaded_path);

        if ($url != '') {
            return response()->json([
                'success' => true,
                'message' => 'upload file success',
                'result' => ['url' => $url],
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'there_was_error_on_upload',
            'error_code' => 500,
        ], 500);
    }
}
