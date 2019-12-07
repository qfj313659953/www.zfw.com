<?php

namespace App\Jobs;

use App\Exports\FangOwnerExport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class FangOwnerExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $offset;
    protected $i;

    public function __construct($offset,$i)
    {
        //
        $this->offset = $offset;
        $this->i = $i;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::store(new FangOwnerExport($this->offset),'fangowner'.$this->i.'.xlsx','fangownerexcel');

    }
}
