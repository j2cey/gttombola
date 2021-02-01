<?php

namespace App\Mail;

use App\Models\WorkflowExec;
use App\Models\WorkflowStep;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkflowStepNext extends Mailable
{
    use Queueable, SerializesModels;

    public $step;
    public $step_url;

    /**
     * Create a new message instance.
     *
     * @param WorkflowExec $exec
     * @param WorkflowStep $next_step
     */
    public function __construct(WorkflowExec $exec, WorkflowStep $next_step)
    {
        $this->step = $next_step;
        $model_type = $exec->model_type;
        $model_obj = $model_type::where('id', $exec->model_id)->first();
        if ($model_obj) {
            $this->step_url = route('bordereauremises.edit', $model_obj->uuid);
        } else {
            $this->step_url = "";
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelle Action Bordereau Remise')
            ->markdown('emails.workflows.steps.next');
    }
}
