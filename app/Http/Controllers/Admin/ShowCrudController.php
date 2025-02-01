<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShowCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShowCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Show::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/show');
        CRUD::setEntityNameStrings('show', 'shows');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        // Add fields for the create form
    CRUD::addField([
        'name'  => 'movie_id',
        'label' => 'Movie',
        'type'  => 'select',
        'entity' => 'movie', // The method on the Show model that defines the relationship
        'attribute' => 'title', // The attribute on the Movie model to display
        'model' => \App\Models\Movie::class, // The related model
    ]);

    CRUD::addField([
        'name'  => 'screen_id',
        'label' => 'Screen',
        'type'  => 'select',
        'entity' => 'screen', // The method on the Show model that defines the relationship
        'attribute' => 'name', // The attribute on the Screen model to display
        'model' => \App\Models\Screen::class, // The related model
    ]);

    // CRUD::addField([
    //     'name'  => 'show_time',
    //     'label' => 'Show Time',
    //     'type'  => 'datetime_picker',
    //     'datetime_picker_options' => [
    //         'format' => 'YYYY-MM-DD HH:mm', // Customize the datetime format
    //         'language' => 'en',
    //     ],
    // ]);

    CRUD::addField([
        'name'  => 'price',
        'label' => 'Price',
        'type'  => 'number',
        'attributes' => [
            'step' => '0.01', // Allow decimal values
        ],
    ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
