<?php

    require_once __DIR__ . '/../models/User.php';

    function createHeader(){
        $html = <<<"EOT"
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
        EOT;

        return $html;
    }

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


    if(isset($_GET["offset"])) {
        $offset = 0;
        $limit = 10;

        if(isset($_GET['offset'])) {
            $offset = (int)$_GET['offset'];
        }
        if(isset($_GET['limit'])) {
            $limit = (int)$_GET['limit'];
        }

        $users = new User();
        $users = $users->getBacthData($offset, $limit*4);

        if(count($users) > 0){
            $html = createHeader();
            $count = count($users);
            $i = 1;
            foreach($users as $user){
                $html .= createEntry($user, $i);
                if($i == $limit){
                    break;
                }
                $i++;
            }
            echo json_encode([$html, count($users)]);
        }else{
            echo json_encode(['', 0]);
        }
    }
?>