<?php
// Nome do arquivo onde as árvores são armazenadas
$filename = 'trees.json';
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
    <title>Árvore Genealógica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        #tree-container {
            width: 80%;
            height: 80%;
            overflow: auto;
            white-space: nowrap; /* Impede a quebra de linha e permite rolagem horizontal */
        }

        #tree {
            display: flex;
            flex-wrap: nowrap; /* Impede que os cards quebrem para a linha de baixo */
            position: relative;
        }

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

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .card .crown {
            display: none;
            position: absolute;
            left: -20px;
            top: 0;
            width: 30px;
            height: 30px;
            background: url('https://upload.wikimedia.org/wikipedia/commons/6/6a/Gold_Crown.png') no-repeat center center;
            background-size: contain;
        }

        .card input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            text-align: center;
            margin: 5px 0;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 10px;
        }

        .button-container button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .add-spouse {
            background-color: #4CAF50; /* Verde */
        }

        .add-child {
            background-color: #2196F3; /* Azul */
        }

        .delete {
            background-color: #f44336; /* Vermelho */
        }


        .child-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
            width: 100%;
        }

        .child-container .card {
            margin-left: 0;
            margin-top: 0;
        }

        .card-container {
            display: flex;
            flex-direction: column; /* Coloca o card principal em coluna */
            align-items: center;
            position: relative;
        }

        .card-container .spouse-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap; /* Garante que os cônjuges fiquem lado a lado */
        }

        .card-container .child-container {
            display: flex;
            flex-wrap: nowrap; /* Garante que os irmãos fiquem lado a lado */
            margin-top: 20px;
            width: 100%;
        }

        .card.deceased {
            background-color: #6c757d; /* Cinza escuro */
            color: #fff; /* Texto branco para contraste */
        }

        .button-vertical {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }


        /* Estilos para os botões */
        .button-vertical button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .mark-deceased {
            background-color: #6c757d; /* Cinza */
        }

        .mark-crowned {
            background-color: #FFD700; /* Dourado */
        }

        .upload-button {
            background-color: #007bff; /* Azul para o botão de upload de imagem */
        }

        .crown {
            display: none;
            position: absolute;
            left: -20px;
            top: 0;
            width: 30px;
            height: 30px;
            background: url('https://upload.wikimedia.org/wikipedia/commons/6/6a/Gold_Crown.png') no-repeat center center;
             background-size: contain;
        }
    </style>
