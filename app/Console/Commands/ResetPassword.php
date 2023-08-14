<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yas:reset-password {--mobile=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mobile = $this->option('mobile') !== "false" ? $this->option('mobile') : null;

        if($mobile)
        {
            $user = User::where("mobile",$mobile)->first();
            if($user)
                $user->update(["password"=>Hash::make($mobile)]);
        }
        return Command::SUCCESS;
    }
}
