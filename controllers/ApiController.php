<?php
class ApiController
{

    public function users()
    {
        // TODO: isAdmin
        $userRaw = User::getAllUsers();
        $users = [];
        foreach ($userRaw as $user) {
            $users[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'biography' => $user->getBiography(),
                'email' => $user->getEmail(),
                'profile_img' => base_url . $user->getProfileImage(),
                'role' => $user->getRole()->getName(),
                'role_id' => $user->getRole()->getId(),
            ];
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['data' => $users]);
    }

    //TODO: editUser()
    // validar que sea el admin
    public function editUser()
    {

        if (isset($_POST['idUser'])) {
            echo json_encode(['success' => 'Se ha podido editar el usuario.']);
            return;
        } else {
            echo json_encode(['error' => 'No existe el método solicitado']);
        }
    }

    //TODO: deleteUser()
    // validar que sea el admin
}
