<?php

namespace App\Repositories;

use App\Models\BarangSatuan;
use App\Repositories\BaseRepository;

/**
 * Class BarangSatuanRepository
 * @package App\Repositories
 * @version October 22, 2024, 5:51 pm UTC
*/

class BarangSatuanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'satuan'
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
        return BarangSatuan::class;
    }
}
