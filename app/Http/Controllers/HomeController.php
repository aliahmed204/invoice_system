<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Charts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loginPage(){
        return view('auth.login');
    }
    public function index()
    {
        $count = Invoices::count();
        $total = Invoices::sum('total');

        $total_paid = $this->total('1');
        $paid_count = $this->count('1');

        $total_unpaid = $this->total('2');
        $unpaid_count = $this->count('2');

        $total_partially = $this->total('3');
        $partially_count = $this->count('3');

        $paid_ratio = ($total_paid != 0) ? (( $total_paid / $total) * 100)  : 0;
        $unpaid_ratio = ($total_unpaid != 0) ? (($total_unpaid / $total) * 100) : 0;
        $partially_ratio = ($total_partially != 0) ? (($total_partially/ $total)*100) : 0;

        $chartjs = $this->chart_1($paid_ratio ,$unpaid_ratio ,$partially_ratio);
        $chartjs_2 = $this->chart_2($paid_ratio ,$unpaid_ratio ,$partially_ratio);

        return view('home', get_defined_vars());

        /*compact('count', 'total', 'total_paid', 'paid_count',
            'total_unpaid', 'unpaid_count', 'total_partially', 'partially_count', 'paid_ratio', 'unpaid_ratio',
            'partially_ratio', 'chartjs', 'chartjs_2')*/
    }
    private function total($status_value){
        return Invoices::where('value_status',$status_value)->sum('total');
    }
    private function count($status_value){
        return Invoices::where('value_status',$status_value)->count();
    }
    private function chart_1($paid_ratio ,$unpaid_ratio ,$partially_ratio){
        return app()->chartjs
            ->name('barChart')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['Paid invoices','Unpaid invoices','Partially paid'])
            ->datasets([
                [
                    "label" => "Paid invoices",
                    'backgroundColor' => ['rgba(54,162,235,0.6)','rgba(54,162,235,0.4)'],
                    'data' => [$paid_ratio]
                ],
                [
                    "label" => "Unpaid invoices",
                    'backgroundColor' => ['rgba(255,99,132,0.6)','rgba(255,99,132,0.4)'],
                    'data' => [$unpaid_ratio]
                ],

                [
                    "label" => "Partially paid invoices",
                    'backgroundColor' => ['rgba(255,165,0,0.6)','rgba(54,162,235,0.4)'],
                    'data' => [$partially_ratio]
                ],

            ])->options([]);
    }
    private function chart_2($paid_ratio ,$unpaid_ratio ,$partially_ratio){
        return app()->chartjs
            ->name('pieChart')
            ->type('pie')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['Paid invoices','Unpaid invoices','Partially paid invoices'])
            ->datasets([
                [
                    'backgroundColor' => ['rgba(54,162,235,0.6)' ,'rgba(255,99,132,0.6)','rgba(255,165,0,0.6)' ],
                    'data' => [$paid_ratio,$unpaid_ratio,$partially_ratio]
                ],


            ])->options([]);
    }
}
