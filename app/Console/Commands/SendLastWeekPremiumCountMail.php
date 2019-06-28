<?php

namespace App\Console\Commands;

use App\Mail\LastWeekPremiumCountMail;
use App\Model\ApiUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLastWeekPremiumCountMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:lastWeekPremiumCount {user : The ID of the user} {email : The email address to send}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send last week premium count email';

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
        $user = $this->argument('user');
        $user = explode(',', $user);

        foreach ($user as $userId) {
            if (!ApiUser::find($userId)) {
                $this->error('the id of user ' . $userId . ' is not exist');
                exit(1);
            }
        }

        $email = $this->argument('email');

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $this->error('the email ' . $email . ' is invalid');
            exit(1);
        }

        Mail::to($email)->send(new LastWeekPremiumCountMail(ApiUser::find($user)));
    }
}
