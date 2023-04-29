<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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
        /*
        SELECT 
            subscribers.email, 
            posts.id as post_id, 
            subscribers.id as subscriber_id, 
            posts.title, 
            posts.description,
            websites.title as website_title
        FROM 
            subscribers 
            CROSS JOIN posts 
            LEFT JOIN post_subscriber ON post_subscriber.post_id = posts.id AND post_subscriber.subscriber_id = subscribers.id 
            JOIN subscriber_website ON subscriber_website.subscriber_id = subscribers.id AND posts.website_id = subscriber_website.website_id
            JOIN websites ON posts.website_id = websites.id
        WHERE 
            post_subscriber.id IS NULL
        ORDER BY
            posts.created_at
        LIMIT
            100;
        */

        $rows = [];
        do {
            $rows = DB::table('subscribers')
            ->crossJoin('posts')
            ->leftJoin('post_subscriber', function($join) {
                $join->on('post_subscriber.post_id', '=', 'posts.id')
                     ->on('post_subscriber.subscriber_id', '=', 'subscribers.id');
            })
            ->join('subscriber_website', function($join) {
                $join->on('subscriber_website.subscriber_id', '=', 'subscribers.id')
                     ->on('posts.website_id', '=', 'subscriber_website.website_id');
            })
            ->join('websites','posts.website_id','=','websites.id')
            ->whereNull('post_subscriber.id')
            ->select('subscribers.email', 'posts.id as post_id', 'subscribers.id as subscriber_id', 'posts.title as post_title', 'posts.description', 'websites.title as website_title')
            ->orderBy('posts.created_at')
            ->take(100)
            ->get();

            $post_subscriber = [];

            foreach ($rows as $row) {
                echo "send post #{$row->post_id} to {$row->email}\n";
                \App\Jobs\SendEmail::dispatch($row->email, $row->post_title, $row->description, $row->website_title);
                
                $post_subscriber[] = [
                    'subscriber_id' => $row->subscriber_id,
                    'post_id'       => $row->post_id,
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()
                ];
            }

            DB::table('post_subscriber')->insert($post_subscriber);
        } 
        while ($rows->isNotEmpty());
    }
}
