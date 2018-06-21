<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init laravel ES for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //  create template
        $client = new Client();

        $url = config('scout.elasticsearch.hosts')[0] . '/_template/tmp';
        $client->delete($url);
        $params = [
            'json' => [
                'template' => config('scout.elasticsearch.index'),
                'mapping' => [
                    '_default_' => [
                        'dynamic_templates' => [
                            [
                                'string' => [
                                    'match_mapping_type' => 'string',
                                    'mapping' => [
                                        'type' => 'text',
                                        'analyzer' => 'ik_smart',
                                        'fields' => [
                                            'keyword' => [
                                                'type' => 'keyword',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $client->put($url, $params);

        $this->info("********创建模版成功********");

        //  create index
        $url = config('scout.elasticsearch.hosts')[0] . '/' . config('scout.elasticsearch.index');
        $client->delete($url);
        $params = [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mapping' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false,
                        ],
                    ],
                ],
            ],
        ];
        $client->put($url, $params);

        $this->info("********创建索引成功********");
    }
}
