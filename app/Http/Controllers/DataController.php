<?php

namespace App\Http\Controllers;

use App\Models\data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // welcome
    function welcome(){
        $datas = data::orderBy('id','desc')->paginate(5);
        $today_datas = data::where('date',date('Y-m-d'))->get();

        $today_income = 0;
        $today_outcome =0;

        foreach ($today_datas as $today_data) {
            if ($today_data->type == 'in') {
                $today_income += $today_data->amount;
            } else {
                $today_outcome += $today_data->amount;
            }
        }

        $date_arr = [
            [
                'year' => date('Y'),
                'month' => date('m'),
                'day' => date('d')
            ]
        ];

        for ($i=0; $i < 7; $i++) {
            $day_arr [] = date('D',strtotime("-$i day"));

            $new_date = [
                'year' => date('Y',strtotime("-$i day")),
                'month' => date('m',strtotime("-$i day")),
                'day' => date('d',strtotime("-$i day"))
            ];

            $date_arr[] = $new_date;
        }

        $income_amount = [];
        $outcome_amount = [];

        foreach ($date_arr as $d) {
            $income_amount[] = data::whereYear('date',$d['year'])
                                ->whereMonth('date',$d['month'])
                                ->whereDay('date',$d['day'])
                                ->where('type','in')
                                ->sum('amount');

            $outcome_amount[] = data::whereYear('date',$d['year'])
                                ->whereMonth('date',$d['month'])
                                ->whereDay('date',$d['day'])
                                ->where('type','out')
                                ->sum('amount');
        }

        return view('welcome',compact('datas','today_income','today_outcome','day_arr','income_amount','outcome_amount'));
    }

    //addData
    function addData(Request $request){
        data::create([
            'about'=>$request->about,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'type'=>$request->type,
        ]);

        return back()->with(['success'=>'စာရင်းသွင်းခြင်းအောင်မြင်ပါသည် !']);
    }
}
