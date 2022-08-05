<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendStoredMail;

class StoreMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user,$product_name,$price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$product_name,$price)
    {
        $this->user =$user;
        $this->product_name=$product_name;
        $this->price=$price;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user= $this->user;
        $userMail=$user->email;
        $email = new SendStoredMail($user);
        Mail::to($userMail)->send($email);
    }
}
