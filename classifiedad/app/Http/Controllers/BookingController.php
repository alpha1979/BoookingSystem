<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Booking::withTrashed()->get()->dd();
        //$bookings = DB::table('bookings')->get();
        $bookings = Booking::SimplePaginate(10);
        return view('bookings.index')
                ->with('bookings',$bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get()->pluck('name','id');
        $rooms = DB::table('rooms')->get()->pluck('number','id');
        return view('bookings.create')
                ->with('users',$users)
                ->with('booking',(new Booking()))
                ->with('rooms',$rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    dd($request->all());
    //using without eloquent
        // $id = DB::table('bookings')->insertGetId([
        //     'room_id'=>$request->input('room_id'),
        //     'start'=>$request->input('start'),
        //     'end'=>$request->input('end'),
        //     'is_reservation'=>$request->input('is_reservation',false),
        //     'is_paid'=>$request->input('is_paid',false),
        //     'notes'=>$request->input('notes'),
        // ]);
        $booking = Booking::create($request->input());
        // DB::table('bookings_users')->insert([
        //     'booking_id'=>$booking->id,
        //     'user_id'=>$request->input('user_id'),
        // ]);
        $booking->users()->attach($request->input('user_id'));
        return redirect()->action([BookingController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //dd($booking);
        return view('bookings.show',['booking'=>$booking]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //dd($booking);
       
       $users = DB::table('users')->get()->pluck('name','id');
       $rooms = DB::table('rooms')->get()->pluck('number','id');
       $bookingUser = DB::table('bookings_users')->where('booking_id',$booking->id)->first();
       return view('bookings.edit')
               ->with('users',$users)
               ->with('rooms',$rooms)
               ->with('bookingUser',$bookingUser)
               ->with('booking',$booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        
        // DB::table('bookings')
        // ->where('id',$booking->id)
        // ->update([
        //     'room_id'=>$request->input('room_id'),
        //     'start'=>$request->input('start'),
        //     'end'=>$request->input('end'),
        //     'is_reservation'=>$request->input('is_reservation',false),
        //     'is_paid'=>$request->input('is_paid',false),
        //     'notes'=>$request->input('notes'),
        // ]);
            $validateData =$request->validate([
               'start'=>'required|date', 
               'end'=>'required', 
               'room_id'=>'required|exists:rooms,id', 
               'user_id'=>'required|exists:users,id', 
               'is_paid'=>'nullable', 
               'notes'=>'present', 
               'is_reservation'=>'required', 
               
            ]);
            $booking->fill($validateData);
            $booking->save();
        DB::table('bookings_users')
        ->where('booking_id',$booking->id)
        ->update([
            
            //'user_id'=>$request->input('user_id'),
            'user_id'=>$validateData['user_id']
        ]);
        //$booking->users()->sync([$validateData['user_id']]);
        return redirect()->action([BookingController::class, 'index']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        
        //DB::table('bookings_users')->where('booking_id',$booking->id)->delete();
        // DB::table('bookings')->where('id',$booking->id)->delete();
        $booking->users()->detach();
        $booking->delete();
        return redirect()->action([BookingController::class, 'index']);
    }
}