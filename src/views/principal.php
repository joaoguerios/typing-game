<?php

$servername = "localhost";
$username = "root";
$password = "root";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$databaseName = "trabalhoweb";
$query = "SHOW DATABASES LIKE '$databaseName'";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        echo "O banco de dados '$databaseName' existe!<br>";
        $conn->select_db($databaseName);
        //---------------------------------------------------
        $tableQueryclans = "SHOW TABLES LIKE 'clans'";
        $tableResult = $conn->query($tableQueryclans);
        if ($tableResult->num_rows == 0) {
            $createTableQueryclans = "
                CREATE TABLE clans (
                    clan_id INT NOT NULL AUTO_INCREMENT,
                    clan_name VARCHAR(100) NOT NULL,
                    clan_password VARCHAR(100),
                    PRIMARY KEY (clan_id)
                );
            ";
            if ($conn->query($createTableQueryclans) === TRUE) {
                echo "A tabela 'clans' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'clans': " . $conn->error . "<br>";
            }
        } else {
            echo "A tabela 'clans' já existe.<br>";
        }
        //-------------------------------------------------
        $tableQueryusers = "SHOW TABLES LIKE 'users'";
        $tableResult = $conn->query($tableQueryusers);
        if ($tableResult->num_rows == 0) {
            $createTableQueryusers = "
                CREATE TABLE users(
                    user_id INT NOT NULL AUTO_INCREMENT,
                    clan_id INT,
                    username VARCHAR(100) NOT NULL,
                    email VARCHAR(200) NOT NULL,
                    password VARCHAR(200) NOT NULL,
                    CONSTRAINT PKUSER PRIMARY KEY (user_id),
                    CONSTRAINT FKUSERCLAN FOREIGN KEY (clan_id) REFERENCES clans(clan_id)
                );
            ";
            if ($conn->query($createTableQueryusers) === TRUE) {
                echo "A tabela 'user' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'users': " . $conn->error . "<br>";
            }
        } else {
            echo "A tabela 'users' já existe.<br>";
        }
        //-----------------------------------------------
        $tableQueryhistoric = "SHOW TABLES LIKE 'historic'";
        $tableResult = $conn->query($tableQueryhistoric);
        if ($tableResult->num_rows == 0) {
            $createTableQueryhistoric = "
                CREATE TABLE historic (
                    match_id SERIAL,
                    user_id INT NOT NULL,
                    points INT NOT NULL,
                    date_match TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT PKHISTORIC PRIMARY KEY(match_id),
                    CONSTRAINT FKHISTORICUSER FOREIGN KEY (user_id) REFERENCES users(user_id)
                );
            ";
            if ($conn->query($createTableQueryhistoric) === TRUE) {
                echo "A tabela 'historic' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'historic': " . $conn->error . "<br>";
            }
        } else {
            echo "A tabela 'historic' já existe.<br>";
        }
        //-----------------------------------------------
    } else {
        $createDatabaseQuery = "CREATE DATABASE $databaseName";
        if ($conn->query($createDatabaseQuery) === TRUE) {
            echo "O banco de dados '$databaseName' foi criado com sucesso!<br>";
            $conn->select_db($databaseName);
            //-------------------------------------
            $createTableQueryclans = "
                CREATE TABLE clans (
                    clan_id INT NOT NULL AUTO_INCREMENT,
                    clan_name VARCHAR(100) NOT NULL,
                    clan_password VARCHAR(100),
                    PRIMARY KEY (clan_id)
                );
            ";
            if ($conn->query($createTableQueryclans) === TRUE) {
                echo "A tabela 'clans' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'clans': " . $conn->error . "<br>";
            }
            //-------------------------------------------------
            $createTableQueryusers = "
                CREATE TABLE users(
                    user_id INT NOT NULL AUTO_INCREMENT,
                    clan_id INT,
                    username VARCHAR(100) NOT NULL,
                    email VARCHAR(200) NOT NULL,
                    password VARCHAR(200) NOT NULL,
                    CONSTRAINT PKUSER PRIMARY KEY (user_id),
                    CONSTRAINT FKUSERCLAN FOREIGN KEY (clan_id) REFERENCES clans(clan_id)
                );
            ";
            if ($conn->query($createTableQueryusers) === TRUE) {
                echo "A tabela 'user' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'users': " . $conn->error . "<br>";
            }
            //---------------------------------------------
            $createTableQueryhistoric = "
                CREATE TABLE historic (
                    match_id SERIAL,
                    user_id INT NOT NULL,
                    points INT NOT NULL,
                    date_match TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT PKHISTORIC PRIMARY KEY(match_id),
                    CONSTRAINT FKHISTORICUSER FOREIGN KEY (user_id) REFERENCES users(user_id)
                );
            ";
            if ($conn->query($createTableQueryhistoric) === TRUE) {
                echo "A tabela 'historic' foi criada com sucesso!<br>";
            } else {
                echo "Erro ao criar a tabela 'historic': " . $conn->error . "<br>";
            }
            //--------------------------------------------
        } else {
            echo "Erro ao criar o banco de dados '$databaseName': " . $conn->error . "<br>";
        }
    }
} else {
    echo "Erro ao executar a consulta: " . $conn->error . "<br>";
}

$conn->close();

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\public\signup.css">
</head>
<body>
	<header class="p-3 menu">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="" class="nav-link px-2 text-white">Home</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.php"><button type="button"
                            class="btn btn-warning">Login</button></a>
                </div>
            </div>
        </div>
    </header>
	<main>
		<div class="page">
        <a href="login.php"><button type="button" class="btn btn-warning btn-lg" style="font-size: 50px;"
                    id="buttonStart">Ja possuo acesso ao banco de dados</button></a>
		</div>
	</main>
</body>
</html>