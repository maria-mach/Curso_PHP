(function () {
    const laboratorio = document.querySelector('[data-week3-demo]');

    if (laboratorio === null) {
        return;
    }

    const saida = laboratorio.querySelector('[data-git-output]');
    const etapa = laboratorio.querySelector('[data-git-stage]');
    const botoes = laboratorio.querySelectorAll('[data-git-command]');
    const reiniciar = laboratorio.querySelector('[data-git-reset]');
    let estado = 0;

    const comandos = {
        init: {
            minimo: 0,
            proximo: 1,
            mensagem: 'Repositório Git iniciado. Agora use git status para observar os arquivos.',
            etapa: 'Etapa atual: repositório iniciado.'
        },
        status: {
            minimo: 1,
            proximo: 2,
            mensagem: 'index.php aparece como arquivo novo. Use git add . para prepará-lo.',
            etapa: 'Etapa atual: mudanças identificadas.'
        },
        add: {
            minimo: 2,
            proximo: 3,
            mensagem: 'Alterações adicionadas à área de preparação. O próximo passo é criar um commit.',
            etapa: 'Etapa atual: mudanças preparadas.'
        },
        commit: {
            minimo: 3,
            proximo: 4,
            mensagem: 'Commit criado no histórico local. Agora ele pode ser enviado ao repositório remoto.',
            etapa: 'Etapa atual: versão registrada localmente.'
        },
        push: {
            minimo: 4,
            proximo: 5,
            mensagem: 'Commits enviados ao repositório remoto com git push.',
            etapa: 'Etapa atual: histórico local publicado.'
        }
    };

    function executarComando(nome) {
        const comando = comandos[nome];

        if (estado < comando.minimo) {
            saida.textContent = 'Esse comando depende de uma etapa anterior. Siga o fluxo indicado.';
            return;
        }

        if (estado > comando.minimo) {
            saida.textContent = 'Essa etapa já foi concluída. Continue com o próximo comando.';
            return;
        }

        estado = comando.proximo;
        saida.textContent = comando.mensagem;
        etapa.textContent = comando.etapa;
    }

    botoes.forEach(function (botao) {
        botao.addEventListener('click', function () {
            executarComando(botao.dataset.gitCommand);
        });
    });

    reiniciar.addEventListener('click', function () {
        estado = 0;
        saida.innerHTML = 'Comece com <code>git init</code>.';
        etapa.textContent = 'Etapa atual: pasta comum.';
    });
}());
