<?php namespace App\Http\Services;

use App\Models\MenuItem;


class MenuService {

    protected $model, $response = [];

    public function __construct()
    {
        $this->model = new MenuItem();
    }

    public function getMenuItems() : array
    {
        $records = $this->model->with('children')->get();
        foreach($records as $key => $record){
            if($record->children && $record->parent_id == null){
                $this->response[ $key ] = [
                    "id" =>  $record->id,
                    "name" =>  $record->name,
                    "url" =>  $record->url,
                    "parent_id" =>  $record->parent_id ?? null,
                    "created_at" => $record->created_at->toDateTimeString(),
                    "updated_at" => $record->updated_at->toDateTimeString(),
                    "children" => $this->formulateChildrens($record->children)
                ];
            }
        }
        return array_values( $this->response );
    }

    public function formulateChildrens( $records ) : array 
    {
        $response = [];
        foreach($records as $key => $record){
            if($record->children){
                $response[$key] = $this->formulateData($record);
            }
        }
        return $response;
    }

    public function formulateData($record, $childExist = true) : array
    {
        return [
            "id" =>  $record->id,
            "name" =>  $record->name,
            "url" =>  $record->url,
            "parent_id" =>  $record->parent_id ?? null,
            "created_at" => $record->created_at->toDateTimeString(),
            "updated_at" => $record->updated_at->toDateTimeString(),
            "children" => $childExist ? $this->formulateChildrens($record->children) : []
        ];
    }
}
