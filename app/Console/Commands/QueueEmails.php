<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QueueEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:queue-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscribers = \App\Models\Subscriber::select('id','email')->get();

        foreach($subscribers as $subscriber) {
            $posts = \App\Models\Post::whereNotIn('id', function ($query) use ($subscriber) {
                $query->select('post_id')->from('post_subscriber')->where('subscriber_id',$subscriber->id);
            })
            ->with('website')
            ->get();

            foreach($posts as $post) {
                $post->subscribers()->attach($subscriber->id);
                echo "send post #{$post->id} to {$subscriber->email}\n";
                \App\Jobs\SendEmail::dispatch($post, $subscriber->email, $post->website->title);
            }
        }
    }
}
