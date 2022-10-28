<?php namespace App\Http\Services;

use App\Models\Event;
use Carbon\Carbon;

class EventService {

    protected $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function getEventsWithWorkshops() 
    {
        return $this->model->with('workshops')->get();
    }
}
