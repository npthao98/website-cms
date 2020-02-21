<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait CreateArticleOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCreateArticleRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/createarticle', [
            'as'        => $routeName.'.createarticle',
            'uses'      => $controller.'@createarticle',
            'operation' => 'createarticle',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCreateArticleDefaults()
    {
        $this->crud->allowAccess('createarticle');

        $this->crud->operation('createarticle', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            // $this->crud->addButton('top', 'createarticle', 'view', 'crud::buttons.createarticle');
            // $this->crud->addButton('line', 'createarticle', 'view', 'crud::buttons.createarticle');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function createarticle()
    {
        $this->crud->hasAccessOrFail('createarticle');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'createarticle '.$this->crud->entity_name;

        // load the view
        return view("crud::operations.createarticle", $this->data);
    }
}
