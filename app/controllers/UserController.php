<?php

    require_once __DIR__ . '/../models/User.php';
    function createEntry($user, $i){
        $user['role'] = 'User';

        $html = <<<"EOT"
            <tbody class="content-entry">
                <td>$i</td>
                <td>$user[name]</td>
                <td>$user[username]</td>
                <td>$user[email]</td>
                <td>$user[role]</td>
                <td>$user[last_updated]</td>
            </tbody>
        EOT;

        return $html;
    }


    $users = new User();
    $users = $users->getAll();
    $cards = '';
    $i = 1;
    foreach ($users as $user) {
        $cards .= createEntry($user, $i);
        $i++;
    }

    echo json_encode([$cards]);
?>