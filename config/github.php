<?php

return [
    'link' => [
        'gists' => env('GITHUB_API_URL_FOR_CUSTOM_PROFILE_GISTS', 'https://api.github.com/users/ahmedhelalahmed/gists'),
    ],
    'token' => env('GITHUB_TOKEN'),
];
