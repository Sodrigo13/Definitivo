<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #064f8f, #00f2fe, #f6613f);
            color: white;
        }
        h1, h2 {
            color: white;
        }
 
        .navbar {
            background-color: aqua;
        }
 
        .card {
            width: 18rem;
            border-radius: 15px;
            overflow: hidden;
        }
 
        .card img {
            height: 200px;
            object-fit: cover;
        }
 
        .d-flex > .card {
            flex-grow: 1;
            margin: 0 10px;
        }
       
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Skate de David Skatista</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img src="img/david.jpg" alt="Menu Icon" style="height: 30px; width: 70px;">
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Skate, Phone, Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#poemModal">Abra para um poema</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
 
<div class="modal fade" id="poemModal" tabindex="-1" aria-labelledby="poemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #064f8f;">
        <h5 class="modal-title" id="poemModalLabel">Poema</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: #f6613f;"></button>
      </div>
      <div class="modal-body" style="background-color: #f6613f;">
        <p>Um skate David queria ser</p>
        <p>Mas um Skate ele não pode ser</p>
        <p>Porque se um Skate David fosse</p>
        <p>Um skate David seria</p>
        <br>
        <p>Desconhecido, Autor</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#00f2fe">Fechar</button>
      </div>
    </div>
  </div>
</div>
 
<div class="container mt-5">
    <h1>Tipos de Skate</h1>
    <div class="d-flex justify-content-between">
        <div class="card">
            <img src="img/skate fogudo.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Esse é o skate foguinho. Ideal para todo mundo que tem foguinho por qualquer coisa.</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Escolho esse</button>
                </div>
            </div>
        </div>
        <div class="card">
            <img src="img/skate azul.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Esse é o skate aquático. Se você curte uma boa dose de afogamentos, esse é o ideal para você.</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Escolho esse</button>
                </div>
            </div>
        </div>
        <div class="card">
            <img src="img/skate amarelo.avif" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Esse é o skate Amalero. Esse só quem é feliz (Esse não serve para David) e muito ESPECIAL pode usar.</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Escolho esse</button>
                </div>
            </div>
        </div>
        <div class="card">
            <img src="img/fundo-pastel-rosa-azul-mini-skate-de-dedo_175682-32780.avif" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Esse é o skate benina benino benina. Feito para quem é benino benina benino e benina benino benina também.</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Escolho esse</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
 
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>








<tr>
                    <td>2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>