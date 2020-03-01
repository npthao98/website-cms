<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\BannerRequest;

class BannerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(Banner::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/banner');
        $this->crud->setEntityNameStrings('banner', 'banners');
        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->addButtonFromView('top', 'clone', 'clone', 'end');
        $this->crud->operation('list', function () {

            $this->crud->addColumn('title');
            $this->crud->addColumn('link');
            $this->crud->addColumn('location');
            $this->crud->addColumn('startTime');
            $this->crud->addColumn('endTime');

            $this->crud->addButtonFromView('line', 'clone', 'clone', 'beginning');
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */

        $this->crud->operation(['create', 'update'], function () {

            $this->crud->setValidation(BannerRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Your title here',

            ]);
            $this->crud->addField([
                'name' => 'link',
                'label' => 'Link',
                'type' => 'url',
            ]);
            $this->crud->addField([  // Select
                'name' => 'location',
                'label' => "Location",
                'type' => 'select_from_array',
                'options'   =>
                    [
                        'Down' => 'Down',
                        'Up' => 'Up',
                        'Right' => 'Right',
                        'Left'  => 'Left'
                    ],
                'allows_null' => false,
                'default' => 'one',
            ]);
            $this->crud->addField([   // DateTime
                'name' => 'startTime',
                'label' => 'Start Time',
                'type' => 'datetime'
            ]);
            $this->crud->addField([   // DateTime
                'name' => 'endTime',
                'label' => 'End Time',
                'type' => 'datetime'
            ]);
        });

    }

    public function clone()
    {
    }
}



