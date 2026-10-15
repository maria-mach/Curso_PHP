(function () {
    const laboratorio = document.querySelector('[data-week2-demo]');

    if (laboratorio === null) {
        return;
    }

    const totalSemanas = 8;
    const tecnologias = ['HTML', 'CSS', 'JavaScript'];
    const controleSemanas = laboratorio.querySelector('#demo-weeks');
    const valorSemanas = laboratorio.querySelector('#demo-weeks-value');
    const barraProgresso = laboratorio.querySelector('#demo-progress-bar');
    const textoProgresso = laboratorio.querySelector('#demo-progress-text');
    const listaTecnologias = laboratorio.querySelector('#demo-technologies');
    const formulario = laboratorio.querySelector('#demo-form');
    const campoNome = laboratorio.querySelector('#demo-name');
    const botaoDestaque = laboratorio.querySelector('#demo-highlight');
    const visualizacao = laboratorio.querySelector('#demo-preview');
    const statusEnvio = laboratorio.querySelector('#demo-submit-status');

    function calcularProgresso(concluidas, total) {
        return Math.round((concluidas / total) * 100);
    }

    function atualizarProgresso() {
        const concluidas = Number(controleSemanas.value);
        const percentual = calcularProgresso(concluidas, totalSemanas);
        let situacao = 'O curso ainda não foi iniciado.';

        if (concluidas === totalSemanas) {
            situacao = 'Todas as semanas foram concluídas.';
        } else if (concluidas > 0) {
            situacao = 'O curso está em andamento.';
        }

        valorSemanas.textContent = String(concluidas);
        barraProgresso.style.width = percentual + '%';
        textoProgresso.textContent = percentual + '% concluído. ' + situacao;
    }

    for (const tecnologia of tecnologias) {
        const item = document.createElement('span');
        item.textContent = tecnologia;
        listaTecnologias.appendChild(item);
    }

    controleSemanas.addEventListener('input', atualizarProgresso);

    campoNome.addEventListener('input', function () {
        const nome = campoNome.value.trim();
        visualizacao.textContent = nome === ''
            ? 'A mensagem será atualizada durante a digitação.'
            : 'Olá, ' + nome + '! Esta frase foi alterada com textContent.';
        statusEnvio.textContent = '';
    });

    botaoDestaque.addEventListener('click', function () {
        visualizacao.classList.toggle('is-highlighted');
    });

    formulario.addEventListener('submit', function (evento) {
        evento.preventDefault();

        if (campoNome.value.trim() === '') {
            statusEnvio.textContent = 'O envio padrão foi impedido. Digite um nome para continuar.';
            campoNome.focus();
            return;
        }

        statusEnvio.textContent = 'Exemplo validado sem recarregar a página.';
    });

    atualizarProgresso();
}());
