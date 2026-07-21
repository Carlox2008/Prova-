<?php
include("../conexao.php");

$query = "SELECT 
            m.id AS musicas_id, 
            m.nome_musica, 
            m.nome_cantor, 
            m.tempo_duracao, 
            c.faixa_etaria, 
            c.estilo_musica 
          FROM musicas m 
          INNER JOIN galeria g ON m.id = g.musicas_id
          INNER JOIN catalogo_musica c ON g.catalogo_id = c.id";

$resultado = $con->query($query);

if (!$resultado) {
    die("Erro na consulta: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Músicas</title>
    <style>
       
        body {
            background-color: #0d0d13;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            box-sizing: border-box;
        }

       
        h1 {
            color: #fff;
            text-shadow: 0 0 10px #ff007f, 0 0 20px #ff007f;
            margin-bottom: 30px;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

    
        table {
            background: rgba(20, 20, 30, 0.85);
            border-collapse: collapse;
            width: 100%;
            max-width: 1000px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #00f2fe;
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.2);
            backdrop-filter: blur(10px);
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

      
        thead {
            background: rgba(0, 242, 254, 0.1);
            border-bottom: 2px solid #00f2fe;
        }

        th {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #00f2fe;
            text-shadow: 0 0 5px rgba(0, 242, 254, 0.4);
        }

       
        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.3s;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        td {
            font-size: 15px;
            color: #e0e0e0;
        }

        
        .action-btn {
            text-decoration: none;
            font-size: 18px;
            margin: 0 5px;
            display: inline-block;
            transition: transform 0.2s, text-shadow 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.2);
        }

        .btn-edit:hover {
            text-shadow: 0 0 8px #00f2fe;
        }

        .btn-delete:hover {
            text-shadow: 0 0 8px #ff007f;
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


    </style>
</head>
<body>

    <a href="../index.html" class="btn btn-voltar">VOLTAR</a>
    <h1>Listagem de Músicas</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da música</th>
                <th>Nome do cantor</th>
                <th>Duração</th>
                <th>Faixa etária</th>
                <th>Estilo da música</th>
                <th style="width: 100px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($musicas = $resultado->fetch_assoc()){ ?>
            <tr>
                <td><?= htmlspecialchars($musicas['musicas_id']) ?></td>
                <td><?= htmlspecialchars($musicas['nome_musica']) ?></td> 
                <td><?= htmlspecialchars($musicas['nome_cantor']) ?></td>
                <td><?= htmlspecialchars($musicas['tempo_duracao']) ?></td>
                <td><?= htmlspecialchars($musicas['faixa_etaria']) ?> anos</td>
                <td><?= htmlspecialchars($musicas['estilo_musica']) ?></td>
                <td>
                    <a href="editar_musicas.php?id=<?= urlencode($musicas['musicas_id']) ?>" class="action-btn btn-edit" title="Editar">✏️</a>
                    <a href="excluir_musicas.php?id=<?= urlencode($musicas['musicas_id']) ?>" class="action-btn btn-delete" title="Excluir">🗑️</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
