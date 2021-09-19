<?php

namespace Moltox\ColumnMultiFilter\Commands;

use Illuminate\Console\Command;

class ColumnMultiFilterCommand extends Command
{
    public $signature = 'column-multi-filter';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
