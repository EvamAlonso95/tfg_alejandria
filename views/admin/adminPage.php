<?php require_once 'views/layout/head.php';
require_once 'views/admin/adminMenu.php';

$vista = $_POST['vista'] ?? 'usuarios'; // 'usuarios' por defecto

switch ($vista) {
    case 'libros':
        require_once 'views/admin/adminBooksTable.php';
        break;
    case 'author':
        require_once 'views/admin/adminAuthorTable.php';
        break;
    case 'usuarios':
    default:
        require_once 'views/admin/adminUsersTable.php';
        break;
}

require_once 'views/layout/footer.php';
