<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\MovieRequest;

/**
 * Class MovieCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MovieCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Movie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/movie');
        CRUD::setEntityNameStrings('movie', 'movies');
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
    CRUD::setValidation(MovieRequest::class);

    // Add fields for the form
    CRUD::addField([
        'name'  => 'title',
        'label' => 'Title',
        'type'  => 'text',
    ]);

    CRUD::addField([
        'name'  => 'description',
        'label' => 'Description',
        'type'  => 'textarea',
    ]);

    CRUD::addField([
        'name'  => 'release_date',
        'label' => 'Release Date',
        'type'  => 'date',
    ]);

    CRUD::addField([
        'name'        => 'genre_id', // Foreign key column
        'label'       => 'Genre',
        'type'        => 'select',
        'entity'      => 'genre', // Relationship method on the Movie model
        'attribute'   => 'name', // Attribute on the Genre model to display
        'model'       => \App\Models\Genre::class, // Related model
    ]);

    CRUD::addField([
        'name'  => 'rating',
        'label' => 'Rating',
        'type'  => 'number',
        'attributes' => [
            'step' => '0.1', // Allow decimal values
            'min'  => '0',
            'max'  => '10',
        ],
    ]);

    CRUD::addField([
        'name'  => 'poster_image',
        'label' => 'Poster Image',
        'type'  => 'url',
        // 'type'  => 'upload',
        // 'upload' => true, // Enable file upload
        // 'disk'  => 'public', // Storage disk
    ]);

    CRUD::addField([
        'name'  => 'image_banner',
        'label' => 'Banner Image',
        'type'  => 'url',
        // 'type'  => 'upload',
        // 'upload' => true, // Enable file upload
        // 'disk'  => 'public', // Storage disk
    ]);
    CRUD::addField([
        'name'  => 'trailer_url',
        'label' => 'Trailer URL',
        'type'  => 'url', // Use 'url' type for proper validation
    ]);

    // Add run_time field
    CRUD::addField([
        'name'  => 'run_time',
        'label' => 'Run Time (minutes)',
        'type'  => 'number',
        'attributes' => [
            'min'  => '0', // Ensure positive values
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
