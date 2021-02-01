<?php

namespace App\Traits\PhoneNum;

use App\Models\Status;
use App\Models\PhoneNum;

trait HasPhoneNums
{
    public function addNewPhoneNum($num)
    {
        // TODO: Valider le numéro de Phone
        if (empty($num)) {
            return false;
        }

        $elem_type = get_called_class();

        $phonenum = PhoneNum::create([
            'numero' => $num,
            'status_id' => Status::active()->first()->id,
        ]);

        $phonenum_count = $this->phonenums()->count();

        $this->phonenums()->attach($phonenum->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $phonenum_count,
        ]);
        return true;
    }

    /**
     * Renvoie les numéros de phone (phonenums) de ce model.
     */
    public function phonenums()
    {
        $elem_type = get_called_class();
        return $this->belongsToMany(PhoneNum::class, 'model_has_phone_nums', 'model_id', 'phone_num_id')
            //return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
            ->wherePivot('model_type', $elem_type)
            ->withPivot('posi')
            ->withTimestamps()
            ->orderBy('posi', 'asc');
    }
}
