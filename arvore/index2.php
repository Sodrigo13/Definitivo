<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Atacadinho Livre</title>
</head>
<body>
<h1 class="page-title">ATACADINHO LIVRE</h1>

<div class="container-flex">
    <div class="container">
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" class="input-field">
        </div>

        <div class="form-group">
            <label for="v-unitario">V. Unitário</label>
            <input type="text" id="v-unitario" class="input-field">
        </div>

        <div class="form-group">
            <label for="total-item">Total do Item</label>
            <input type="text" id="total-item" class="input-field" readonly>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" class="input-field">
        </div>
    </div>

    <div class="product-list-container">
        <h2>LISTA DE PRODUTOS</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Seq.</th>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quant.</th>
                    <th>UN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="product-list">
             


            
            </tbody>
        </table>
    </div>
</div>

<div class="container-flex-summary">
    <div class="form-group-small">
        <label for="quantidade">Quantidade</label>
        <input type="text" id="quantidade" class="input-field">
    </div>

    <div class="total-container">
        <div class="currency-container">
            <span>TOTAL:</span>
            <input type="text" id="total-geral" class="input-field-currency" placeholder="R$" readonly>
        </div>
    </div>

    <button class="finalize-button" id="finalize-btn">FINALIZAR</button>
</div>

<div class="layout">
    <div class="section-botoes">
        <div class="botao1" id="btnF2" tabindex="0">F2 - PRODUTOS</div>
        <div class="botao-group">
            <div class="botao2" id="btnF3" tabindex="0">F3 - CAIXA</div>
            <div class="botao3" id="btnF4" tabindex="0">F4 - CANCELAR</div>
        </div>
        <div class="botao4" id="btnF5" tabindex="0">F5 - RELATÓRIOS</div>
    </div>

    <div class="section-caixa">
        <div class="titulo-caixa">RECEBIDO</div>
        <div class="caixa"></div>
    </div>

    <div class="section-caixa">
        <div class="titulo-caixa">TROCO</div>
        <div class="caixa"></div>
    </div>
</div>

<script>
    const productListTable = document.getElementById('product-list');
    let sequenceNumber = 1;

    document.getElementById('finalize-btn').addEventListener('click', function() {
        const codigo = document.getElementById('codigo').value;
        const descricao = document.getElementById('descricao').value;
        const vUnitario = parseFloat(document.getElementById('v-unitario').value);
        const quantidade = parseFloat(document.getElementById('quantidade').value);
        const totalItem = parseFloat(document.getElementById('total-item').value);

        if (codigo && descricao && !isNaN(vUnitario) && !isNaN(quantidade) && !isNaN(totalItem)) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${sequenceNumber++}</td>
                <td>${codigo}</td>
                <td>${descricao}</td>
                <td>${vUnitario.toFixed(2)}</td>
                <td>${quantidade}</td>
                <td>UN</td>
                <td>${totalItem.toFixed(2)}</td>
            `;
            productListTable.appendChild(newRow);

            // Clear fields
            document.getElementById('codigo').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('v-unitario').value = '';
            document.getElementById('quantidade').value = '';
            document.getElementById('total-item').value = '';
            document.getElementById('total-geral').value = '';
        } else {
            alert('Por favor, preencha todos os campos corretamente.');
        }
    });

    document.getElementById('codigo').addEventListener('input', function() {
        const codigo = this.value;

        if (productList[codigo]) {
            document.getElementById('descricao').value = productList[codigo].descricao;
            document.getElementById('v-unitario').value = productList[codigo].preco.toFixed(2);
            calcularTotal();
        } else {
            document.getElementById('descricao').value = '';
            document.getElementById('v-unitario').value = '';
            document.getElementById('total-item').value = '';
        }
    });

    document.getElementById('quantidade').addEventListener('input', calcularTotal);

    function calcularTotal() {
        const quantidade = parseFloat(document.getElementById('quantidade').value);
        const precoUnitario = parseFloat(document.getElementById('v-unitario').value);

        if (!isNaN(quantidade) && !isNaN(precoUnitario)) {
            const total = (quantidade * precoUnitario).toFixed(2);
            document.getElementById('total-item').value = total;
            document.getElementById('total-geral').value = total;
        } else {
            document.getElementById('total-item').value = '';
            document.getElementById('total-geral').value = '';
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'F2') {
            document.getElementById('btnF2').click();
        } else if (event.key === 'F3') {
            document.getElementById('btnF3').click();
        } else if (event.key === 'F4') {
            document.getElementById('btnF4').click();
        } else if (event.key === 'F5') {
            document.getElementById('btnF5').click();
        }
    });

    document.getElementById('btnF2').addEventListener('click', function() {
        alert('Produtos');
    });

    document.getElementById('btnF3').addEventListener('click', function() {
        alert('Caixa');
    });

    document.getElementById('btnF4').addEventListener('click', function() {
        alert('Cancelar');
    });

    document.getElementById('btnF5').addEventListener('click', function() {
        alert('Relatórios');
    });
</script>
</body>
</html>