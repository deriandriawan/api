<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $modelName    = 'App\Models\AuthModel';
    protected $format       = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    
    public function index()
    {
        $data = $this->model->findAll();
        if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = $this->model->find([$id]);
        if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
        return $this->respond($data[0]);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'Nik'       => 'required',
            'Username'  => 'required',
            'Password'  => 'required'
        ]);
        if(!$rules){
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }
        $IdMax = $this->model->getMaxId();
        $Id = $IdMax['Id']+1;
        $data = [
            'Id' => $Id,
            'Nik' => esc($this->request->getVar('Nik')),
            'Username' => esc($this->request->getVar('Username')),
            'Password' => esc($this->request->getVar('Password'))
        ];
        $this->model->insert($data);
        $response = [
            'message'   => 'Data berhasil ditambahkan'
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = $this->model->find($id);
        if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
        
        $rules = $this->validate([
            'Nik'       => 'required',
            'Username'  => 'required',
            'Password'  => 'required'
        ]);
        if(!$rules){
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }
        $tgl = date('Y-m-d H:i:s');
        $data = [
            'Nik' => esc($this->request->getVar('Nik')),
            'Username' => esc($this->request->getVar('Username')),
            'Password' => esc($this->request->getVar('Password')),
            'updated_at' => $tgl
        ];
        $this->model->update($id, $data);
        $response = [
            'inputan'   => $data,
            'message'   => 'Data berhasil diedit'
        ];
        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
        $auth = $this->model->delete($id);
        if(!$auth) return $this->fail('Gagal Dihapus', 400);
        $response = [
            'message'   => 'Data Berhasil Dihapus'
        ];
        return $this->respondDeleted($response);
    }
    public function ambildata()
    {
        echo "<h1>db 1</h1>";
        print_r($this->model->ambilData());
        echo "<h1>db 2</h1>";
        print_r($this->model->ambilDataapi());
    }
}
