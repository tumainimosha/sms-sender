<?php

namespace App\Commands;

use App\Services\SmsService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class ProcessOutgoing extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'process';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Process pending outgoing messages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $messages = collect();

        $this->task('Fetch pending messages from DB', function () use (&$messages) {
            $table = config('sms-sender.table_name');
            $sent_at_column = config('sms-sender.column.sent_at');
            $take = config('sms-sender.take');

            $messages = DB::table($table)
                ->whereNull($sent_at_column)
                ->limit($take)
                ->get();

            return true;
        });

        $this->task('Sending messages', function () use ($messages) {
            if (empty($messages)) {
                logger('No PENDING messages to send');

                return true;
            }

            $smsService = new SmsService();

            // push sms
            foreach ($messages as $message) {
                $msisdn_column = config('sms-sender.column.msisdn');
                $text_column = config('sms-sender.column.text');
                $sent_at_column = config('sms-sender.column.sent_at');
                $from_column = config('sms-sender.column.sender_name');
                $table = config('sms-sender.table_name');

                $msisdn = $message->$msisdn_column;
                $text = $message->$text_column;
                $from = $message->$from_column;
                $from = !empty($from) ? $from : config('services.infobip.from');

                logger("Sending To: {$msisdn}, From: {$from}, Content: {$text}");

                $smsService->send($msisdn, $text, $from);

                DB::table($table)
                    ->update([
                        "$sent_at_column" => now(),
                    ]);
            }

            return true;
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
