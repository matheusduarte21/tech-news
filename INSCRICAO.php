<?php
include_once('conexao.php'); //conexão do php com o formulario


 // A função abaixo demonstra o uso de uma expressão regular que identifica, de forma simples, telefones válidos no Brasil.
 //Exemplos válidos: +55 (21) 98888-8888 / 9999-9999 / 21 98888-8888 / 5511988888888 / +55 (021) 98888-8888 / 021 99995-3333

 //@param string $phoneString 
 //@param bool $forceOnlyNumber Passar false caso não queira remover o traço "-"
 //@return string|null ['ddi' => 'string', 'ddd' => string , 'number' => 'string']

function brazilianPhoneParser(string $phoneString, bool $forceOnlyNumber = true) : ?string
{
    $phoneString = preg_replace('/[()]/', '', $phoneString);
    if (preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([0-0]?[0-9]{1}[0-9]{1})\)?\s?)??(?:((?:9\d|[2-9])\d{3}\-?\d{4}))$/', $phoneString, $matches) === false) {
        return null;
    }

    $ddi = $matches[1] ?? '';
    $ddd = preg_replace('/^0/', '', $matches[2] ?? '');
    $number = $matches[3] ?? '';
    if ($forceOnlyNumber === true) {
        $number = preg_replace('/-/', '', $number);
    }

    return $ddi . $ddd . $number;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscrição Tech News</title>
    <meta charset="UTF-8">
    <meta name="description" content="Notícias de Tecnologia">
    <meta name="keywords" content="Notícias, Tecnologia, Hardware, Ultimas notícias tech">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--LINKS CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="./CSS/STYLE-INSCRICAO.css" rel="stylesheet" />
    <link rel="stylesheet" href="./CSS/STYLE.css">
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<body>
    <header>
        <div class="container__header">
            <div class="logo">
                <img src="IMAGENS/IMG3.svg" alt="Logo Tech News">
            </div><!--Logo-->
            <div class="menu-btn">
                <i class="fa fa-bars fa-2x" style="font-size: 30px;" onclick="ShowNavBar()"></i>
            </div>
            <ul class="header-display">
                <li><a href="INDEX.html">INÍCIO</a></li>
                <li><a href="INSCRICAO.php">INSCRIÇÃO</a></li>
                <li><a href="NOTICIAS.html">ACESSAR NOTÍCIAS</a></li>
            </ul>
        </div><!--Center-->
    </header>

    <?php
    

    if (isset( $_POST ) && !empty($_POST)) {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    

        // declarando as variaveis
        $nome = $dados['nome'] ?? null;
        $email = $dados['email'] ?? null;
        $telefone = $dados['telefone'] ?? null;
        $genero = $dados['genero'] ?? null;
        $data_nascimento = $dados['data_nascimento'] ?? null;
        $cidade = $dados['cidade'] ?? null;
        $estado = $dados['estado'] ?? null;
        $endereco = $dados['endereco'] ?? null;
        $recomendacoes = $dados['recomendacoes'] ?? null;

        $telefone_formatado = brazilianPhoneParser($telefone, false);

        // validando os campos do formulário individualmente
        $dados = array_map('trim', $dados);
        if (empty($nome)) {
            echo "<center><p style='color: #f00'; font-size='30px'>Erro: Necessário preencher o campo nome!</p></center>";
        } elseif (empty( $email)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p></center>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<center><p style='color: #f00;'>Erro: O endereço de e-mail é inválido!</p></center>";
        } elseif (empty($telefone)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo telefone!</p></center>";
        } elseif (empty($telefone_formatado)) {
            echo "<center><p style='color: #f00;'>Erro: Telefone informado é inválido! Tente nesse formato 00 00000-0000 </p></center>";
        } elseif (empty($genero)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário escolher uma opção em gênero!</p></center>";
        } elseif (empty($data_nascimento)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo data de nascimento!</p></center>";
        } elseif (empty($cidade)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo cidade!</p></center>";
        } elseif (empty($estado)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo estado!</p></center>";
        } elseif (empty($endereco)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário preencher o campo endereco!</p></center>";
        } elseif (empty($recomendacoes)) {
            echo "<center><p style='color: #f00;'>Erro: Necessário escolher uma das opções em recomendações!</p></center>";
        } else {

            // Inserindo os dados na tabela no BD
            $result = mysqli_query($conexao, "INSERT INTO inscritos (nome, email, telefone, genero, data_nascimento, cidade, estado, endereco, recomendacoes) 
            VALUES ('$nome','$email','$telefone_formatado','$genero','$data_nascimento','$cidade','$estado','$endereco','$recomendacoes')");
            unset($dados);
            echo "<center><p style='color: green'; font-size='20px'>Dados cadastrados com sucesso!</p></center>";
        }
    }

    ?>

    <!--Formulário de inscrição-->
    <div class="box">
        <form name="formInscricao" action="INSCRICAO.php" method="POST">
            <fieldset>
                <legend><b>Inscrição Tech News</b></legend>
                <br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $nome = "";
                    if (isset($dados['nome'])) {
                        $nome = $dados['nome'];
                    }
                    ?>
                    <input type="text" name="nome" id="nome" class="inputuser" value="<?php echo $nome; ?>">
                    <label for="nome" class="labelinput">Nome completo</label>
                </div><!--Inputbox-->
                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $email = "";
                    if (isset($dados['email'])) {
                        $email = $dados['email'];
                    }
                    ?>
                    <input type="text" name="email" id="email" class="inputuser" value="<?php echo $email; ?>">
                    <label for="email" class="labelinput">Email</label>
                </div><!--Inputbox-->
                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $telefone = "";
                    if (isset($dados['telefone'])) {
                        $telefone = $dados['telefone'];
                    }
                    ?>
                    <input type="tel" name="telefone" id="telefone" class="inputuser" value="<?php echo $telefone; ?>">
                    <label for="telefone" class="labelinput">Telefone </label>
                </div><!--Inputbox-->
                <br><br>
                <p>Gênero:</p>
                <input type="radio" name="genero" id="feminino" value="feminino">
                <label for="feminino">Feminino</label>
                <br>
                <input type="radio" name="genero" id="masculino" value="masculino">
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" name="genero" id="feminino" value="outro">
                <label for="feminino">Outro</label>

                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $data_nascimento = "";
                    if (isset($dados['data_nascimento'])) {
                        $data_nascimento = $dados['data_nascimento'];
                    }
                    ?>
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" class="inputuser" value="<?php echo $data_nascimento; ?>">
                </div><!--Inputbox-->
                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $cidade = "";
                    if (isset($dados['cidade'])) {
                        $cidade = $dados['cidade'];
                    }
                    ?>
                    <input type="text" name="cidade" id="cidade" class="inputuser" value="<?php echo $cidade; ?>">
                    <label for="cidade" class="labelinput">Cidade</label>
                </div><!--Inputbox-->
                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $estado = "";
                    if (isset($dados['estado'])) {
                        $estado = $dados['estado'];
                    }
                    ?>
                    <input type="text" name="estado" id="estado" class="inputuser" value="<?php echo $estado; ?>">
                    <label for="estado" class="labelinput">Estado</label>
                </div><!--Inputbox-->
                <br><br>
                <div class="inputbox">
                    <!--Código que retorna os campos preenchidos pelo usuário caso ocorra um erro-->
                    <?php
                    $endereco = "";
                    if (isset($dados['endereco'])) {
                        $endereco = $dados['endereco'];
                    }
                    ?>
                    <input type="text" name="endereco" id="endereco" class="inputuser" value="<?php echo $endereco; ?>">
                    <label for="endereco" class="labelinput">Endereço</label>
                </div><!--Inputbox-->
                <br>
                <p>Gostaria de receber notícias?</p>
                <br>
                <input type="radio" name="recomendacoes" id="sim" value="sim">
                <label for="sim">Sim</label>
                <input type="radio" name="recomendacoes" id="nao" value="nao">
                <label for="nao">Não</label>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div> <!--Box-->

    <script src="./JS/menuResponsivo.js"></script>
</body>

</html>