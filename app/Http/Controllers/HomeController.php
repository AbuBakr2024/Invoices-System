<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


// $chartjs = app()->chartjs
// ->name('barChartTest')
// ->type('bar')
// ->size(['width' => 400, 'height' => 200])
// ->labels(['الفواتير الغير مدفوعه','الفواتير المدفوعه' ])
// ->datasets([
//     [
//         "label" => "الفواتير الغير مدفوعه",
//         'backgroundColor' => ['#F05A7E', '#88D66C'],
//         'data' => [69, 59]
//     ],
//     [
//         "label" => "الفواتير المدفوعه",
//         'backgroundColor' => ['#FF8225','#6EACDA'],
//         'data' => [65, 12]
//     ]
// ])
// ->options([]);

// return view('home', compact('chartjs'));

//     }

$count_all =invoices::count();
$count_invoices1 = invoices::where('value_status', 1)->count();
$count_invoices2 = invoices::where('value_status', 2)->count();
$count_invoices3 = invoices::where('value_status', 3)->count();

if($count_invoices2 == 0){
    $nspainvoices2=0;
}
else{
    $nspainvoices2 =round($count_invoices2/ $count_all*100);

}

  if($count_invoices1 == 0){
      $nspainvoices1=0;
  }
  else{
      $nspainvoices1 =round($count_invoices1/ $count_all*100);
  }

  if($count_invoices3 == 0){
      $nspainvoices3=0;
  }
  else{
      $nspainvoices3 = round($count_invoices3/ $count_all*100);
  }


 $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#F05A7E'],
                    'data' => [$nspainvoices2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#88D66C'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#FF8225'],
                    'data' => [$nspainvoices3]
                ],


            ])
            ->options([]);


  $chartjs_2 = app()->chartjs
      ->name('pieChartTest')
      ->type('pie')
      ->size(['width' => 340, 'height' => 200])
      ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
      ->datasets([
          [
              'backgroundColor' => ['#F05A7E', '#88D66C','#FF8225'],
              'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
          ]
      ])
      ->options([]);

  return view('home', compact('chartjs','chartjs_2'));

}


}
