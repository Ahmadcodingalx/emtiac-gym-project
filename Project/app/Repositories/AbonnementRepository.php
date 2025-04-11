<?php

namespace App\Repositories;

use App\Interfaces\AbonnementInterface;
use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Groupe;
use App\Models\Income;
use App\Models\Service;
use App\Models\Type;
use Carbon\Carbon;

class AbonnementRepository implements AbonnementInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show()
    {
        return Abonnement::with('type')->paginate(10);
    }

    public function viewAb($id)
    {
        return Abonnement::with('createdBy', 'updatedBy', 'type', 'service', 'client', 'groupes')->findOrFail($id);
    }

    public function addAb()
    {
        $clients = Client::all();
        $types = Type::all();
        $services = Service::all();

        $allData = [
            'clientData' => $clients,
            'typeData' => $types,
            'serviceData' => $services
        ];

        return $allData;
    }

    public function store($data, $id)
    {
        if ($id == 1) {
            $abType = $data['if_group'] ? "grp_" : "abb_";
            $type = Type::findOrFail($data['type_id']);

            if($data['price'] > $type->amount || (!$data['if_all_pay'] && ($type->type === "Semaine" || $type->type === "Jour"))) {
                return false;
            }

            $startDate = null;
            $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
            $numbers = rand(100000, 999999);
            $data['transaction_id'] = $abType . $letters . '-' . $numbers;

            $checkCode = Abonnement::where('transaction_id', $data['transaction_id'])->first();

            if ($checkCode) {
                while ($checkCode->transaction_id === $data['transaction_id']) {
                    $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
                    $numbers = rand(100000, 999999);
                    $data['transaction_id'] = $abType . $letters . '-' . $numbers;
                }
            }


            try {
                $startDate = Carbon::parse($data['start_date']);

                if ($startDate->isSameDay(Carbon::now())) {
                    $data['status'] = 'actif';
                }
            } catch (\Exception $e) {
                dd('Erreur de format de date : ', $e->getMessage());
            }


            if ($type->type === 'Jour') {
                $data['end_date'] = $startDate->addDays($type->number);
            } elseif ($type->type === 'Semaine') {
                $data['end_date'] = $startDate->addWeeks($type->number);
            } elseif ($type->type === 'Mois') {
                $data['end_date'] = $startDate->addMonths($type->number);
                if (!$data['if_all_pay']) {
                    $endDate = Carbon::parse($data['end_date']);
                    $data['end_pay_date'] = $endDate->subWeeks(1);
                    # code...
                }
                // $data['end_date'] = $startDate->addMonthsNoOverflow($type->number);
            } else {
                $data['end_date'] = $startDate->addYears($type->number);
                if (!$data['if_all_pay']) {
                    $endDate = Carbon::parse($data['end_date']);
                    $data['end_pay_date'] = $endDate->subWeeks(1);
                    # code...
                }
            }

            if(!$data['if_all_pay']) {
                $rest = $type->amount - $data['price'];
                $data['rest'] = $rest;
            }

            $abb = Abonnement::create($data);

            $transData = [
                'user_id' => auth()->id(),
                'abb_id' => $abb->id,
                'type' => 'abb',
                'date' => now(),
                'amount' => $abb->price ? $abb->price : $type->amount,
                'reason' => 'Transaction d\'un abonnement',
            ];
            $this->transaction_income($transData);

            return $abb;
        } else {
            Groupe::create($data);
        }
    }

    public function destroy($id)
    {
        return Abonnement::findOrFail($id);
    }

    public function update($request, $id)
    {
        $ab = Abonnement::findOrFail($id);

        $ab->user_update_id = auth()->id();
        $ab->client_id = $request->input('client');
        $ab->type_id = $request->input('type');
        $ab->service_id = $request->input('service');
        $ab->start_date = $request->input('start_date');
        $ab->price = $request->input('price');
        $ab->remark = $request->input('remark');

        $startDate = null;

        try {
            $startDate = Carbon::parse($request->input('start_date'));

            if ($startDate->isSameDay(Carbon::now())) {
                $ab->status = 'actif';
            }
        } catch (\Exception $e) {
            dd('Erreur de format de date : ', $e->getMessage());
        }

        $type = Type::findOrFail($request->input('type'));

        if ($type->type === 'Jour') {
            $day = $type->number - 1;
            $ab->end_date = $startDate->addDays($day);
        } elseif ($type->type === 'Semaine') {
            $ab->end_date = $startDate->addWeeks($type->number);
        } elseif ($type->type === 'Mois') {
            $ab->end_date = $startDate->addMonths($type->number);
            // $ab->end_date = $startDate->addMonthsNoOverflow($type->number);
        } else {
            $ab->end_date = $startDate->addYears($type->number);
        }

        // Corriger la transaction
        // if ($request->input('price')) {
        //     Income::where('abb_id', $ab->id)->delete();
        //     $transData = [
        //         'user_id' => auth()->id(),
        //         'abb_id' => $ab->id,
        //         'type' => 'abb_rest',
        //         'date' => now(),
        //         'amount' => $request->input('price'),
        //         'reason' => 'Rest d\'un abonnement',
        //     ];
        //     $this->transaction_income($transData);
        // }

        $ab->save();


        return $ab;
    }

    public function updateStatus($status, $id)
    {
        $abb = Abonnement::findOrFail($id);

        $abb->status = $status;

        $type = Type::findOrFail($abb->type_id);

        $startDate = Carbon::now();
        $abb->start_date = now();
        // dd($startDate);
        if ($type->type === 'Jour') {
            $day = $type->number - 1;
            $abb->end_date = $startDate->addDays($day);
        } elseif ($type->type === 'Semaine') {
            $abb->end_date = $startDate->addWeeks($type->number);
        } elseif ($type->type === 'Mois') {
            $abb->end_date = $startDate->addMonths($type->number);
            if (!$abb->if_all_pay) {
                $endDate = Carbon::parse($abb->end_date);
                $abb->end_pay_date = $endDate->subWeeks(1);
                # code...
            }
            // $ab->end_date = $startDate->addMonthsNoOverflow($type->number);
        } else {
            $abb->end_date = $startDate->addYears($type->number);
            if (!$abb->if_all_pay) {
                $endDate = Carbon::parse($abb->end_date);
                $abb->end_pay_date = $endDate->subWeeks(1);
                # code...
            }
        }

        $abb->updated_at = now();

        $abb->save();

        return $abb;
    }

    public function completeRest($data)
    {
        $abb = Abonnement::where('transaction_id', $data['abbId'])->first();
        $type = Type::findOrFail($abb->type_id);

        $total = $abb->price + $data['amount'];
        $rest = $abb->rest - $data['amount'];

        if ($total <= $type->amount) {
            $abb->price = $total;
            $abb->rest = $rest;

            $transData = [
                'user_id' => auth()->id(),
                'abb_id' => $abb->id,
                'type' => 'abb_rest',
                'date' => now(),
                'amount' => $data['amount'],
                'reason' => 'Rest d\'un abonnement',
            ];
            $this->transaction_income($transData);

            $abb->save();
            return $abb;
        } else {
            return false;
        }
    }

    public function search(string $query)
    {
        return Abonnement::with('type')
                // ->where('transaction_id', 'LIKE', "%{$query}%")
                // ->orWhere('status', 'LIKE', "%{$query}%")
                ->when($query, function ($q) use ($query) {
                    $q->where('transaction_id', 'LIKE', "%$query%")
                      ->orWhere('status', 'LIKE', "%$query%");
                })
                ->paginate(10);
    }

    public function transaction_income($data)
    {
        return Income::create($data);
    }











    public function show_service()
    {
        return Service::all();
    }

    public function create_service($data)
    {
        return Service::create($data);
    }

    public function update_service($request, $id)
    {
        $service = Service::findOrFail($request->input('id'));

        if ($request->input('name')) {
            $service->name = $request->input('name');
            $service->description = $request->input('desc');
        }

        $service->updated_at = now();

        $service->save();

        return $service;
    }


    public function destroy_service($id)
    {
        return Service::find($id);
    }

    public function show_type()
    {
        return Type::all();
    }

    public function create_type($data)
    {
        return Type::create($data);
    }

    public function update_type($request, $id)
    {
        $type = Type::findOrFail($request->input('id'));

        if ($request->input('name')) {
            $type->name = $request->input('name');
            $type->description = $request->input('desc');
            $type->number = $request->input('number');
            $type->type = $request->input('type');
            $type->description = $request->input('amount');
        }

        $type->updated_at = now();

        $type->save();

        return $type;
    }


    public function destroy_type($id)
    {
        return Type::find($id);
    }
}
