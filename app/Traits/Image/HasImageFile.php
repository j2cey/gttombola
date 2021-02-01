<?php

namespace App\Traits\Image;

use Illuminate\Http\Request;

trait HasImageFile
{
    public function verifyAndStoreImage( Request $request, $fieldname = 'image', $directory = 'unknown', $oldimage = ' ' ) {

        if( $request->hasFile( $fieldname ) ) {

            if (!$request->file($fieldname)->isValid()) {

                //flash('Invalid Image!')->error()->important();

                return null;//redirect()->back()->withInput();
            }

            $file_dir = config('app.' . $directory);// . '_filefolder');

            // Check if the old image exists inside folder
            if (file_exists( $file_dir . '/' . $oldimage)) {
                unlink($file_dir . '/' . $oldimage);
            }

            // Set image name
            $image = $request->file($fieldname);//$request->image;
            $image_name = md5($directory . '_' . time()) . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($file_dir, $image_name);

            return $image_name;
        }

        return null;

    }
}
