<?php

namespace App\Console\Commands;

use App\Events\HistoryLogsEvent;
use App\Mail\sendTemplatedEmail;
use App\Models\Messages;
use App\Models\Templates;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendRenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Every 1 minute';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = date('Y-m-d H:i:s', strtotime(Carbon::now()->addHour()));
        logger($now);
        $messages = Messages::where('sending_date', '<=', $now)->get();
        foreach ($messages as $message) {
            if($message->status == 'pending')
            {
                $emailTemplate = Templates::find($message->template_id)->html;
                $name = Templates::find($message->template_id)->name;
                logger($emailTemplate);
                if($emailTemplate == null)
                {
                    $emailTemplate = 'This is a renewal reminder email';
                }else{
                    $emailTemplate = $emailTemplate;
                    Mail::to($message->receiver_email)->send(new sendTemplatedEmail($name, $emailTemplate));
                    $message->status = 'sent';
                    $message->save();

                    event(new HistoryLogsEvent($message->lead_id, $message->sender_id, 'Schedule Email', $name . ' ' . 'Email Sent'));
                }
            }
        }
        // Mail::to('maechael108@gmail.com')->send(new sendTemplatedEmail('Renewal Reminder', 'This is a renewal reminder email'));
        // $this->info('Email Sent');
    }
}