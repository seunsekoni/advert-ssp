<?php

namespace App\Http\Controllers;

use App\Enums\MediaCollection;
use App\Http\Requests\AdvertCampaign\StoreAdvertCampaignRequest;
use App\Http\Requests\AdvertCampaign\UpdateAdvertCampaignRequest;
use App\Models\AdvertCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AdvertCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $advertCampaigns = AdvertCampaign::all();

        return ResponseBuilder::asSuccess()
            ->withMessage('Campaigns fetched successfully')
            ->withData(['advert_campaigns' => $advertCampaigns])
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdvertCampaignRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreAdvertCampaignRequest $request)
    {
        DB::beginTransaction();

        $advertCampaign = new AdvertCampaign();
        $advertCampaign->name = $request->name;
        $advertCampaign->start_date = $request->start_date;
        $advertCampaign->end_date = $request->end_date;
        $advertCampaign->total_budget = $request->total_budget;
        $advertCampaign->daily_budget = $request->daily_budget;
        $advertCampaign->save();

        if ($request->banner) {
            $advertCampaign->addMultipleMediaFromRequest(['banner'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection(MediaCollection::BANNER);
                });
        }

        DB::commit();

        return ResponseBuilder::asSuccess()
            ->withMessage('Campaign saved successfully')
            ->withData(['advert_campaign' => $advertCampaign])
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvertCampaign  $advertCampaign
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(AdvertCampaign $advertCampaign)
    {
        return ResponseBuilder::asSuccess()
            ->withMessage('Campaign fetched successfully')
            ->withData(['advert_campaign' => $advertCampaign])
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvertCampaign  $advertCampaign
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAdvertCampaignRequest $request, AdvertCampaign $advertCampaign)
    {
        DB::beginTransaction();

        $advertCampaign->name = $request->name;
        $advertCampaign->start_date = $request->start_date;
        $advertCampaign->end_date = $request->end_date;
        $advertCampaign->total_budget = $request->total_budget;
        $advertCampaign->daily_budget = $request->daily_budget;
        $advertCampaign->update();

        if ($request->banner) {
            $advertCampaign->addMultipleMediaFromRequest(['banner'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection(MediaCollection::BANNER);
                });
        }

        DB::commit();

        return ResponseBuilder::asSuccess()
            ->withMessage('Campaign updated successfully')
            ->withData(['advert_campaign' => $advertCampaign])
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvertCampaign  $advertCampaign
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(AdvertCampaign $advertCampaign)
    {
        $advertCampaign->delete();

        return ResponseBuilder::asSuccess()
            ->withMessage('Campaign deleted successfully')
            ->build();
    }
}
