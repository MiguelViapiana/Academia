<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Personalizar treino</title>
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <style>
          body {
               background-color: #f8f9fa;
          }

          .navbar {
               background-color: #022B42;
          }

          .jumbotron {
               background-color: #004D74;
               color: #fff;
               text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
          }

          .treinos {
               background-color: #fff;
               padding: 20px;
               border-radius: 8px;
               box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
               margin-bottom: 20px;
          }

          h4 {
               margin-bottom: 20px;
          }
     </style>
</head>

<body>
     <nav class="navbar navbar-expand-lg navbar-dark">
          <a class="navbar-brand" href="index.php">Home</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                         <a class="btn btn-outline-primary mx-1" href="logado.php">Voltar</a>
                    </li>
                    
               </ul>
          </div>
     </nav>

     <header class="jumbotron text-center">
          <h1 class="display-4">Personalize seu treino!</h1>
          <p class="lead">Não esqueça o alongamento!</p>
     </header>
     <?php

     session_start();
     require_once "banco.php";

     $usu = $_SESSION['usuario'];
     $nomePlanilha = $_SESSION['nomePlanilha'] ?? null;

     if ($nomePlanilha == null) {
          die("Nome da planilha não fornecido");
     }

     try {
          // Escapa o nome da tabela para evitar injeção de SQL
          $tabela = "planilha_" . $banco->real_escape_string($usu);
  
          // Tenta selecionar dados da tabela do usuário
          $busca = $banco->query("SELECT * FROM $tabela");
  
          // Se a tabela não existe, cria uma nova tabela
          if ($busca === false) {
              $criaTabela = "CREATE TABLE IF NOT EXISTS $tabela (
              cod INT NOT NULL AUTO_INCREMENT,
              nome_planilha VARCHAR(255) NOT NULL,
              PRIMARY KEY (cod)
          )";
  
              if ($banco->query($criaTabela)) {
                  echo "Tabela criada com sucesso.";
              } else {
                  throw new Exception("Erro ao criar a tabela: " . $banco->error);
              }
          }
  
          // Verifica se a planilha já existe na tabela do usuário
          $busca = $banco->query("SELECT * FROM $tabela WHERE nome_planilha = '$nomePlanilha'");
          if ($busca->num_rows == 0) {
              $inserePlanilha = "INSERT INTO $tabela (nome_planilha) VALUES ('$nomePlanilha')";
              if ($banco->query($inserePlanilha)) {
                  echo "Planilha '$nomePlanilha' inserida com sucesso.";
              } else {
                  throw new Exception("Erro ao inserir a planilha: " . $banco->error);
              }
          } else {
              echo "A planilha '$nomePlanilha' já existe.";
          }
      } catch (mysqli_sql_exception $e) {
          if ($e->getCode() == 1146) { // Código de erro para tabela não encontrada
              $criaTabela = "CREATE TABLE IF NOT EXISTS $tabela (
              cod INT NOT NULL AUTO_INCREMENT,
              nome_planilha VARCHAR(255) NOT NULL,
              PRIMARY KEY (cod)
          )";
              if ($banco->query($criaTabela)) {
                  echo "Tabela criada com sucesso.";
                  $inserePlanilha = "INSERT INTO $tabela (nome_planilha) VALUES ('$nomePlanilha')";
                  if ($banco->query($inserePlanilha)) {
                      echo "Planilha '$nomePlanilha' inserida com sucesso.";
                  } else {
                      throw new Exception("Erro ao inserir a planilha: " . $banco->error);
                  }
              } else {
                  throw new Exception("Erro ao criar a tabela: " . $banco->error);
              }
          } else {
              echo "Erro: " . $e->getMessage();
          }
      } catch (Exception $e) {
          echo "Erro: " . $e->getMessage();
      }

     ?>

     <div class="container my-5">
          <h1>Treino: <?= $nomePlanilha ?></h1>
          <div class="row">
               
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Peito</h4>
                         <form method="post">
                              <select name="exercicio" id="treino" class="form-select form-select-md mb-3 p-1" aria-label="Large select example">
                                   <option >Exercício</option>
                                   <option value="Supino Reto">Supino reto</option>
                                   <option value="Supino Inclinado Barra">Supino inclinado barra</option>
                                   <option value="Supino declinado barra">Supino declinado barra</option>
                                   <option value="Cruxifixo reto">Cruxifixo reto</option>
                                   <option value="Voador">Voador</option>
                                   <option value="Flexão de braços">Flexão de braços</option>
                              </select><br>
                              <select name="series" class="form-select form-select-md mb-3 p-1" aria-label="Large select example">
                                   <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" class="form-select form-select-md mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Costas</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Puxada frontal polia alta">Puxada frontal polia alta</option>
                                   <option value="Remada fechada">Remada fechada</option>
                                   <option value="Puxada neutra">Puxada neutra</option>
                                   <option value="Remada unilateral halteres">Remada unilateral halteres</option>
                                   <option value="Pulldown polia alta">Pulldown polia alta</option>
                                   <option value="Remada sentada polia baixa">Remada sentada polia baixa</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Ombros</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Elevação lateral halteres">Elevação lateral halteres</option>
                                   <option value="Elevação frontal halteres">Elevação frontal halteres</option>
                                   <option value="Desenvolvimento militar barra">Desenvolvimento militar barra</option>
                                   <option value="Desenvolvimento Arnold">Desenvolvimento Arnold</option>
                                   <option value="Elevação posterior de ombros">Elevação posterior de ombros</option>
                                   <option value="Remada alta (Upright Row)">Remada alta (Upright Row)</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Tríceps</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Tríceps testa barra">Tríceps testa barra</option>
                                   <option value="Tríceps corda polia alta">Tríceps corda polia alta</option>
                                   <option value="Tríceps francês">Tríceps francês</option>
                                   <option value="Tríceps coice polia">Tríceps coice polia</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Bíceps</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Rosca direta barra">Rosca direta barra</option>
                                   <option value="Rosca concentrada halteres">Rosca concentrada halteres</option>
                                   <option value="Rosca Scott">Rosca Scott</option>
                                   <option value="Rosca Bayesian">Rosca Bayesian</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">

                    <div class="treinos">
                         <h4>Pernas</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Leg press 45º">Leg press 45º</option>
                                   <option value="Cadeira extensora">Cadeira extensora</option>
                                   <option value="Cadeira flexora">Cadeira flexora</option>
                                   <option value="Flexora">Flexora</option>
                                   <option value="Extensora">Extensora</option>
                                   <option value="Afundo com barra">Afundo com barra</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
               <div class="col-md-4">
                    <div class="treinos">
                         <h4>Abdômen</h4>
                         <form method="POST" action="">
                              <select name="exercicio" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Exercício</option>
                                   <option value="Abdominal na prancha inclinada">Abdominal na prancha inclinada</option>
                                   <option value="Prancha abdominal estática">Prancha abdominal estática</option>
                                   <option value="Elevação de pernas na barra fixa">Elevação de pernas na barra fixa</option>
                                   <option value="Crunch abdominal com peso">Crunch abdominal com peso</option>
                                   <option value="Prancha lateral">Prancha lateral</option>
                                   <option value="Flexão de pernas na barra fixa">Flexão de pernas na barra fixa</option>
                              </select><br>
                              <select name="series" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Série</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                              </select><br>
                              <select name="repeticoes" id="treino" class="form-select form-select-lg mb-3 p-1" aria-label="Large select example">
                              <option >Repetições</option>
                                   <option value="6">6</option>
                                   <option value="8">8</option>
                                   <option value="10">10</option>
                                   <option value="12">12</option>
                                   <option value="15">15</option>
                              </select><br>
                              <button type="submit" class="btn btn-primary" name="adicionar">Adicionar</button>
                         </form>

                    </div>
               </div>
          </div>
     </div>

     <?php

     require_once "banco.php";

     $usu = $_SESSION['usuario'];
     $nomePlanilha = $_SESSION['nomePlanilha'] ?? null;


     if (isset($_POST['adicionar'])) {
          $nomeExercicio = $_POST['exercicio'] ?? null;
          $peso = $_POST['peso'] ?? null;
          $series = $_POST['series'] ?? null;
          $repeticoes = $_POST['repeticoes'] ?? null;

          try {
               if (is_null($nomeExercicio) ||  is_null($series) || is_null($repeticoes)) {
                    echo "Todos os campos são obrigatórios.";
               } else {
                    //Tabela do usuário
                    $tabela = "planilha_" . $banco->real_escape_string($usu);

                    // Verificar se o exercício já existe

                    $stmt = ("SELECT * FROM exercicios WHERE nome = '$nomeExercicio' AND peso = '$peso' AND series = '$series' AND repeticoes = '$repeticoes'");
                    $resp = $banco->query($stmt);
                    if ($resp->num_rows == 0) {

                         // Inserir exercício na tabela 'exercicios' se não existir
                         $stmt = $banco->prepare("INSERT INTO exercicios (nome, peso, series, repeticoes) VALUES ('$nomeExercicio', '$peso', '$series', '$repeticoes')");
                         $stmt->execute();
                         $codExercicio = $stmt->insert_id; // Obtém o ID do exercício inserido
                    } else {
                         $row = $result->fetch_assoc();
                         $codExercicio = $row['cod'];
                    }

                    // Adicionar exercício na planilha do usuário
                    for ($i = 0; $i < 10; $i++) {
                         $colunaExercicio = "exercicio$i";

                         // Verificar se a coluna já existe
                         $result = $banco->query("SHOW COLUMNS FROM $tabela LIKE '$colunaExercicio'");
                         if ($result->num_rows == 0) {
                              // Adicionar coluna e chave estrangeira se não existir
                              $banco->query("ALTER TABLE $tabela ADD $colunaExercicio INT");
                              $banco->query("ALTER TABLE $tabela ADD FOREIGN KEY ($colunaExercicio) REFERENCES exercicios(cod)");
                         }

                         // Inserir o exercício na coluna correspondente
                         $busca = $banco->query("SELECT * FROM $tabela WHERE $colunaExercicio IS NULL AND nome_planilha = '$nomePlanilha'");
                         if ($busca->num_rows > 0) {
                              $banco->query("UPDATE $tabela SET $colunaExercicio = $codExercicio WHERE $colunaExercicio IS NULL AND nome_planilha = '$nomePlanilha' LIMIT 1");
                              echo "<script>alert('Exercício adicionado com sucesso!');</script>";
                              return;
                         }
                    }
               }
          } catch (mysqli_sql_exception $e) {
               echo "Erro de SQL: " . $e->getMessage();
              // echo "<script>alert('Não foi possível adicionar o exercício.');</script>";
          } catch (Exception $e) {

               echo "Erro: " . $e->getMessage();
          }
     }



     ?>








     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>