<?php
    session_start();

    require_once __DIR__ . '/../app/controllers/AuthController.php';
    
    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/admin-sidebar.html');
    
    $body = file_get_contents('./html/detail-song.html');
    
    if(!isset($_SESSION['user_id']) && $user_role === 'admin'){
        $sidebar = file_get_contents('./html/template/admin-sidebar.html');
        $body = str_replace('{{ nav }}', $nav, $body);
        $body = str_replace('{{ sidebar }}', $sidebar, $body);
    
        echo $body;
    } else{
        http_response_code(403);
        echo file_get_contents('./html/403.html');
        // die('Forbidden');
    } 
    
?>