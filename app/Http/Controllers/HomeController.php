<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class HomeController extends Controller
{
    public function index()
    {
        // Set the start and end date of the current week and last week
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::FRIDAY);
        $currentWeekEnd = Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek(Carbon::FRIDAY);
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);
        // Get the top sales of the current week and last week
        $topSales = DB::table('sales')
                    ->select('recipe_name', DB::raw('COUNT(*) as sales_count'),
                        DB::raw('SUM(quantity) as total_quantity'),
                        DB::raw('SUM(price) as total_sale'),
                        DB::raw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as current_week_sales'),
                        DB::raw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as last_week_sales'))
                    ->groupBy('recipe_name')
                    ->orderByDesc('total_sale')
                    ->setBindings([$currentWeekStart, $currentWeekEnd, $lastWeekStart, $lastWeekEnd])
                    ->get();

        // dd($currentWeekStart, $currentWeekEnd, $lastWeekStart, $lastWeekEnd);

        // Get Top 20 recent purchases
        $recentPurchases = Invoice::orderBy('created_at', 'desc')->take(20)->get();

        // all the sales
        $invoices = Invoice::with('sales')->get();
        //map the sales to add total discounted price and revenue
        $sales = $invoices->map(function ($invoice) {
            //calculate total discounted price
            $total_discounted_price = $invoice->total - ($invoice->total * ($invoice->discount / 100));
            //calculate total production cost
            $total_production_cost = 0;
            foreach ($invoice->sales as $sale) {
                //if sale is empty then skip
                if (empty($sale->production_cost)) {
                    continue;
                }
                $total_production_cost += $sale->quantity * $sale->production_cost;
            }
            //calculate revenue
            $revenue = $total_discounted_price - $total_production_cost;
            
    
            return collect(
                [
                    'total_discounted_price' => $total_discounted_price,
                    'total_production_cost' => $total_production_cost,
                    'revenue' => $revenue,
                    'created_at' => $invoice->created_at->format('Y-m-d'),
                ]
            );
        }); 

        // dd($sales->where('created_at', Carbon::now()->format('Y-m-d'))->sum('total_discounted_price'));
        return view('dashboard',[
            'recipes' => Recipe::all(),
            'top_sales' => $topSales,
            'recent_purchases' => $recentPurchases,
            'sales' => $sales
        ]);
    }
}
