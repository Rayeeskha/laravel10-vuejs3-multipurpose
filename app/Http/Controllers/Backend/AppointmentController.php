<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Models\Client;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    public function index(){
        // dd(request()->all());
        return Appointment::query()->with('client:id,first_name,last_name')
            ->when(request('status'), function ($query) {
                return $query->where('status', AppointmentStatus::from(request('status')));
            })->when(request('query'), function ($query, $searchQuery) {
                $query->searchAppointment($searchQuery);
            })
    		->latest()->paginate()->through(fn ($appoinment) => [
                'id' => $appoinment->id,
                'start_time' => $appoinment->start_time->format('d M Y h:i A'),
                'end_time' => $appoinment->end_time->format('d M Y  h:i A'),
                'status' => [
                    'name' => $appoinment->status->name,
                    'color' => $appoinment->status->color(),
                ],
                'client' => $appoinment->client,
            ]);
    }

    //Get status with count
    public function getStatusWithCount()
    {
        $cases = AppointmentStatus::cases();

        return collect($cases)->map(function ($status) {
            return [
                'name' => $status->name,
                'value' => $status->value,
                'count' => Appointment::where('status', $status->value)->count(),
                'color' => AppointmentStatus::from($status->value)->color(),
            ];
        });
    }

    //Get clients
    public function getClients(){
        return Client::latest()->get();
    }

    public function store(AppointmentRequest $request){
        $input =  $request->validated(); 
        
        $input['status'] =  AppointmentStatus::SCHEDULED; 

        Appointment::create($input);

        return response()->json(['message' => 'success']);
    }

    public function edit(Appointment $appointment){
        return $appointment;
    }

    public function update(AppointmentRequest $request,Appointment $appointment){
        $validated =  $request->validated();

        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['success' => true], 200);
    }


}
