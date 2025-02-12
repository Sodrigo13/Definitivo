<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Árvore Genealógica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .tree-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            max-width: 100%;
            max-height: 80vh;
            overflow: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .generation {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin-bottom: 50px;
            width: 100%;
        }

        .couple {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            align-items: flex-start;
        }

        .couple .card {
            margin: 0 15px;
            width: 18rem;
            background-color: white;
            transition: width 0.3s ease; /* Suavizar a mudança de tamanho */
        }

        .card-img-top {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto;
        }

        .editable {
            cursor: pointer;
        }

        .add-card-btn,
        .delete-card-btn,
        .add-descendant-btn {
            position: absolute;
            cursor: pointer;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .add-card-btn {
            background-color: #007bff;
            bottom: 10px;
            right: 10px;
        }

        .add-descendant-btn {
            background-color: #28a745;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .delete-card-btn {
            background-color: #dc3545;
            top: 10px;
            right: 10px;
        }

        .line {
            position: absolute;
            background-color: #000;
            z-index: 1;
        }

        .horizontal-line {
            height: 2px;
        }

        .vertical-line {
            width: 2px;
        }

        .children-container,
        .descendant-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: row;
            margin-top: 20px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="tree-container">
        <button class="btn btn-primary" onclick="createFirstCard()">Criar Primeiro Card</button>
    </div>

    <script>
        function createFirstCard() {
            const treeContainer = document.querySelector('.tree-container');

            if (treeContainer.querySelector('.generation')) {
                alert('O primeiro card já foi criado.');
                return;
            }

            const generation = document.createElement('div');
            generation.classList.add('generation');

            const couple = document.createElement('div');
            couple.classList.add('couple');

            const newCard = createCard('Primeiro Familiar', 'Descrição do Primeiro Familiar.');
            couple.appendChild(newCard);
            generation.appendChild(couple);
            treeContainer.appendChild(generation);

            updateCardNumbers();
            updateLines();
            adjustCardSizes();
        }

        function createCard(title, text) {
            const newCard = document.createElement('div');
            newCard.classList.add('card');
            newCard.innerHTML = `
                <img src="https://via.placeholder.com/100" class="card-img-top" alt="${title}">
                <div class="card-body">
                    <h5 class="card-title editable" contenteditable="true">${title}</h5>
                    <p class="card-text editable" contenteditable="true">${text}</p>
                    <p class="card-number">Card</p>
                    <button class="add-card-btn" onclick="addSpouse(this)">+</button>
                    <button class="delete-card-btn" onclick="deleteCard(this)">×</button>
                    <button class="add-descendant-btn" onclick="addDescendant(this)">+</button>
                </div>
            `;
            return newCard;
        }

        function addSpouse(button) {
            const card = button.closest('.card');
            let coupleContainer = card.closest('.couple');

            if (!coupleContainer) {
                coupleContainer = document.createElement('div');
                coupleContainer.classList.add('couple');
                card.parentNode.insertBefore(coupleContainer, card);
                coupleContainer.appendChild(card);
            }

            const existingSpouse = coupleContainer.querySelector('.card[data-type="conjuge"]');
            if (existingSpouse) {
                alert('Este familiar já tem um cônjuge.');
                return;
            }

            const newCard = createCard('Cônjuge', 'Descrição do Cônjuge');
            newCard.dataset.type = 'conjuge';
            coupleContainer.appendChild(newCard);

            updateCardNumbers();
            updateLines();
            adjustCardSizes();
        }

        function addDescendant(button) {
            const card = button.closest('.card');
            const coupleContainer = card.closest('.couple');
            const parentContainer = coupleContainer.parentElement;

            let descendantContainer = parentContainer.querySelector('.descendant-container');
            if (!descendantContainer) {
                descendantContainer = document.createElement('div');
                descendantContainer.classList.add('descendant-container');
                parentContainer.appendChild(descendantContainer);
            }

            const newCard = createCard('Novo Descendente', 'Descrição do Descendente');
            descendantContainer.appendChild(newCard);

            updateCardNumbers();
            updateLines();
            adjustCardSizes();
        }

        function deleteCard(button) {
            const card = button.closest('.card');
            card.remove();
            updateCardNumbers();
            updateLines();
            adjustCardSizes();
        }

        function updateCardNumbers() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                const cardNumber = card.querySelector('.card-number');
                if (cardNumber) {
                    cardNumber.textContent = `Card ${index + 1}`;
                }
            });
        }

        function updateLines() {
            document.querySelectorAll('.line').forEach(line => line.remove());

            document.querySelectorAll('.generation').forEach(container => {
                const descendantContainer = container.querySelector('.descendant-container');

                if (descendantContainer) {
                    const children = Array.from(descendantContainer.querySelectorAll('.card'));
                    const parentCouple = container.querySelector('.couple');

                    if (children.length > 0 && parentCouple) {
                        const parentRect = parentCouple.getBoundingClientRect();
                        const firstChildRect = children[0].getBoundingClientRect();
                        const lastChildRect = children[children.length - 1].getBoundingClientRect();

                        const vLine = document.createElement('div');
                        vLine.classList.add('line', 'vertical-line');
                        vLine.style.height = `${firstChildRect.top - parentRect.bottom}px`;
                        vLine.style.top = `${parentRect.bottom}px`;
                        vLine.style.left = `${parentRect.left + parentRect.width / 2}px`;
                        document.body.appendChild(vLine);

                        if (children.length > 1) {
                            const hLine = document.createElement('div');
                            hLine.classList.add('line', 'horizontal-line');
                            hLine.style.width = `${lastChildRect.right - firstChildRect.left}px`;
                            hLine.style.top = `${firstChildRect.top}px`;
                            hLine.style.left = `${firstChildRect.left}px`;
                            document.body.appendChild(hLine);
                        }
                    }
                }
            });
        }

        function adjustCardSizes() {
            const cards = document.querySelectorAll('.card');
            const totalCards = cards.length;

            const minWidth = 150; // Largura mínima dos cards
            const baseWidth = 18 * 16; // Largura base dos cards (em pixels)
            const newWidth = Math.max(minWidth, baseWidth * 0.5 / Math.sqrt(totalCards));

            cards.forEach(card => {
                card.style.width = `${newWidth}px`;
            });
        }

        window.addEventListener('load', updateLines);
        window.addEventListener('resize', () => {
            updateLines();
            adjustCardSizes();
        });
    </script>
</body>

</html>
