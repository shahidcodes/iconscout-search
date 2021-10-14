<?php

namespace App\Observers;

use App\Models\Icon;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Log;

class IconObserver
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the Icon "created" event.
     *
     * @param  \App\Models\Icon  $icon
     * @return void
     */
    public function created(Icon $icon)
    {
        // Log::debug("created", ["client" => $this->client]);
        $indexResp = $this->client->index([
            "index" => "icons",
            "id" => $icon->id,
            "body" => $icon->toJson()
        ]);
        Log::debug('index response', ["response" => $indexResp]);
    }

    /**
     * Handle the Icon "updated" event.
     *
     * @param  \App\Models\Icon  $icon
     * @return void
     */
    public function updated(Icon $icon)
    {
        //
        Log::debug("updated");
    }

    /**
     * Handle the Icon "deleted" event.
     *
     * @param  \App\Models\Icon  $icon
     * @return void
     */
    public function deleted(Icon $icon)
    {
        //
        Log::debug("updated");
    }

    /**
     * Handle the Icon "restored" event.
     *
     * @param  \App\Models\Icon  $icon
     * @return void
     */
    public function restored(Icon $icon)
    {
        //
    }

    /**
     * Handle the Icon "force deleted" event.
     *
     * @param  \App\Models\Icon  $icon
     * @return void
     */
    public function forceDeleted(Icon $icon)
    {
        //
    }
}
