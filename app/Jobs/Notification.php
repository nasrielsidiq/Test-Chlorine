<?php

namespace App\Jobs;

use App\Mail\CategoryUpdate;
use App\Mail\SendNotification;
use App\Mail\UserUpdate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Notification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->data['type'] == 'category') {
            $mail = new CategoryUpdate($this->data);
        }else if ($this->data['type'] == 'user') {
            $mail = new UserUpdate($this->data);
        }
        Mail::to($this->data['email'])->send($mail);
    }
}
