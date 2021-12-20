<?php

namespace App\Nova;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use R64\NovaFields\Row;
use R64\NovaFields\Text as CustomText;
use Laravel\Nova\Http\Requests\NovaRequest;

class Client extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Client::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'full_name',
        "first_name",
        "last_name",
        "client_type",
        "phone",
        "mobile_phone",
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Select::make('Client Type')->options([
                'individual' => 'Individual',
                'commercial' => 'Commercial',
            ]),

            Text::make('Full Name')
                ->rules('required'),

            Text::make('First Name'),
            Text::make('Last Name'),
            Text::make('Phone'),
            Text::make('Mobile Phone'),

            Row::make('Data', [
                CustomText::make('First Name'),
                CustomText::make('Last Name'),
                CustomText::make('Email'),
                CustomText::make('Phone'),
                CustomText::make('Mobile Phone'),
            ])->prepopulateRowWhenEmpty()
                ->fieldClasses('py-6 px-8 w-full')
                ->panelFieldClasses('w-full py-4')
                ->itemWrapperClasses('flex border-40 border-1-0 border-r-0 table-field-item-warpper')
                ->childConfig([
                    "fieldClasses" => "w-full px-1 py-2",
                    "warpperClasses" => "w-full flex",
                    "hideLabelInForms" => true
                ])
                ->hideLabelInForms()
                ->hideLabelInDetail()
                ->alwaysShow()
                ->fillUsing(function ($request, $model) {
                    $model::saved(function ($model) use ($request) {
                        $dataRows = $request->data ?: [];
                        foreach ($dataRows as $data) {
                            $data = (object)$data;
                            if (!optional($data)->id) {
                                $datatable = new Contact();
                                $datatable->client_id = $model->id;
                            } else {
                                $datatable = Contact::find($data->id);
                                $datatable->updated_at = Carbon::now();
                            }
                            $datatable->first_name = $data->first_name;
                            $datatable->last_name = $data->last_name;
                            $datatable->email = $data->email;
                            $datatable->phone = $data->phone;
                            $datatable->mobile_phone = $data->mobile_phone;
                            $datatable->save();
                        }
                        // check if data is remove
                        $dataIds = $dataRows ? collect($dataRows)->pluck('id')->toArray() : [];
                        $requestDatas = $this->contacts;
                        if ($requestDatas) {
                            foreach ($requestDatas as $existingData) {
                                // check id if remove from form
                                if (! in_array($existingData->id, $dataIds)) {
                                    // set status to DEL
                                    $existingData->status = "DEL";
                                    $existingData->updated_at = Carbon::now();
                                    $existingData->save();
                                }
                            }
                        }
                    });
                })
                ->resolveUsing(function($data){
                    $rows = [];
                    $requestDatas = $this->contacts;
                    if ($requestDatas->isNotEmpty()) {
                        foreach ($requestDatas as $data) {
                            if ($data->status !== "DEL") {
                                $rows[] = array(
                                    "id" => $data->id,
                                    "first_name" => $data->first_name,
                                    "last_name" => $data->last_name,
                                    "email" => $data->email,
                                    "phone" => $data->phone,
                                    "mobile_phone" => $data->mobile_phone,
                                );
                            }
                        }
                    }
                    return json_encode($rows);
                })
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
