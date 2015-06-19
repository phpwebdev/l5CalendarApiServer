<?php

namespace App\Http\Controllers;
use App\Event;
use App\Http\Controllers\Controller;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

// use App\Event;
// use App\Task;

class SearchController extends Controller {

    public $filter = [];
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $this->__prepareFilter($request);

        $tasksTmp  = new Task();
        $eventsTmp = new Event();

        switch ($this->filter['type']) {
            case 'task':
                $tasksQuery = $tasksTmp->search($this->filter);
                break;
            case 'event':
                $eventsQuery = $eventsTmp->search($this->filter);
                break;
            default:
                $eventsQuery = $eventsTmp->search($this->filter);
                $tasksQuery  = $tasksTmp->search($this->filter);
                break;
        }

        //\Debugbar::enable();

        if (isset($tasksQuery)) {
            //var_dump($tasksQuery);
        }

        if (isset($eventsQuery)) {
            //  var_dump($eventsQuery);
        }

        /*var_dump($eventsQuery->repeatable);
        var_dump($eventsQuery->day);*/
        // var_dump($eventsQuery['repeatable']);
        // var_dump($eventsQuery['day']);

        $result = [];
        $ri     = 0;
        if (isset($eventsQuery['repeatable'])) {
            foreach ($eventsQuery['repeatable'] as $event) {
                $result['repeatable'][$ri]["title"]            = $event->title;
                $result['repeatable'][$ri]["description"]      = $event->description;
                $result['repeatable'][$ri]["id"]               = $event->id;
                $result['repeatable'][$ri]["parent"]           = $event->parent_id;
                $result['repeatable'][$ri]["type"]             = 'event';
                $result['repeatable'][$ri]["end_at"]           = $event->end_at;
                $result['repeatable'][$ri]["start_at"]         = $event->start_at;
                $result['repeatable'][$ri]["color"]['name']    = $event->_color['name'];
                $result['repeatable'][$ri]["color"]['hexCode'] = $event->_color['hexCode'];
                $ri++;
            }
        }

        if (isset($tasksQuery['repeatable'])) {
            foreach ($tasksQuery['repeatable'] as $task) {
                $result['repeatable'][$ri]["title"]            = $task->title;
                $result['repeatable'][$ri]["description"]      = $task->description;
                $result['repeatable'][$ri]["id"]               = $task->id;
                $result['repeatable'][$ri]["parent"]           = $task->parent_id;
                $result['repeatable'][$ri]["type"]             = 'task';
                $result['repeatable'][$ri]["end_at"]           = $task->end_at;
                $result['repeatable'][$ri]["start_at"]         = $task->start_at;
                $result['repeatable'][$ri]["color"]['name']    = $task->_color['name'];
                $result['repeatable'][$ri]["color"]['hexCode'] = $task->_color['hexCode'];
                $ri++;
            }
        }

        $di = 0;
        if (isset($eventsQuery['day'])) {
            foreach ($eventsQuery['day'] as $event) {
                $carbon_end   = new Carbon($event->end_at);
                $carbon_start = new Carbon($event->start_at);

                $result['day'][$di]["title"]            = $event->title;
                $result['day'][$di]["description"]      = $event->description;
                $result['day'][$di]["id"]               = $event->id;
                $result['day'][$di]["type"]             = 'event';
                $result['day'][$di]["end_at"]           = $carbon_end->toW3cString();
                $result['day'][$di]["start_at"]         = $carbon_start->toW3cString();
                $result['day'][$di]["color"]['name']    = $event->_color['name'];
                $result['day'][$di]["color"]['hexCode'] = $event->_color['hexCode'];
                $di++;
            }
        }
        if (isset($tasksQuery['day'])) {
            foreach ($tasksQuery['day'] as $task) {

                $carbon_end   = new Carbon($task->end_at);
                $carbon_start = new Carbon($task->start_at);

                $result['day'][$di]["title"]            = $task->title;
                $result['day'][$di]["description"]      = $task->description;
                $result['day'][$di]["id"]               = $task->id;
                $result['day'][$di]["type"]             = 'task';
                $result['day'][$di]["end_at"]           = $carbon_end->toW3cString();
                $result['day'][$di]["start_at"]         = $carbon_start->toW3cString();
                $result['day'][$di]["color"]['name']    = $task->_color['name'];
                $result['day'][$di]["color"]['hexCode'] = $task->_color['hexCode'];
                $di++;
            }
        }

        return response()->json(['data' => $result], 200);

    }

    protected function __prepareFilter($request) {

        if ($request->input('search') !== null) {
            $this->filter['search'] = strtolower($request->input('search'));
        }
        if ($request->input('type') == null) {
            $this->filter['type'] = 'all';
        } else {
            $this->filter['type'] = strtolower($request->input('type'));
        }
        if ($request->input('category') !== null) {
            $this->filter['category'] = $request->input('category');
        }
        if ($request->input('start_at') == null) {
            $carbon                            = new Carbon();
            $this->filter['dates']['start_at'] = $carbon->startOfDay()->toDateTimeString();
        } else {
            $carbon                            = new Carbon($request->input('start_at'));
            $this->filter['dates']['start_at'] = $carbon->startOfDay()->toDateTimeString();
        }
        if ($request->input('end_at') == null) {
            $carbon                          = new Carbon();
            $this->filter['dates']['end_at'] = $carbon->endOfDay()->toDateTimeString();
        } else {
            $carbon                          = new Carbon($request->input('end_at'));
            $this->filter['dates']['end_at'] = $carbon->endOfDay()->toDateTimeString();
        }
    }

}
