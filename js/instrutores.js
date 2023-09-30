class Instrutor {
    constructor(nome, cpf, email) {
        this.nome = nome;
        this.cpf = cpf;
        this.email = email;
    }
  }

  class ListaDeInstrutores {
    constructor() {
        this.instrutor = [];
    }
  
    adicionarInstrutor(instrutor) {
        this.instrutor.push(instrutor);
    }
  
    editarInstrutor(index, novoInstrutor) {
        this.instrutor[index] = novoInstrutor;
    }
  
    removerInstrutor(index) {
        this.instrutor.splice(index, 1);
    }
  }
  
  const listaInstrutor = new ListaDeInstrutores();
  
  
  function adicionarInstrutor() {
    const nome = document.getElementById('nome').value;
    const cpf = parseInt(document.getElementById('cpf').value);
    const email = document.getElementById('email').value;
  
    const novoInstrutor = new Instrutor(nome, cpf, email);
    listaInstrutor.adicionarInstrutor(novoInstrutor);
  
    document.getElementById('nome').value = '';
    document.getElementById('cpf').value = '';
    document.getElementById('email').value = '';
  
    exibirInstrutor();
  }
  
  function exibirInstrutor() {
    const listaInstrutorElement = document.getElementById('lista-instrutores');
    listaInstrutorElement.innerHTML = '';
  
    listaInstrutor.instrutor.forEach((instrutor, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${instrutor.nome}</td>
        <td>${instrutor.cpf}</td>
        <td>${instrutor.email}</td>
        <td>
          <button onclick="editarInstrutor(${index})">Editar</button>
          <button onclick="removerInstrutor(${index})">Remover</button>
        </td>
        `;
  
        listaInstrutorElement.appendChild(tr);
    });
  }
  
  function editarInstrutor(index) {
    const instrutor = listaInstrutor.instrutor[index];
    document.getElementById('nome').value = instrutor.nome;
    document.getElementById('cpf').value = instrutor.cpf;
    document.getElementById('email').value = instrutor.email;
  
    
    listaInstrutor.removerInstrutor(index);
  
    
    exibirInstrutor();
  }
  
  function removerInstrutor(index) {
    listaInstrutor.removerInstrutor(index);
  
  
    exibirInstrutor();
  }
  
  exibirInstrutor();
  
  
  