<?php

namespace App\Http\Controllers;

use App\Models\Waifu;
use App\Http\Resources\WaifuResource;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\WaifuCollection;
use App\Http\Requests\StoreWaifuRequest;
use App\Http\Requests\UpdateWaifuRequest;
use Spatie\QueryBuilder\QueryBuilder;

class WaifuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $waifus = QueryBuilder::for(Waifu::class)
            ->defaultSort('id')->allowedSorts(['name'])->paginate();
        return new WaifuCollection($waifus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWaifuRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->waifu()->create($validated);

        return redirect(route('waifus.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Waifu $waifu)
    {
        return new WaifuResource($waifu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWaifuRequest $request, Waifu $waifu): RedirectResponse
    {
        $validated = $request->validated();

        $waifu->update($validated);

        return redirect(route('waifus.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waifu $waifu): RedirectResponse
    {
        $waifu->delete();

        return redirect(route('waifus.index'));
    }

}
