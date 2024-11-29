<?php

namespace App\Repositories;

use App\Models\BarangKategori;
use App\Repositories\BaseRepository;

/**
 * Class BarangKategoriRepository
 * @package App\Repositories
 * @version October 21, 2024, 8:26 am UTC
*/

class BarangKategoriRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_toko',
        'kode',
        'kategori'
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
        return BarangKategori::class;
    }
}
