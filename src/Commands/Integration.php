<?php

namespace ConfrariaWeb\Integration\Commands;

use Illuminate\Console\Command;

class Integration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:execute {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa a integração fora do programatico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');
        if (isset($id)) {
            resolve('IntegrationService')->executeId($id);
        }else{
            resolve('IntegrationService')->executeAll();
        }
    }
}
