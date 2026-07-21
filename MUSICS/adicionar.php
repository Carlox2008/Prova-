<?php
include("../conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome_musica   = $_POST['nome_musica'];
    $nome_cantor   = $_POST['nome_cantor'];
    $tempo_duracao = $_POST['tempo_duracao'];
    $faixa_etaria  = $_POST['faixa_etaria'];
    $estilo_musica = $_POST['estilo_musica'];

    $stmt_catalogo = $con->prepare("INSERT INTO catalogo_musica (faixa_etaria, estilo_musica) VALUES (?, ?)");
    $stmt_catalogo->bind_param("is", $faixa_etaria, $estilo_musica);
    $stmt_catalogo->execute();

    $id_catalogo = $con->insert_id; 
    $stmt_catalogo->close();

    $stmt_musicas = $con->prepare("INSERT INTO musicas (nome_musica, nome_cantor, tempo_duracao) VALUES (?, ?, ?)");
    $stmt_musicas->bind_param("sss", $nome_musica, $nome_cantor, $tempo_duracao);
    $stmt_musicas->execute();
    
    $id_musica = $con->insert_id; 
    $stmt_musicas->close();

    $stmt_galeria = $con->prepare("INSERT INTO galeria (musicas_id, catalogo_id) VALUES (?, ?)");
    $stmt_galeria->bind_param("ii", $id_musica, $id_catalogo);
    $stmt_galeria->execute();
    $stmt_galeria->close();

 
    header("Location: listarM.php");
    exit(); 
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Musica</title>
      <style>
 
        body {
            background-color: #0d0d13;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        h1 {
            color: #fff;
            text-shadow: 0 0 10px #00f2fe, 0 0 20px #00f2fe;
            margin-bottom: 25px;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

    
        form {
            background: rgba(20, 20, 30, 0.85);
            padding: 35px;
            border-radius: 16px;
            border: 2px solid #00f2fe;
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.2),
                        inset 0 0 15px rgba(0, 242, 254, 0.1);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 360px;
            display: flex;
            flex-direction: column;
        }

  
        label {
            font-size: 14px;
            font-weight: bold;
            color: #00f2fe;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

   
        input[type="text"],
        input[type="number"],
        input[type="time"] {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 242, 254, 0.4);
            border-radius: 8px;
            padding: 12px;
            color: #fff;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none;
            transition: all 0.3s ease;
        }

 
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="time"]:focus {
            border-color: #00f2fe;
            box-shadow: 0 0 12px rgba(0, 242, 254, 0.6);
            background: rgba(255, 255, 255, 0.1);
        }

     
        input[type="submit"] {
            background: transparent;
            color: #ff007f;
            border: 2px solid #ff007f;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 10px;
            box-shadow: 0 0 10px rgba(255, 0, 127, 0.2);
        }

    
        input[type="submit"]:hover {
            background: #ff007f;
            color: #0d0d13;
            box-shadow: 0 0 25px #ff007f, 
                        0 0 50px rgba(255, 0, 127, 0.5);
        }

      
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1) sepia(1) saturate(5) hue-rotate(145deg);
            cursor: pointer;
        }

        
  .btn {
    display: inline-block;
    padding: 12px 24px;
    font-size: 16px;
    font-family: Arial, sans-serif;
    font-weight: bold;
    text-decoration: none;
    text-transform: uppercase;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
  }


  .btn-voltar {
    color: #ffffff;
    background-color: #6c757d; 
  }

 
  .btn-voltar:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }

  .btn-voltar:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }


 
   #estilo {
     width: 100%;
     max-width: 300px;
     padding: 12px;
     font-size: 16px;
     background-color: #121212; 
     color: #ffffff;
     border: 2px solid #00f3ff; 
     border-radius: 8px;
     cursor: pointer;
     outline: none;
     transition: all 0.3s ease-in-out;
     box-shadow: 0 0 10px rgba(0, 243, 255, 0.2), 
     inset 0 0 5px rgba(0, 243, 255, 0.1);
   }


   #estilo:focus {
     border-color: #ff007f; 
     box-shadow: 0 0 20px #ff007f, 
     0 0 30px rgba(255, 0, 127, 0.6), 
     inset 0 0 10px rgba(255, 0, 127, 0.4);
   }


    #estilo option {
      background-color: #1a1a1a;
      color: #ffffff;
    }

    label[for="estilo"] {
      display: block;
      color: #00f3ff;
      font-family: sans-serif;
      font-weight: bold;
      margin-bottom: 8px;
      text-shadow: 0 0 8px rgba(0, 243, 255, 0.6);
     }




    </style>
</head>
<body>
    
   <a href="../index.html" class="btn btn-voltar">VOLTAR</a>
   <h1>Adicionar Músicas</h1>

    <form method="POST">

        <label for="nome_musica">Nome da Musica</label>
        <input type="text" name="nome_musica" id="nome_musica" required>
    <br><br>
        <label for="nome_cantor">Nome do Cantor</label>
        <input type="text" name="nome_cantor" id="nome_cantor" required>
    <br>
       <label for="tempo_duracao">Duração da Música</label>
      <input type="time" id="tempo_duracao" name="tempo_duracao" step="1" value="00:00:00">
    </div>

    <br>
        <label for="faixa_etaria">Faixa etária</label>
        <input type="number" name="faixa_etaria" id="faixa_etaria" required>
    <br><br>
      <label for="estilo">Selecione o Estilo de Música:</label>
      <select name="estilo_musica" id="estilo" required>
      <option value="" disabled selected>Escolha um estilo...</option>
      <option value="Rock">Rock</option>
      <option value="Pop">Pop</option>
      <option value="Sertanejo">Sertanejo</option>
      <option value="Funk">Funk</option>
      <option value="Eletrônica">Eletrônica</option>
      <option value="MPB">MPB</option>
      <option value="Rap/Hip-Hop">Rap/Hip-Hop</option>
      <option value="Jazz/Blues">Jazz/Blues</option>
</select>
    <br><br>

    <input type="submit" value="Adicionar Música">
    </form>
</body>
</html>