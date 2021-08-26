<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Api\DespesasController;
use App\Mail\NovaDespesaEmail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class processaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $despesasController;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DespesasController $despesasController, $email)
    {
        $this->despesasController = $despesasController;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Mail::to($this->email)->send(new NovaDespesaEmail);
    }
    
}
