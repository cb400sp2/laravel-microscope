<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Imanghafoori\LaravelMicroscope\Psr4Classes;
use Imanghafoori\LaravelMicroscope\Traits\LogsErrors;
use Imanghafoori\LaravelMicroscope\Checks\PSR12\CurlyBraces;
use Imanghafoori\LaravelMicroscope\Checks\ActionsComments;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;

class CheckPsr12 extends Command
{
    use LogsErrors;

    protected $signature = 'check:psr12';

    protected $description = 'applies psr-12 rules.';

    public function handle(ErrorPrinter $errorPrinter)
    {
        $errorPrinter->printer = $this->output;

        $this->info('Psr-12 is on the table...');
        $this->warn('This command is going to make changes to your files!');

        if (! $this->output->confirm('Do you have committed everything in git?', true)) {
            return ;
        }

        ActionsComments::$command = $this;

        Psr4Classes::check([CurlyBraces::class]);

        $this->finishCommand($errorPrinter);

        return $errorPrinter->hasErrors() ? 1 : 0;
    }
}
