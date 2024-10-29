<?php

interface UserDao {
    public function getAllUsers();
    public function getUser($id);
    public function createUser($user);
    public function updateUser($user);
    public function deleteUser($id);
    public function login($email, $senha);
    public function logout();
    public function emailExists($email);

}
?>