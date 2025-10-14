<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Modules\ExportTasks\UseCase\ExportTaskUseCase;
use Illuminate\Console\Command;

class ExecuteExportTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:export-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute Export Tasks EX:Exporting Payment Transaction Report To Exel , Export Payment Invoices To Pdfs , Etx...';

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
     * @return int
     */
    public function handle()
    {
        dump('Start Executing Export Tasks');
        (new ExportTaskUseCase())->executingExportTask();
        dump('End Executing Export Tasks');
    }
}
