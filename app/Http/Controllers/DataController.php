<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use App\Http\Requests\DataRequest;

class DataController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $datas = Data::orderBy('id', 'desc')->paginate(5);
        $today_datas = Data::whereDate('finance_date', $today)->get();
        $today_income = $today_datas->where('type', 'in')->sum('amount');
        $today_outcome = $today_datas->where('type', 'out')->sum('amount');

        $day_arr = [];
        $income_amount = [];
        $outcome_amount = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays($i);
            $date_arr[] = [
                'day' => $date->day,
                'month' => $date->month,
                'year' => $date->year,
            ];
            $day_arr[] = $date->format('D');

            $income_amount[] = Data::whereDate('finance_date', $date)->whereType('in')->sum('amount');
            $outcome_amount[] = Data::whereDate('finance_date', $date)->whereType('out')->sum('amount');
        }
        return view('index', compact('datas', 'today_datas', 'today_income', 'today_outcome', 'day_arr', 'income_amount', 'outcome_amount'));
    }

    function store(DataRequest $request)
    {
        Data::create($request->all());
        return back()->with(['success' => 'စာရင်းသွင်းခြင်းအောင်မြင်ပါသည်']);
    }

    function destroy(Data $data)
    {
        $data->delete();
        return back()->with(['success' => 'စာရင်းဖျက်ခြင်းအောင်မြင်ပါသည်']);
    }
}
