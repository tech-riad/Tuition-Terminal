<?php

namespace App\Console\Commands;

use App\Mail\VerifyEmailOtp;
use App\Mail\ActiveDeactiveMail;
use App\Models\SmsBalance;
use Illuminate\Console\Command;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TutorDeactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutor:deactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate tutors if there is a 6-month gap since their last login';

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
     * @return void
     */
    public function handle()
{
    // Fetch tutors who are still active and whose last login was 6 months ago or more
    $tutors = Tutor::where('is_active', 1)
                   ->whereDate('login_at', '<=', Carbon::now()->subMonths(8))
                   ->get();

    foreach ($tutors as $tutor) {
        // Deactivate the tutor
        $tutor->is_active = 0;
        $tutor->is_sms = 0;
        $tutor->inactive_date = now();
        $tutor->update();

        $this->info("Tutor ID: {$tutor->id} has been deactivated.");
    }

    $this->info('Tutor deactivation process completed.');
}
}
