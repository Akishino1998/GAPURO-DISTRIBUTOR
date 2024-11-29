<?php

namespace App\Repositories;

use App\Models\BarangMerk;
use App\Repositories\BaseRepository;

/**
 * Class BarangMerkRepository
 * @package App\Repositories
 * @version October 21, 2024, 8:20 am UTC
*/

class BarangMerkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'merk'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BarangMerk::class;
    }
}
