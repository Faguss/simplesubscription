<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $post_title;
    protected $post_description;
    protected $website_title;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $post_title, $post_description, $website_title)
    {
        $this->email            = $email;
        $this->post_title       = $post_title;
        $this->post_description = $post_description;
        $this->website_title    = $website_title;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new \App\Mail\PostNotification($this->website_title,$this->post_title,$this->post_description));
    }
}
