<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarangKategoriRequest;
use App\Http\Requests\UpdateBarangKategoriRequest;
use App\Repositories\BarangKategoriRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BarangKategoriController extends AppBaseController
{
    /** @var BarangKategoriRepository $barangKategoriRepository*/
    private $barangKategoriRepository;

    public function __construct(BarangKategoriRepository $barangKategoriRepo)
    {
        $this->barangKategoriRepository = $barangKategoriRepo;
    }

    /**
     * Display a listing of the BarangKategori.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $kategoris = $this->barangKategoriRepository->all();

        return view('admin.kategori.index')
            ->with('kategoris', $kategoris);
    }

    /**
     * Show the form for creating a new BarangKategori.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created BarangKategori in storage.
     *
     * @param CreateBarangKategoriRequest $request
     *
     * @return Response
     */
    public function store(CreateBarangKategoriRequest $request)
    {
        $input = $request->all();

        $barangKategori = $this->barangKategoriRepository->create($input);

        Flash::success('Barang Kategori saved successfully.');

        return redirect(route('admin.master.kategori.index'));
    }

    /**
     * Display the specified BarangKategori.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $barangKategori = $this->barangKategoriRepository->find($id);

        if (empty($barangKategori)) {
            Flash::error('Barang Kategori not found');

            return redirect(route('admin.master.kategori.index'));
        }

        return view('admin.kategori.show')->with('barangKategori', $barangKategori);
    }

    /**
     * Show the form for editing the specified BarangKategori.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $barangKategori = $this->barangKategoriRepository->find($id);

        if (empty($barangKategori)) {
            Flash::error('Barang Kategori not found');

            return redirect(route('admin.master.kategori.index'));
        }

        return view('admin.kategori.edit')->with('barangKategori', $barangKategori);
    }

    /**
     * Update the specified BarangKategori in storage.
     *
     * @param int $id
     * @param UpdateBarangKategoriRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBarangKategoriRequest $request)
    {
        $barangKategori = $this->barangKategoriRepository->find($id);

        if (empty($barangKategori)) {
            Flash::error('Barang Kategori not found');

            return redirect(route('admin.master.kategori.index'));
        }

        $barangKategori = $this->barangKategoriRepository->update($request->all(), $id);

        Flash::success('Barang Kategori updated successfully.');

        return redirect(route('admin.kategori.index'));
    }

    /**
     * Remove the specified BarangKategori from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $barangKategori = $this->barangKategoriRepository->find($id);

        if (empty($barangKategori)) {
            Flash::error('Barang Kategori not found');

            return redirect(route('admin.master.kategori.index'));
        }

        $this->barangKategoriRepository->delete($id);

        Flash::success('Barang Kategori deleted successfully.');

        return redirect(route('admin.master.kategori.index'));
    }
}
