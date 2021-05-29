<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Notifications\Notification;
// use Facades\App\Libraries\Notifications;
use App\Libraries\Notifications;
use App\Notifications\Reservation;

class EmailReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify 
                                                {count : The number of booking to be retrieved}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify reservations holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Notifications $notify) //\App\Libraries\Notifications $notify 
    {
        $this->notify = $notify;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $count = $this->argument('count');
        if(!is_numeric($count)){
            $this->alert('The Count must be a number');
            return 1;
        }
        $bookings = \App\Models\Booking::with(['room.roomType','users'])->limit($count)->get();
        $this->info(sprintf('The Number of bookings to alert for is : %d',$bookings->count()));
        $bar = $this->output->createProgressBar($bookings->count());
        $bar->start();
        foreach ($bookings as $booking) {
            # code...
            //$this->error('Nothing happened');
           // $this->notify->send();
            // Notifications::send();
            $this->processBooking($booking);
            $bar->advance();
        }
        $bar->finish();
        $this->comment('Command completed');
        // return 0;
    }

    public function processBooking($booking){
        // if($this->option('dry-run')){
        //     $this->info('Would process booking');
        // }else{
            //$this->notify->send();
            //Notifications::send();
            $booking->notify(new Reservation('MArt Martin'));
        // }
    }
}