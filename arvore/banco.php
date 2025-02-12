<?php
// Nome do arquivo onde as árvores são armazenadas
$filename = 'trees.json'; // Alterado de 'arvores.json' para 'trees.json'
$treeData = null;

if (isset($_GET['treeId'])) {
    $treeId = $_GET['treeId'];

    // Carrega as árvores do arquivo
    if (file_exists($filename)) {
        $trees = json_decode(file_get_contents($filename), true);

        // Verifica se a árvore com o ID existe
        if (isset($trees[$treeId])) {
            $treeData = $trees[$treeId];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Árvores Genealógicas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .tree-list {
            list-style-type: none;
            padding: 0;
        }

        .tree-list li {
            margin: 10px 0;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: background-color 0.3s ease;
        }

        .tree-list li:hover {
            background-color: #e0e0e0;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            padding-top: 50px;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        #tree-container {
            width: 100%;
            height: 400px;
            overflow: auto;
            white-space: nowrap;
            background-color: #f4f4f4;
            border-radius: 8px;
            padding: 20px;
        }

        #tree {
            display: flex;
            flex-wrap: nowrap;
            position: relative;
        }

        /* Estilos dos cards, conforme já criado na outra página */
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            background-color: #fff;
            position: relative;
            min-width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Outros estilos necessários */
    </style>
</head>
<body>
    <h1>Banco de Árvores Genealógicas</h1>

    <ul class="tree-list">
        <?php
        $arvores = json_decode(file_get_contents('arvores.json'), true);
        if ($arvores) {
            foreach ($arvores as $index => $arvore) {
                echo "<li data-index='$index'>Árvore {$index}</li>";
            }
        } else {
            echo "<li>Nenhuma árvore salva</li>";
        }
        ?>
    </ul>

    <div id="treeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Árvore Genealógica</h2>
            <div id="tree-container">
                <div id="tree"></div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("treeModal");
        const span = document.getElementsByClassName("close")[0];
        const treeContainer = document.getElementById("tree");

        document.querySelectorAll('.tree-list li').forEach(item => {
            item.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                loadTree(index);
                modal.style.display = "block";
            });
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function loadTree(index) {
            fetch('arvores.json')
                .then(response => response.json())
                .then(data => {
                    const treeData = data[index];
                    treeContainer.innerHTML = ''; // Clear the tree container

                    function addCard(name, birthDate, deathDate, imageUrl, children, spouses) {
                        const cardContainer = document.createElement('div');
                        cardContainer.className = 'card-container';

                        const card = document.createElement('div');
                        card.className = 'card';
                        card.innerHTML = `
                            <img src="${imageUrl}" alt="Foto">
                            <input type="text" value="${name}" placeholder="Nome">
                            <input type="text" value="${birthDate}" placeholder="Data de Nascimento">
                            <input type="text" value="${deathDate}" placeholder="Data de Falecimento">
                        `;

                        cardContainer.appendChild(card);

                        const childContainer = document.createElement('div');
                        childContainer.className = 'child-container';
                        cardContainer.appendChild(childContainer);

                        treeContainer.appendChild(cardContainer);

                        if (children) {
                            children.forEach(child => addCard(child.name, child.birthDate, child.deathDate, child.imageUrl, child.children, child.spouses));
                        }

                        if (spouses) {
                            spouses.forEach(spouse => addCard(spouse.name, spouse.birthDate, spouse.deathDate, spouse.imageUrl, spouse.children, spouse.spouses));
                        }
                    }

                    addCard(treeData.name, treeData.birthDate, treeData.deathDate, treeData.imageUrl, treeData.children, treeData.spouses);
                });
        }
    </script>
</body>
</html>
