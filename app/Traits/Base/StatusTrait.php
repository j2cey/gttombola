<?php

namespace App\Traits\Base;

use App\Models\Status;

trait StatusTrait
{
    public function setDefaultStatus() {
        if (empty($this->state_id)) {
            $default_status = Status::default();
            if ($default_status) {
                $this->status_id = $default_status->first()->id;
            }
        }
    }
}
