<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Jwt extends ResourceController
{
    protected $modelName    = 'App\Models\ModelJwt';
    protected $format       = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $validation = \Config\Services::validation();
        $aturan = [
            'Username' => [
                'rules' => 'required',
                'errors' => 'Silahkan masukan username'
            ],
            'Password' => [
                'rules' => 'required',
                'errors' => 'Silahkan masukan password'
            ]
        ];
        $validation->setRules($aturan);
        if(!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        $Username = $this->request->getVar('Username');
        $Password = $this->request->getVar('Password');

        $data = $this->model->getUsername($Username);

        if($data['Password'] != md5($Password)){
            return $this->fail("Password tidak sesuai");
        }

        helper('jwt');
        $response = [
            'message' => 'Otentikasi berhasil dilakukan',
            'data' => $data,
            'access_token' => createJWT($Username)
        ];
        return $this->respond($response);
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
        //
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
        //
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
        //
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
        //
    }
}
