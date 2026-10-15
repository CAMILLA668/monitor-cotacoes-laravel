<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlertRequest;
use App\Models\Asset;
use App\Models\PriceAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(Request $request): View
    {
        $alerts = $request->user()
            ->alerts()
            ->with('asset')
            ->latest()
            ->get();

        return view('alerts.index', compact('alerts'));
    }

    public function create(): View
    {
        $assets = Asset::orderBy('name')->get();

        return view('alerts.create', compact('assets'));
    }

    public function store(AlertRequest $request): RedirectResponse
    {
        $request->user()
            ->alerts()
            ->create($request->validated());

        return redirect()
            ->route('alerts.index')
            ->with('success', 'Alerta criado com sucesso.');
    }

    public function edit(Request $request, PriceAlert $alert): View
    {
        $this->authorizeAlert($request, $alert);

        $assets = Asset::orderBy('name')->get();

        return view('alerts.edit', compact('alert', 'assets'));
    }

    public function update(AlertRequest $request, PriceAlert $alert): RedirectResponse
    {
        $this->authorizeAlert($request, $alert);

        $alert->update([
            ...$request->validated(),
            'is_triggered'  => false,
            'triggered_at'  => null,
        ]);

        return redirect()
            ->route('alerts.index')
            ->with('success', 'Alerta atualizado e reativado.');
    }

    public function destroy(Request $request, PriceAlert $alert): RedirectResponse
    {
        $this->authorizeAlert($request, $alert);

        $alert->delete();

        return back()->with('success', 'Alerta removido com sucesso.');
    }

    private function authorizeAlert(Request $request, PriceAlert $alert): Void
    {
        abort_unless(
            $alert->user_id === $request->user()->id,
            403
        );
    }
}
