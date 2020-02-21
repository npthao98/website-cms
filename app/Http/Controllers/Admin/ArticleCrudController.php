<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\ArticleRequest;

class ArticleCrudController extends CrudController
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
        $this->crud->setModel(Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');
        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->addButtonFromView('top', 'clone', 'clone', 'end');
        $this->crud->operation('list', function () {

            $this->crud->addColumn('title');
            $this->crud->addColumn([
                'name' => 'date',
                'label' => 'Date',
                'type' => 'date',
            ]);
//            $this->crud->addColumn([
//                'name' => 'image',
//                'label' => 'Image',
//                'type' => 'browse',
//            ]);
            $this->crud->addColumn('status');
            $this->crud->addColumn([
                'name' => 'featured',
                'label' => 'Featured',
                'type' => 'check',
            ]);
            $this->crud->addColumn([
                'label' => 'Category',
                'type' => 'select',
                'name' => 'category_id',
                'entity' => 'category',
                'attribute' => 'name',
            ]);

//            $this->crud->addButtonFromView('line', 'clone', 'clone', 'beginning');
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */

        $this->crud->operation(['create', 'update'], function () {

            $this->crud->setValidation(ArticleRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Your title here',
//                'attributes' => [
//                    'required' => true,
//                ],
                'tab' => 'main',

            ]);
            $this->crud->addField([
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'hint' => 'Will be automatically generated from your title, if left empty.',
                'tab' => 'main',
                'disabled' => 'disabled'
            ]);
            $this->crud->addField([
                'name' => 'date',
                'label' => 'Date',
                'type' => 'date',
                'default' => date('Y-m-d'),
                'tab' => 'main',
            ]);

            $this->crud->addField([
                'label' => '',
                'name' => ['type', 'content', 'image', 'images', 'video'],
                'type' => 'content_type',
                'tab'  => 'main',
                'field' => [   // radio
                    'name'        => 'type', // the name of the db column
                    'label'       => 'Type', // the input label
                    'type'        => 'radio',
                    'options'     => [
                        'text' => "Text",
                        'photo' => "Photo",
                        'video' => "Video",
                        'gallery' => "Gallery",
                        'infographics' => "Infographics",
                    ],
                    'inline' => 'true',
                    'attributes' => [
                        'required' => true,
                    ],
                    'value' =>'text',
                ],
                'dependencies' => [
                    'video' => [
                        'view' => 'crud::fields.video',
                        'field' => [
                            'label' => 'video',
                            'name' => 'video',
                            'type' => 'video',
                        ],

                    ],
//                    'gallery' => [
//                        'view' => 'crud::fields.select2',
//                        'field' => [
//                            'label' => 'Gallery',
//                            'name' => 'gallery_id',
//                            'type' => 'select2',
//                            'entity' => 'category',
//                            'attribute' => 'name',
//                        ]
//                    ],
                    'infographics' => [
                        'view' => 'crud::fields.browse',
                        'field' => [
                            'label' => 'Infographics',
                            'name' => 'image',
                            'type' => 'browse'
                        ]

                    ],
                    'text' => [
                        'view' => 'crud::fields.ckeditor',
                        'field' => [
                            'label' => 'Text',
                            'name' => 'content',
                            'type' => 'ckeditor',
                        ],

                    ],
                    'photo' => [],

                ]
            ]);
//            $this->crud->addField([
//                'label' => 'Gallery',
//                'name' => 'gallery_id',
//                'type' => 'select2',
//                'entity' => 'category',
//                'attribute' => 'name',
//                'tab' => 'main',
//            ]);
            $this->crud->addField([
                'label' => 'Category',
                'type' => 'select2',
                'name' => 'category_id',
                'entity' => 'category',
                'attribute' => 'name',
                'tab' => 'main',
            ]);
            $this->crud->addField([
                'label' => 'Tags',
                'type' => 'select2_multiple',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'tab' => 'main',
            ]);
            $this->crud->addField([
                'name' => 'status',
                'label' => 'Status',
                'type' => 'enum',
                'tab' => 'main',
            ]);
            $this->crud->addField([
                'name' => 'featured',
                'label' => 'Featured item',
                'type' => 'checkbox',
                'tab' => 'main',
            ]);
            $this->crud->addField([   // CustomHTML
                'name' => 'metas_separator',
                'type' => 'custom_html',
                'tab' => 'meta',
                'value' => '<br><h2>' . trans('backpack::pagemanager.metas') . '</h2><hr>',
            ]);
            $this->crud->addField([
                'name' => 'meta_title',
                'label' => trans('backpack::pagemanager.meta_title'),
                'fake' => true,
                'store_in' => 'extras',
                'type' => 'text',
                'tab' => 'meta',
            ]);
            $this->crud->addField([
                'name' => 'meta_description',
                'label' => trans('backpack::pagemanager.meta_description'),
                'fake' => true,
                'store_in' => 'extras',
                'type' => 'text',
                'tab' => 'meta',
            ]);
            $this->crud->addField([
                'name' => 'meta_keywords',
                'type' => 'textarea',
                'label' => trans('backpack::pagemanager.meta_keywords'),
                'fake' => true,
                'store_in' => 'extras',
                'type' => 'text',
                'tab' => 'meta',
            ]);

        });

    }

    public function clone()
    {
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

//        dd($this->crud->getStrippedSaveRequest());
        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
//        dd($item);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
//        dd($this->crud->getStrippedSaveRequest());
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}



