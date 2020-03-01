<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\GalleryRequest;

class GalleryCrudController extends CrudController
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
        $this->crud->setModel(Gallery::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/gallery');
        $this->crud->setEntityNameStrings('gallery', 'galleries');
        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->addButtonFromView('top', 'clone', 'clone', 'end');
        $this->crud->operation('list', function () {

            $this->crud->addColumn('title');
            $this->crud->addColumn('desc');
            $this->crud->addColumn([
                'name' => 'avatar',
                'label' => 'Avatar',
                'type' => 'image',
            ]);
//            $this->crud->addColumn([
//                'name' => 'images',
//                'label' => 'Images',
//                'type' => 'browse_multiple',
//            ]);
//            $this->crud->addColumn([
//                'label' => 'Category',
//                'type' => 'select',
//                'name' => 'category_id',
//                'entity' => 'category',
//                'attribute' => 'name',
//            ]);
//            $this->crud->addButtonFromView('line', 'clone', 'clone', 'beginning');
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */

        $this->crud->operation(['create', 'update'], function () {

            $this->crud->setValidation(GalleryRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Your title here',

            ]);
            $this->crud->addField([
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'hint' => 'Will be automatically generated from your title, if left empty.',
                'disabled' => 'disabled'
            ]);
            $this->crud->addField([
                'name' => 'avatar',
                'label' => 'Avatar',
                'type' => 'image',
            ]);
            $this->crud->addField([
               'name' => 'images',
               'label' => 'Images',
               'type' => 'browse_multiple',
            ]);
            $this->crud->addField([
                'name' => 'desc',
                'label' => 'Desc',
                'type' => 'ckeditor',
            ]);
            $this->crud->addField([
                'label' => 'Tags',
                'type' => 'select2_multiple',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            ]);

        });

    }

    public function clone()
    {
    }

//    public function store()
//    {
//        $this->crud->hasAccessOrFail('create');
//
//        // execute the FormRequest authorization and validation, if one is required
//        $request = $this->crud->validateRequest();
//
////        dd($this->crud->getStrippedSaveRequest());
//        // insert item in the db
//        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
//        dd($item);
//        $this->data['entry'] = $this->crud->entry = $item;
//
//        // show a success message
//        \Alert::success(trans('backpack::crud.insert_success'))->flash();
//
//        // save the redirect choice for next time
//        $this->crud->setSaveAction();
//
//        return $this->crud->performSaveAction($item->getKey());
//    }
//    public function update()
//    {
//        $this->crud->hasAccessOrFail('update');
//
//        // execute the FormRequest authorization and validation, if one is required
//        $request = $this->crud->validateRequest();
////        dd($this->crud->getStrippedSaveRequest());
//        // update the row in the db
//        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
//            $this->crud->getStrippedSaveRequest());
//        $this->data['entry'] = $this->crud->entry = $item;
//
//        // show a success message
//        \Alert::success(trans('backpack::crud.update_success'))->flash();
//
//        // save the redirect choice for next time
//        $this->crud->setSaveAction();
//
//        return $this->crud->performSaveAction($item->getKey());
//    }
}



