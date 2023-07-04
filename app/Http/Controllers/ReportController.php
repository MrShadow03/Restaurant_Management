<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReport(Request $request){
        $sales = Sale::with(['recipe', 'invoice'])->get();

        //Determining the report type
        $report_type = isset($request->report_type) ? $request->report_type : 'yearly';
        $date = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        if($request->report_type == 'daily'){
            $report_type = 'daily';
            $sales = Sale::with(['recipe', 'invoice'])->where('created_at', '>=', date('Y-m-d'))->get();
        }
        
        if($request->report_type == 'monthly'){
            $report_type = 'monthly';
            $sales = Sale::with(['recipe', 'invoice'])->whereMonth('created_at', date('m'))->get();
        }
        
        if($request->report_type == 'yearly'){
            $report_type = 'yearly';
            $sales = Sale::with(['recipe', 'invoice'])->whereYear('created_at', date('Y'))->get();
        }

        // Check for specific date, month or year
        if($request->date){
            $sales = Sale::with(['recipe', 'invoice'])->whereDate('created_at', $request->date)->get();
            $date = $request->date;
        }elseif($request->month){
            $sales = Sale::with(['recipe', 'invoice'])->whereMonth('created_at', $request->month)->get();
            $month = $request->month;
        }elseif($request->year){
            $sales = Sale::with(['recipe', 'invoice'])->whereYear('created_at', $request->year)->get();
            $year = $request->year;
        }

        return view('dashboard.pages.manager.sales_report',[
            'sales' => $sales,
            'report_type' => $report_type,
            'date' => $date,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function productsReport(Request $request){
        $products = Recipe::all();

        //Determining the report type
        $report_type = isset($request->report_type) ? $request->report_type : 'yearly';
        $date = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        if($report_type == 'daily'){
            $report_type = 'daily';
            $products = $products->map(function($product){
                $product->total_sale = $product->sales()->where('created_at', '>=', date('Y-m-d'))->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->where('created_at', '>=', date('Y-m-d'))->sum('production_cost');
                $product->sale_count = $product->sales()->where('created_at', '>=', date('Y-m-d'))->sum('quantity');
                $product->waste_count = $product->wastes()->where('created_at', '>=', date('Y-m-d'))->sum('amount');
                return $product;
            });
        }
        
        if($report_type == 'monthly'){
            $report_type = 'monthly';
            $products = $products->map(function($product){
                $product->total_sale = $product->sales()->whereMonth('created_at', date('m'))->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->whereMonth('created_at', date('m'))->sum('production_cost');
                $product->sale_count = $product->sales()->whereMonth('created_at', date('m'))->sum('quantity');
                $product->waste_count = $product->wastes()->whereMonth('created_at', date('m'))->sum('amount');
                return $product;
            });
        }
        
        if($report_type == 'yearly'){
            $report_type = 'yearly';
            $products = $products->map(function($product){
                $product->total_sale = $product->sales()->whereYear('created_at', date('Y'))->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->whereYear('created_at', date('Y'))->sum('production_cost');
                $product->sale_count = $product->sales()->whereYear('created_at', date('Y'))->sum('quantity');
                $product->waste_count = $product->wastes()->whereYear('created_at', date('Y'))->sum('amount');
                return $product;
            });
        }

        // Check for specific date, month or year
        if($request->date){
            $date = $request->date;
            $products = $products->map(function($product) use ($date){
                $product->total_sale = $product->sales()->whereDate('created_at', $date)->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->whereDate('created_at', $date)->sum('production_cost');
                $product->sale_count = $product->sales()->whereDate('created_at', $date)->sum('quantity');
                $product->waste_count = $product->wastes()->whereDate('created_at', $date)->sum('amount');
                return $product;
            });
        }elseif($request->month){
            $month = $request->month;
            $products = $products->map(function($product) use ($month){
                $product->total_sale = $product->sales()->whereMonth('created_at', $month)->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->whereMonth('created_at', $month)->sum('production_cost');
                $product->sale_count = $product->sales()->whereMonth('created_at', $month)->sum('quantity');
                $product->waste_count = $product->wastes()->whereMonth('created_at', $month)->sum('amount');
                return $product;
            });
        }elseif($request->year){
            $year = $request->year;
            $products = $products->map(function($product) use ($year){
                $product->total_sale = $product->sales()->whereYear('created_at', $year)->get();
                $total_sale = 0;
                foreach($product->total_sale as $sale){
                    $total_sale += $sale->quantity * $sale->price;
                }
                $product->total_sale = $total_sale;
                $product->total_waste = $product->wastes()->whereYear('created_at', $year)->sum('production_cost');
                $product->sale_count = $product->sales()->whereYear('created_at', $year)->sum('quantity');
                $product->waste_count = $product->wastes()->whereYear('created_at', $year)->sum('amount');
                return $product;
            });
        }

        //sort products by total sale
        $products = $products->sortByDesc('total_sale');

        return view('dashboard.pages.manager.products_report',[
            'products' => $products,
            'report_type' => $report_type,
            'date' => $date,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
