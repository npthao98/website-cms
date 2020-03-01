<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slide;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\SlideRequest;

class SlideCrudController extends CrudController
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
        $this->crud->setModel(Slide::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/slide');
        $this->crud->setEntityNameStrings('slide', 'slides');
        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->addButtonFromView('top', 'clone', 'clone', 'end');
        $this->crud->operation('list', function () {

            $this->crud->addColumn('title');
            $this->crud->addColumn('desc');
            $this->crud->addColumn('effect');
            $this->crud->addColumn('link');
//            $this->crud->addButtonFromView('line', 'clone', 'clone', 'beginning');
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */

        $this->crud->operation(['create', 'update'], function () {

            $this->crud->setValidation(SlideRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Your title here',

            ]);
            $this->crud->addField([
                'name' => 'desc',
                'label' => 'Desc',
                'type' => 'ckeditor',
            ]);

            $this->crud->addField([  // Select
                'name' => 'effect',
                'label' => "Effect",
                'type' => 'select_from_array',
                'options'   =>
                    [
                        'Down' => 'Down',
                        'Up' => 'Up',
                        'Toggle' => 'Toggle'
                    ],
                'allows_null' => false,
                'default' => 'one',
            ]);
            $this->crud->addField([
                'name' => 'link',
                'label' => 'Link',
                'type' => 'url',
            ]);
        });

    }

    public function clone()
    {
    }
}



