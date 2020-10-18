<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TableController extends Controller
{
    public $data, $class;

    public function __invoke(Request $request, $model)
    {
        $models = collect(config('models'));

        if ($model = $models->where('name', $model)->first()) {
            $this->class = $model['class'];
            return $this->init();
        } else {
            return response()->json('failed');
        }
    }

    /**
     * init
     * 
     * Initialize table JSON
     *
     * @return void
     */
    protected function init()
    {
        $this->data = (new $this->class)::all();

        // de((new $this->class)->getField());

        return response()->json([
            'header'    => $this->headerMaker(),
            'data'      => $this->data,
        ]);
    }

    /**
     * headerMaker
     * 
     * Create header template
     *
     * @return void
     */
    protected function headerMaker()
    {
        $headers = Schema::getColumnListing((new $this->class)->getTable());

        $tableHeader = [];
        foreach ($headers as $key => $header) {
            $tableHeader[] = [
                'text'      => ucfirst($header),
                'value'     => $header,
                'component' => 'TextComponent'
            ];
        }

        return collect($tableHeader)->push([
            'text'  => 'Actions',
            'value' => 'actions'
        ]);
    }
}
