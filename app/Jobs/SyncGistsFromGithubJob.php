<?php

namespace App\Jobs;

use App\Models\Gist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SyncGistsFromGithubJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // GitHub API endpoint to list the authenticated user's gists
        $url = config('github.link.gists');
        $page = 1;
        do {
            // Make the request to GitHub
            $response = Http::get(
                $url,
                [
                    'page' => $page,
                    'headers' => [
                        'Authorization' => 'token '.config('github.token'),
                        'Accept' => 'application/vnd.github.v3+json',
                    ],
                ]
            );

            $gists = $response->json();

            foreach ($gists as $gist) {
                Gist::query()->updateOrCreate(
                    [
                        'link' => $gist['html_url'],
                    ],
                    [
                        'description' => $gist['description'],
                    ]
                );
            }

            $page++;
        } while ($gists);
    }
}
