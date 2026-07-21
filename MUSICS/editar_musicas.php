<?php
   include("../conexao.php");

   $id = $_GET['id'] ?? $_POST['id'] ?? 0;

   if(isset($_POST['atualizar'])){
    $nome_musica  = $_POST['nome_musica'];
    $nome_cantor  = $_POST['nome_cantor'];
    $tempo_duracao = $_POST['tempo_duracao'];
    $faixa_etaria  = $_POST['faixa_etaria'];
    $estilo_musica = $_POST['estilo_musica'];

    $update_musicas = $con->prepare("UPDATE musicas SET nome_musica=?, nome_cantor=?, tempo_duracao=? WHERE id=?"); 
    $update_musicas->bind_param("sssi", $nome_musica, $nome_cantor, $tempo_duracao, $id); 
    $update_musicas->execute(); 

    $update_cat = $con->prepare("UPDATE catalogo_musica SET faixa_etaria=?, estilo_musica=? WHERE id=?"); 
    $update_cat->bind_param("isi", $faixa_etaria, $estilo_musica, $id); 
    $update_cat->execute(); 
    
   
    header("Location: listarM.php"); 
    exit();
   }
   
   $stmt_musicas = $con->prepare("SELECT * FROM musicas WHERE id = ?"); 
   $stmt_musicas->bind_param("i", $id); 
   $stmt_musicas->execute(); 
   $resultado_musicas = $stmt_musicas->get_result(); 
   $musicas = $resultado_musicas->fetch_assoc(); 

   $stmt_cat = $con->prepare("SELECT * FROM catalogo_musica WHERE id = ?"); 
   $stmt_cat->bind_param("i", $id); 
   $stmt_cat->execute(); 
   $resultado_cat = $stmt_cat->get_result(); 
   $catalogo_musica = $resultado_cat->fetch_assoc(); 

   $query = $con->query("SELECT id, faixa_etaria, estilo_musica FROM catalogo_musica");
   

   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Músicas</title>
        <style>
 
        body {
            background-color: #0d0d13;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
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

        .secao-titulo {
            color: #fff;
            text-shadow: 0 0 10px #00f2fe, 0 0 20px #00f2fe;
            margin-bottom: 25px;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            font-weight: bold;
            display: block;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
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

        button[type="submit"] {
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

        
        button[type="submit"]:hover {
            background: #ff007f;
            color: #0d0d13;
            box-shadow: 0 0 25px #ff007f, 
                        0 0 50px rgba(255, 0, 127, 0.5);
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1) sepia(1) saturate(5) hue-rotate(145deg);
            cursor: pointer;
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
    <form method="POST"> 
       
        <input type="hidden" name="id" value="<?=$id?>">

        <span class="secao-titulo">ATUALIZAR</span>
        
        <div class="form-group">
            <label>Nome da música</label>
            <input type="text" name="nome_musica" value="<?=$musicas['nome_musica'] ?? ''?>" required>
        </div>

        <div class="form-group">
            <label>Nome do cantor</label>
            <input type="text" name="nome_cantor" value="<?=$musicas['nome_cantor'] ?? ''?>" required>
        </div>

        <div class="form-group">
            <label>Duração</label>
            <input type="time" name="tempo_duracao" value="<?=$musicas['tempo_duracao'] ?? ''?>" step="1" value="00:00:00" required>
        </div>

        <div class="form-group">
            <label>Faixa Etária</label>
            <input type="number" name="faixa_etaria" value="<?=$catalogo_musica['faixa_etaria'] ?? ''?>" required>
        </div>
          
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

          
           <button name="atualizar" type="submit">atualizar Música</button> 
        
        </form>
</body>
</html>