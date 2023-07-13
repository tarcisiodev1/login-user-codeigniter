<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user', 'email', 'profile', 'password', 'avatar'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [

        // 'user' => 'required|is_unique[users.user]',
        // 'name' => 'required',
        // 'email' => 'required',
        // 'profile' => 'required',
        // 'password' => 'required',
        // 'avatar' => 'required',


    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPass'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function hashPass($data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        // unset($data['data']['password']);

        return $data;
    }

    public function check($user, $pass)
    {
        $getUser = $this->select('id, user, email, profile, password, avatar')->where('user', $user)->first();

        if (is_null($getUser)) {
            return false;
        }

        if (!password_verify($pass, $getUser->password)) {
            return false;
        }
        return $getUser;
    }
}
