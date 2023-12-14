<?php

namespace Enan\PathaoCourier\Commands;

use Illuminate\Console\Command;

class PathaoCourierCommand extends Command
{
    public $signature = 'pathao-courier';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
