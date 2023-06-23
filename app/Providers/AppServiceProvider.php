<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Waste;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //manage waste
        $this->manageWaste();
    }

    /**
     * Manage waste
     */
    private function manageWaste(){
        //get all the plans where the date is not today or tomorrow
        $plans = Plan::with('recipe')->where('date', '!=', date('Y-m-d'))
            ->where('date', '!=', Carbon::now()->addDay()->format('Y-m-d'))
            ->get();

        //transfer to the waste
        foreach($plans as $plan){
            $waste = new Waste();
            $waste->recipe_id = $plan->recipe_id;
            $waste->recipe_name = $plan->recipe->recipe_name;
            $waste->amount = $plan->quantity;
            $waste->production_cost = $plan->recipe->production_cost;
            $waste->save();

            //delete the plan
            $plan->delete();
        }
    }
}
