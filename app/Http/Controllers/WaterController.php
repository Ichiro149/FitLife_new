<?php

/**
 * Šis kontrolieris apstrādā "Water Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers;

use App\Models\WaterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterController extends Controller
{

    /**
     * Šī metode sagatavo un attēlo galveno lapas vai saraksta skatu.
     */
    public function index()
    {
        $todayLogs = WaterLog::where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get();

        $historyLogs = WaterLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $todayTotal = $todayLogs->sum('amount');
        $dailyGoal = 2000;

        return view('water.index', compact('todayLogs', 'historyLogs', 'todayTotal', 'dailyGoal'));
    }

    /**
     * Šī metode validē ievadi un saglabā jaunu ierakstu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        WaterLog::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', '');
    }
}
