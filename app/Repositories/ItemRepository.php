<?php

namespace App\Repositories;

use App\Models\Item;


/**
 * Class ItemRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Item findWithoutFail($id, $columns = ['*'])
 * @method Item find($id, $columns = ['*'])
 * @method Item first($columns = ['*'])
*/
class ItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];




    /**
     * Configure the Model
     **/
    public function model()
    {
        return Item::class;
    }
}
