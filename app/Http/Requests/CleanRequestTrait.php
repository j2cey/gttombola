<?php


namespace App\Http\Requests;


trait CleanRequestTrait
{
    public function cleanUpdateRequest($request) {
        $formInput = $request->all();
        foreach ($formInput as $key => $value) {
            if ($value === "null") {
                $request->replace([$key => null]);
            } else {
                $request->replace([$key => str_replace('"', "", $value) ]);
            }
        }

        return $request;
    }
}
