<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(Request $request): View
    {
        $query = Asset::query();

        $query->when(
            $request->filled('search'),
            function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
                });
            }
        );

        $query->when(
            $request->filled('type'),
            function ($query) use ($request) {
                $query->where(
                    'type',
                    $request->string('type')->toString()
                );
            }
        );

        $assets = $query
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        $topGainer = Asset::orderByDesc('variation_24h')->first();

        $topLoser = Asset::orderBy('variation_24h')->first();

        $activeAlertsCount = $request->user()
            ->alerts()
            ->where('is_triggered', false)
            ->count();

        return view(
            'assets.index',
            compact(
                'assets',
                'topGainer',
                'topLoser',
                'activeAlertsCount'
            )
        );
    }

    public function sync(): RedirectResponse
    {
        $exitCode = Artisan::call('quotes:update');

        if ($exitCode === 0) {
            return back()->with(
                'success',
                'Cotações atualizadas com sucesso.'
            );
        }

        return back()->with(
            'error',
            'Falha na atualização das cotações.'
        );
    }

    public function show(Asset $asset): View
    {
        $histories = $asset
            ->priceHistories()
            ->latest('fetched_at')
            ->paginate(10);

        return view(
            'assets.show',
            compact(
                'asset',
                'histories'
            )
        );
    }
}
