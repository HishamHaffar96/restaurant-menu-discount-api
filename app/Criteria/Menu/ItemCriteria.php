<?php
/**
 * File name: ItemCriteria.php
 * Last modified: 2020.05.04 at 09:04:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Criteria\Menu;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ItemCriteria.
 *
 * @package namespace App\Criteria\Boxes;
 */
class ItemCriteria implements CriteriaInterface
{
    private $request ;

    /**
     * CategoryCriteria constructor.
     * @param  $request
     */
    public function __construct($request)
    {
        $this->request=$request;

    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $category_id=$this->request->input('category_id');

        return $model->where('category_id', $category_id);
    }
}
