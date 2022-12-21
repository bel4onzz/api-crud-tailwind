<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUserPostedRateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_user:posted_rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Users Posted Rate';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = User::count();

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        User::withCount([
            'gigs',
            'gigs as posted_gigs' => function ($query) {
                $query->where('status', '1');
            }
        ])->chunkById(50, function ($users) use($bar) {
            try {
                DB::beginTransaction();

                foreach ($users as $user) {
                    $user->posted_rate = floatval(($user->posted_gigs/$user->gigs_count) * 100);
                    $user->save();
                    $bar->advance(1);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $bar->finish();
            }
        });
        $bar->finish();
        // return Command::SUCCESS;
    }
}
