<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarangMerkRequest;
use App\Http\Requests\UpdateBarangMerkRequest;
use App\Repositories\BarangMerkRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BarangMerkController extends AppBaseController
{
    /** @var BarangMerkRepository $barangMerkRepository*/
    private $barangMerkRepository;

    public function __construct(BarangMerkRepository $barangMerkRepo)
    {
        $this->barangMerkRepository = $barangMerkRepo;
    }

    /**
     * Display a listing of the BarangMerk.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $merks = $this->barangMerkRepository->all();

        return view('admin.merk.index')
            ->with('merks', $merks);
    }

    /**
     * Show the form for creating a new BarangMerk.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.merk.create');
    }

    /**
     * Store a newly created BarangMerk in storage.
     *
     * @param CreateBarangMerkRequest $request
     *
     * @return Response
     */
    public function store(CreateBarangMerkRequest $request)
    {
        $input = $request->all();

        $barangMerk = $this->barangMerkRepository->create($input);

        Flash::success('Barang Merk saved successfully.');

        return redirect(route('admin.master.merk.index'));
    }

    /**
     * Display the specified BarangMerk.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $barangMerk = $this->barangMerkRepository->find($id);

        if (empty($barangMerk)) {
            Flash::error('Barang Merk not found');

            return redirect(route('admin.master.merk.index'));
        }

        return view('admin.merk.show')->with('barangMerk', $barangMerk);
    }

    /**
     * Show the form for editing the specified BarangMerk.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $merk = $this->barangMerkRepository->find($id);

        if (empty($merk)) {
            Flash::error('Barang Merk not found');

            return redirect(route('admin.master.merk.index'));
        }

        return view('admin.merk.edit')->with('merk', $merk);
    }

    /**
     * Update the specified BarangMerk in storage.
     *
     * @param int $id
     * @param UpdateBarangMerkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBarangMerkRequest $request)
    {
        $barangMerk = $this->barangMerkRepository->find($id);

        if (empty($barangMerk)) {
            Flash::error('Barang Merk not found');

            return redirect(route('admin.master.merk.index'));
        }

        $barangMerk = $this->barangMerkRepository->update($request->all(), $id);

        Flash::success('Barang Merk updated successfully.');

        return redirect(route('admin.merk.index'));
    }

    /**
     * Remove the specified BarangMerk from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $barangMerk = $this->barangMerkRepository->find($id);

        if (empty($barangMerk)) {
            Flash::error('Barang Merk not found');

            return redirect(route('admin.master.merk.index'));
        }

        $this->barangMerkRepository->delete($id);

        Flash::success('Barang Merk deleted successfully.');

        return redirect(route('admin.merk.index'));
    }
}