</head>
<body>
    <div id="tree-container">
        <button id="add-person">Adicionar Pessoa</button>
        <button id="save-tree">Salvar Árvore</button>
       

        




     







        <form id="tree-form" action="banco.php" method="POST" style="display: none;">
            <input type="hidden" name="treeData" id="treeData">
    </form>
        
    </div>

    <script>
         document.addEventListener('DOMContentLoaded', () => {
            const treeContainer = document.getElementById('tree');
            const addPersonButton = document.getElementById('add-person');
            const saveTreeButton = document.getElementById('save-tree');
            const treeForm = document.getElementById('tree-form');
            const treeDataInput = document.getElementById('treeData');

            addPersonButton.addEventListener('click', () => {
                addCard();
            });

            saveTreeButton.addEventListener('click', () => {
                const treeData = buildTreeData(treeContainer);
                treeDataInput.value = JSON.stringify(treeData);
                treeForm.submit();
            
            });

            function addCard(name = '', birthDate = '', deathDate = '', imageUrl = '', children = [], spouses = []) {
                const cardContainer = document.createElement('div');
                cardContainer.className = 'card-container';

                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <img src="${imageUrl}" alt="Foto">
                    <div class="button-vertical">
                        <button class="upload-button">📷</button>
                        <button class="mark-deceased">⚰️</button>
                        <button class="mark-crowned">👑</button>
                        <input type="file" class="file-input" style="display:none;" />
                    </div>
                    <div class="crown"></div>
                    <input type="text" value="${name}" placeholder="Nome">
                    <input type="text" value="${birthDate}" placeholder="Data de Nascimento">
                    <input type="text" value="${deathDate}" placeholder="Data de Falecimento">
                    <div class="button-container">
                        <button class="add-spouse">+</button>
                        <button class="add-child">+</button>
                        <button class="delete">×</button>
                    </div>
                `;

                const uploadButton = card.querySelector('.upload-button');
                const fileInput = card.querySelector('.file-input');
                uploadButton.addEventListener('click', () => fileInput.click());
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            card.querySelector('img').src = e.target.result;
                            saveTree();
                        };
                        reader.readAsDataURL(file);
                    }
                });

                const markDeceasedButton = card.querySelector('.mark-deceased');
                markDeceasedButton.addEventListener('click', () => {
                    card.classList.toggle('deceased');
                    saveTree();
                });

                const markCrownedButton = card.querySelector('.mark-crowned');
                markCrownedButton.addEventListener('click', () => {
                    const crown = card.querySelector('.crown');
                    crown.style.display = crown.style.display === 'block' ? 'none' : 'block';
                    saveTree();
                });

                card.querySelector('.add-spouse').addEventListener('click', () => addSpouse(cardContainer));
                card.querySelector('.add-child').addEventListener('click', () => addChild(cardContainer));
                card.querySelector('.delete').addEventListener('click', () => {
                    cardContainer.remove();
                    saveTree();
                });

                cardContainer.appendChild(card);

                const spouseContainer = document.createElement('div');
                spouseContainer.className = 'spouse-container';
                cardContainer.appendChild(spouseContainer);

                const childContainer = document.createElement('div');
                childContainer.className = 'child-container';
                cardContainer.appendChild(childContainer);

                treeContainer.appendChild(cardContainer);

                // Add children
                children.forEach(child => addCard(child.name, child.birthDate, child.deathDate, child.imageUrl, child.children, child.spouses));
                
                // Add spouses
                spouses.forEach(spouse => addCard(spouse.name, spouse.birthDate, spouse.deathDate, spouse.imageUrl, spouse.children, spouse.spouses));

                saveTree();
            }



            function addSpouse(cardContainer) {
                const spouseContainer = cardContainer.querySelector('.spouse-container') || document.createElement('div');
                spouseContainer.className = 'spouse-container';
                cardContainer.appendChild(spouseContainer);

                const spouseCard = document.createElement('div');
                spouseCard.className = 'card';
                spouseCard.innerHTML = `
                    <img src="" alt="Foto">
                    <div class="crown"></div>
                    <button class="upload-button">📷</button>
                    <button class="mark-deceased">⚰️</button>
                    <button class="mark-crowned">👑</button>
                    <input type="file" class="file-input" />
                    <input type="text" value="" placeholder="Nome do Cônjuge">
                    <input type="text" value="" placeholder="Data de Nascimento">
                    <input type="text" value="" placeholder="Data de Falecimento">
                    <div class="button-container">
                        <button class="add-child">+</button>
                        <button class="delete">×</button>
                    </div>
                `;

                const uploadButton = spouseCard.querySelector('.upload-button');
                const fileInput = spouseCard.querySelector('.file-input');
                uploadButton.addEventListener('click', () => fileInput.click());
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            spouseCard.querySelector('img').src = e.target.result;
                            saveTree();
                        };
                        reader.readAsDataURL(file);
                    }
                });

                const markDeceasedButton = spouseCard.querySelector('.mark-deceased');
                markDeceasedButton.addEventListener('click', () => {
                    spouseCard.classList.toggle('deceased');
                    saveTree();
                });

                const markCrownedButton = spouseCard.querySelector('.mark-crowned');
                markCrownedButton.addEventListener('click', () => {
                    const crown = spouseCard.querySelector('.crown');
                    crown.style.display = crown.style.display === 'block' ? 'none' : 'block';
                    saveTree();
                });

                spouseCard.querySelector('.add-child').addEventListener('click', () => addChild(spouseCard));
                spouseCard.querySelector('.delete').addEventListener('click', () => {
                    spouseCard.remove();
                    saveTree();
                });

                spouseContainer.appendChild(spouseCard);
                saveTree();
            }

            function addChild(parentCardContainer) {
                const childContainer = parentCardContainer.querySelector('.child-container') || document.createElement('div');
                childContainer.className = 'child-container';
                parentCardContainer.appendChild(childContainer);

                const childCard = document.createElement('div');
                childCard.className = 'card';
                childCard.innerHTML = `
                    <img src="" alt="Foto">
                    <div class="crown"></div>
                    <button class="upload-button">📷</button>
                    <button class="mark-deceased">⚰️</button>
                    <button class="mark-crowned">👑</button>
                    <input type="file" class="file-input" />
                    <input type="text" value="" placeholder="Nome do Filho">
                    <input type="text" value="" placeholder="Data de Nascimento">
                    <input type="text" value="" placeholder="Data de Falecimento">
                    <div class="button-container">
                        <button class="add-spouse">+</button>
                        <button class="delete">×</button>
                    </div>
                `;

                const uploadButton = childCard.querySelector('.upload-button');
                const fileInput = childCard.querySelector('.file-input');
                uploadButton.addEventListener('click', () => fileInput.click());
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            childCard.querySelector('img').src = e.target.result;
                            saveTree();
                        };
                        reader.readAsDataURL(file);
                    }
                });

                const markDeceasedButton = childCard.querySelector('.mark-deceased');
                markDeceasedButton.addEventListener('click', () => {
                    childCard.classList.toggle('deceased');
                    saveTree();
                });

                const markCrownedButton = childCard.querySelector('.mark-crowned');
                markCrownedButton.addEventListener('click', () => {
                    const crown = childCard.querySelector('.crown');
                    crown.style.display = crown.style.display === 'block' ? 'none' : 'block';
                    saveTree();
                });

                childCard.querySelector('.add-spouse').addEventListener('click', () => addSpouse(childCard));
                childCard.querySelector('.delete').addEventListener('click', () => {
                    childCard.remove();
                    saveTree();
                });

                childContainer.appendChild(childCard);
                saveTree();
            }

            function buildTreeData(container) {
                const treeData = [];
                container.querySelectorAll('.card-container').forEach(cardContainer => {
                    const card = cardContainer.querySelector('.card');
                    const name = card.querySelector('input[placeholder="Nome"]').value;
                    const birthDate = card.querySelector('input[placeholder="Data de Nascimento"]').value;
                    const deathDate = card.querySelector('input[placeholder="Data de Falecimento"]').value;
                    const imageUrl = card.querySelector('img').src;

                    const childrenData = buildTreeData(cardContainer.querySelector('.child-container'));
                    const spousesData = buildTreeData(cardContainer.querySelector('.spouse-container'));

                    treeData.push({
                        name,
                        birthDate,
                        deathDate,
                        imageUrl,
                        children: childrenData,
                        spouses: spousesData
                    });
                });
                return treeData;
            }


            function saveTree() {
                const treeContainer = document.getElementById('tree');
                const treeData = buildTreeData(treeContainer);
                treeDataInput.value = JSON.stringify(treeData);
            }


            // Carrega a árvore selecionada se disponível
            <?php if ($treeData) : ?>
                const treeData = <?= json_encode($treeData) ?>;
                treeData.forEach(data => addCard(data.name, data.birthDate, data.deathDate, data.imageUrl, data.children, data.spouses));
            <?php endif; ?>
        });
    </script>
</body>
