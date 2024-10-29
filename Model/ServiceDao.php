<?php
interface ServiceDao {

    public function getService($id);
    public function getServicesByUser($idUsuario);
    public function createService($service);
    public function updateService($service);
    public function deleteService($id);
    public function listServicesFromOtherUsers($idUsuario);
}
?>
