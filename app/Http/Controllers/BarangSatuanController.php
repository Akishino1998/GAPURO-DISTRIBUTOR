<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarangSatuanRequest;
use App\Http\Requests\UpdateBarangSatuanRequest;
use App\Repositories\BarangSatuanRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BarangSatuanController extends AppBaseController
{
    /** @var BarangSatuanRepository $barangSatuanRepository*/
    private $barangSatuanRepository;

    public function __construct(BarangSatuanRepository $barangSatuanRepo)
    {
        $this->barangSatuanRepository = $barangSatuanRepo;
    }

    /**
     * Display a listing of the BarangSatuan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $satuan = $this->barangSatuanRepository->all();

        return view('admin.satuan.index')
            ->with('satuan', $satuan);
    }

    /**
     * Show the form for creating a new BarangSatuan.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.satuan.create');
    }

    /**
     * Store a newly created BarangSatuan in storage.
     *
     * @param CreateBarangSatuanRequest $request
     *
     * @return Response
     */
    public function store(CreateBarangSatuanRequest $request)
    {
        $input = $request->all();

        $barangSatuan = $this->barangSatuanRepository->create($input);

        Flash::success('Barang Satuan saved successfully.');

        return redirect(route('admin.master.satuan.index'));
    }

    /**
     * Display the specified BarangSatuan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $satuan = $this->barangSatuanRepository->find($id);

        if (empty($satuan)) {
            Flash::error('Barang Satuan not found');

            return redirect(route('admin.master.satuan.index'));
        }

        return view('admin.satuan.show')->with('satuan', $satuan);
    }

    /**
     * Show the form for editing the specified BarangSatuan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $satuan = $this->barangSatuanRepository->find($id);

        if (empty($satuan)) {
            Flash::error('Barang Satuan not found');

            return redirect(route('admin.master.satuan.index'));
        }

        return view('admin.satuan.edit')->with('satuan', $satuan);
    }

    /**
     * Update the specified BarangSatuan in storage.
     *
     * @param int $id
     * @param UpdateBarangSatuanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBarangSatuanRequest $request)
    {
        $satuan = $this->barangSatuanRepository->find($id);

        if (empty($satuan)) {
            Flash::error('Barang Satuan not found');

            return redirect(route('admin.master.satuan.index'));
        }

        $satuan = $this->barangSatuanRepository->update($request->all(), $id);

        Flash::success('Barang Satuan updated successfully.');

        return redirect(route('admin.master.satuan.index'));
    }

    /**
     * Remove the specified BarangSatuan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $satuan = $this->barangSatuanRepository->find($id);

        if (empty($satuan)) {
            Flash::error('Barang Satuan not found');

            return redirect(route('admin.master.satuan.index'));
        }

        $this->barangSatuanRepository->delete($id);

        Flash::success('Barang Satuan deleted successfully.');

        return redirect(route('admin.master.satuan.index'));
    }
}
