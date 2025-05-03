<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\helpers\ImageManager;
use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    public function saveTempFile()
    {
        $temp_files = [];
        $files = request('image') ?? request('images') ?? request('files');

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {

            $temp = ImageManager::upload_temp($file);
            if ($temp['status'] == 0) {
                return response()->json([
                    'status' => 0,
                    'msg' => __('Something went wrong while uploading.')
                ]);
            }

            $temp_files[] = $temp['file'];
        }

        return response()->json([
            'status' => 1,
            'temp_files' => $temp_files,
        ]);
    }

    public function saveTempBanner(Request $request)
    {
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');

            // Validate file size (ensure it's under 300KB)
            if ($file->getSize() > 307200) { // 300KB in bytes
                return response()->json([
                    'status' => 0,
                    'msg' => __('The banner image exceeds the 300KB size limit.')
                ]);
            }

            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'), $imageName);

            return response()->json(['status' => 1, 'temp_files' => $imageName]);
        }

        return response()->json(['status' => 0, 'msg' => 'File upload failed']);
    }

    public function removeTempFile ()
    {
        dd(request('image_name'));
    }
}
