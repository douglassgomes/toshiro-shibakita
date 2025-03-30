<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo PHP</title>
</head>
<body>
<?php
/**
 * Exemplo de conexão com banco de dados e inserção de registros
 * 
 * Este script conecta a um banco de dados MySQL e insere dados aleatórios
 * na tabela 'dados'.
 * 
 */

// Configuração para exibir erros - apenas em ambiente de desenvolvimento
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Define o charset da página
header('Content-Type: text/html; charset=UTF-8');

// Exibe a versão atual do PHP
echo 'Versão Atual do PHP: ' . phpversion() . '<br>';

// Constantes de configuração do banco de dados
define('DB_SERVER', 'localhost');  // Alterar para ambiente de produção
define('DB_USERNAME', 'usuario_app');  // Nunca usar root em produção
define('DB_PASSWORD', 'senha_segura');  // Usar senha forte em produção
define('DB_NAME', 'dados');

// Criar conexão usando try-catch para melhor tratamento de erros
try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Verificar conexão
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }
    
    // Definir o charset da conexão
    $conn->set_charset("utf8mb4");
    
    // Gerar valores aleatórios para inserção do ID do produto
    $ProdutoID = rand(1, 999);
    
    // Gerar string aleatória mais segura para demais campos do banco
    $valor_aleatorio = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    
    // Obter nome do host
    $host_name = gethostname();
    
    // Preparar a consulta usando prepared statements para prevenir SQL Injection
    $stmt = $conn->prepare("INSERT INTO dados (ProdutoID, ProdutoNome, ProdutoMarca, ProdutoCategoria, Host) 
                           VALUES (?, ?, ?, ?, ?)");
    
    // Vincular parâmetros
    $stmt->bind_param("isssss", $ProdutoID, $valor_aleatorio, $valor_aleatorio, $valor_aleatório, $host_name);
    
    // Executar a consulta
    if ($stmt->execute()) {
        echo "<p class='success'>Registro criado com sucesso!</p>";
    } else {
        echo "<p class='error'>Erro ao criar registro: " . $stmt->error . "</p>";
    }
    
    // Fechar o statement e a conexão
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    // Tratamento de erro mais robusto
    echo "<p class='error'>Erro: " . $e->getMessage() . "</p>";
    exit();
}
?>
</body>
</html>
