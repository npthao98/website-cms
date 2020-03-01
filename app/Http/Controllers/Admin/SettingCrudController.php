<?php


namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\SettingRequest;

class SettingCrudController extends CrudController
{
//    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

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
        $this->crud->setModel(Setting::class);
        CRUD::setEntityNameStrings(trans('backpack::settings.setting_singular'), trans('backpack::settings.setting_plural'));
        CRUD::setRoute(backpack_url('setting'));

        $this->crud->addButtonFromView('top', 'clone', 'clone', 'end');
    }

    public function setupListOperation()
    {
        // only show settings which are marked as active
        CRUD::addClause('where', 'active', 1);

        // columns to show in the table view
        CRUD::setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::settings.name'),
            ],
            [
                'name'  => 'value',
                'label' => trans('backpack::settings.value'),
            ],
            [
                'name'  => 'description',
                'label' => trans('backpack::settings.description'),
            ],
        ]);
    }
    public function setupCreateOperation()
    {
        $this->crud->setValidation(SettingRequest::class);
        CRUD::addField([
            'name'       => 'name',
            'label'      => trans('Name'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'key',
            'label'      => trans('Key'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'description',
            'label'      => trans('Description'),
            'type'       => 'ckeditor',
        ]);
        CRUD::addField([
            'name'       => 'value',
            'label'      => trans('Value'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'field',
            'label'      => trans('Field'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'active',
            'label'      => trans('Active'),
            'type' => 'select_from_array',
            'options' => ['1' => '1', '0' => '0'],
            'allows_null' => false,
            'default' => '1',
        ]);
    }

    public function setupUpdateOperation()
    {
        $this->crud->setValidation(SettingRequest::class);
        CRUD::addField([
            'name'       => 'name',
            'label'      => trans('Name'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'key',
            'label'      => trans('Key'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'description',
            'label'      => trans('Description'),
            'type'       => 'ckeditor',
        ]);
        CRUD::addField([
            'name'       => 'value',
            'label'      => trans('Value'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'field',
            'label'      => trans('Field'),
            'type'       => 'text',
        ]);
        CRUD::addField([
            'name'       => 'active',
            'label'      => trans('Active'),
            'type' => 'select_from_array',
            'options' => ['1' => '1', '0' => '0'],
            'allows_null' => false,
            'default' => '1',
        ]);

//        CRUD::addField(json_decode(CRUD::getCurrentEntry()->field, true));
    }
}
