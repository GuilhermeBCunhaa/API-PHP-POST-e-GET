<?php

// requisição para enviar os dados para o servidor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // verifica se não tem dados nulos
    if (isset($_POST['cpf']) && isset($_POST['nome']) && isset($_POST['data_nascimento'])) {
        
        $data = file_exists('usuarios.json') ? json_decode(file_get_contents('usuarios.json'), true) : array();

        foreach ($data as $user) {
            if ($user['cpf'] == $_POST['cpf']) {
                http_response_code(400);
                echo "CPF já cadastrado";
                exit;
            }
        }

        $data[] = array('cpf'=> $_POST['cpf'], 'nome'=> $_POST['nome'], 'data_nascimento'=> $_POST['data_nascimento']);

        file_put_contents('usuarios.json', json_encode($data));

        echo "cadastrado com sucesso";
    }else {
        http_response_code(400);
        echo "não foi possivel cadastrar";
    }

//requisição para mostrar os dados para o usuario
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cpf'])) {
        
        $data = file_exists('usuarios.json') ? json_decode(file_get_contents('usuarios.json', true)) : array();
        
        // busca pelo cpf e retorna ao usuario se o mesmo existir
        foreach ($data as $user) {
            if ($_GET['cpf'] == $user->cpf) {
                echo json_encode($user); 
                exit;
            }
        }
        
    }else {
        http_response_code(400);
        echo "CPF não informado";
    }

}else {
    http_response_code(405);
    echo "metodo não suportado";
}
?>

<meta http-equiv="refresh" content="1; URL='http://localhost:8080/'"/>