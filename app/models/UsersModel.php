<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model
{
    protected $table = 'users';

    public function getAll()
    {
        return $this->db
            ->table($this->table)
            ->get_all();
    }

    public function getByUsername($username)
    {
        return $this->db
            ->table($this->table)
            ->where('username', $username)
            ->get();
    }
}