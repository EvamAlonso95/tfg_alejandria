<?php
class ApiController
{

    public function users()
    {
        if (Utils::isAdmin()) {

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
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    //TODO: editUser()
    // validar que sea el admin
    public function editUser()  {


        if (Utils::isAdmin()) {
            if (isset($_POST['idUser'])) {
                echo "llega al controlador";
                $user = User::createById($_POST['idUser']);
                // $user->setName($_POST['name']);
                $user->setRole(intval($_POST['role']));

                // Para no romper el método de User de edición, pues espera mas campos
                $user->setName($user->getName());
                $user->setEmail($user->getEmail());
                $user->setBiography($user->getBiography());
                $user->setProfileImage($user->getProfileImage());


                $user->editUser();
                echo json_encode(['success' => 'Se ha podido editar el usuario.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    //TODO: deleteUser()
    // validar que sea el admin
    public function deleteUser()  {
        if (Utils::isAdmin()) {
            if (isset($_POST['idUser'])) {
                $user = User::createById($_POST['idUser']);
                $user->deleteUser();
                echo json_encode(['success' => 'Se ha podido eliminar el usuario.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }
}
