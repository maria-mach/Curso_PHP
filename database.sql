CREATE DATABASE IF NOT EXISTS fullstack_course CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fullstack_course;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  username VARCHAR(30) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('teacher','student') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE weeks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  week_no TINYINT NOT NULL UNIQUE,
  title VARCHAR(180) NOT NULL,
  summary VARCHAR(255) NOT NULL,
  content_html MEDIUMTEXT NOT NULL,
  video_url VARCHAR(500) NOT NULL DEFAULT '',
  is_released TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE quiz_questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  week_no TINYINT NOT NULL,
  question VARCHAR(500) NOT NULL,
  option_a VARCHAR(300) NOT NULL,
  option_b VARCHAR(300) NOT NULL,
  option_c VARCHAR(300) NOT NULL,
  option_d VARCHAR(300) NOT NULL,
  correct_option CHAR(1) NOT NULL,
  CONSTRAINT fk_quiz_week FOREIGN KEY (week_no) REFERENCES weeks(week_no) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE progress (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  week_no TINYINT NOT NULL,
  video_confirmed TINYINT(1) NOT NULL DEFAULT 0,
  quiz_score TINYINT NULL,
  completed TINYINT(1) NOT NULL DEFAULT 0,
  completed_at DATETIME NULL,
  UNIQUE KEY uq_progress (user_id, week_no),
  CONSTRAINT fk_progress_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_progress_week FOREIGN KEY (week_no) REFERENCES weeks(week_no) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users(name,username,password_hash,role) VALUES
('Professor Administrador','professor','$2y$12$3uchVd.wmBv0ap0q5xemMOqRb45/Py0Nmi7l3mlIXc7YBXET5.faa','teacher');

INSERT INTO weeks(week_no,title,summary,content_html) VALUES
(1,'HTML, CSS e introdução ao JavaScript','Estrutura de páginas, principais elementos HTML, primeiros estilos e visão geral do JavaScript.',
'<h3>Objetivo da semana</h3><p>Criar a primeira página do projeto integrador, organizar o conteúdo com HTML, aplicar uma estilização básica com CSS e entender o papel do JavaScript no desenvolvimento front-end.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>HTML: estrutura básica, principais elementos e organização do conteúdo; introdução ao CSS e JavaScript.</td><td>Integrante 1</td></tr><tr><td>Questionário</td><td>Conceitos básicos de HTML, CSS e JavaScript.</td><td>Integrante 2 e 3</td></tr><tr><td>Atividade prática</td><td>Criar a estrutura HTML de uma página e aplicar estilização básica com CSS.</td><td>Integrante 4 e 5</td></tr><tr><td>Exercício/desafio</td><td>Adicionar elementos e estilos à página, preparando a estrutura do projeto integrador.</td><td>Integrante 6</td></tr></tbody></table>'),
(2,'JavaScript: variáveis, operadores e eventos','Fundamentos de JavaScript, estruturas básicas e primeiros eventos sem trabalhar manipulação avançada da página.',
'<h3>Objetivo da semana</h3><p>Compreender variáveis, tipos de dados, operadores, condicionais, repetições e eventos simples em JavaScript, preparando o aluno para criar pequenas interações no projeto.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>JavaScript: variáveis, operadores, estruturas básicas e introdução a eventos simples.</td><td>Integrante 2</td></tr><tr><td>Questionário</td><td>JavaScript, variáveis, operadores, condicionais, repetições e eventos.</td><td>Integrante 1 e 4</td></tr><tr><td>Atividade prática</td><td>Criar pequenos scripts com variáveis, cálculos, comparações e mensagens de retorno.</td><td>Integrante 3 e 5</td></tr><tr><td>Exercício/desafio</td><td>Criar interações simples utilizando eventos como <code>click</code>, <code>input</code> ou <code>submit</code>.</td><td>Integrante 6</td></tr></tbody></table>'),
(3,'Git, GitHub e introdução ao PHP','Versionamento do projeto, publicação no GitHub e primeiros passos com PHP em ambiente local.',
'<h3>Objetivo da semana</h3><p>Organizar o projeto com Git, publicar o código no GitHub e iniciar o contato com PHP usando um ambiente local como o XAMPP.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>Git: conceitos, repositório, <code>init</code>, <code>status</code>, <code>add</code> e <code>commit</code>; GitHub: repositório remoto e <code>push</code>; introdução ao PHP e ambiente local.</td><td>Integrante 3</td></tr><tr><td>Questionário</td><td>Conceitos de Git, GitHub e fundamentos do PHP.</td><td>Integrante 1 e 5</td></tr><tr><td>Atividade prática</td><td>Criar um repositório Git, realizar commits e publicar o projeto no GitHub.</td><td>Integrante 2 e 6</td></tr><tr><td>Exercício/desafio</td><td>Configurar o ambiente PHP e executar o primeiro código PHP.</td><td>Integrante 4 e 5</td></tr></tbody></table>'),
(4,'Fundamentos do PHP e formulários','Variáveis, operadores, condicionais, repetições, arrays, funções e processamento inicial de formulários.',
'<h3>Objetivo da semana</h3><p>Aprender os fundamentos da linguagem PHP e criar os primeiros formulários processados pelo back-end.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>PHP: variáveis, tipos de dados, operadores, condicionais, repetições, arrays e funções; introdução a formulários.</td><td>Integrante 4</td></tr><tr><td>Questionário</td><td>Fundamentos da linguagem PHP e processamento de dados.</td><td>Integrante 2 e 6</td></tr><tr><td>Atividade prática</td><td>Criar scripts utilizando condições, repetições, arrays e funções.</td><td>Integrante 1 e 3</td></tr><tr><td>Exercício/desafio</td><td>Criar um formulário e processar os dados utilizando PHP.</td><td>Integrante 5 e 6</td></tr></tbody></table>'),
(5,'GET, POST, validação, sessões e MySQL','Envio de dados, validação, sessões e conceitos essenciais de banco de dados com MySQL.',
'<h3>Objetivo da semana</h3><p>Trabalhar envio de dados com GET e POST, validação básica, sessões e criação inicial de banco de dados e tabelas no MySQL.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>GET e POST, validação de dados, sessões e introdução ao MySQL: banco, tabelas, registros e chave primária.</td><td>Integrante 5</td></tr><tr><td>Questionário</td><td>GET/POST, validação, sessões e conceitos básicos de banco de dados.</td><td>Integrante 1 e 4</td></tr><tr><td>Atividade prática</td><td>Criar um banco de dados e suas tabelas utilizando MySQL.</td><td>Integrante 2 e 6</td></tr><tr><td>Exercício/desafio</td><td>Realizar operações <code>INSERT</code>, <code>SELECT</code>, <code>UPDATE</code> e <code>DELETE</code> diretamente no banco.</td><td>Integrante 3 e 5</td></tr></tbody></table>'),
(6,'PHP + MySQL e CRUD','Conexão da aplicação PHP ao banco e implementação das operações Create, Read, Update e Delete.',
'<h3>Objetivo da semana</h3><p>Conectar PHP ao MySQL e construir as primeiras funcionalidades de CRUD, começando por cadastro e consulta e avançando para edição e exclusão.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>Conexão PHP + MySQL e conceito de CRUD: Create, Read, Update e Delete.</td><td>Integrante 6</td></tr><tr><td>Questionário</td><td>Integração PHP + MySQL e funcionamento do CRUD.</td><td>Integrante 2 e 3</td></tr><tr><td>Atividade prática</td><td>Criar a conexão entre a aplicação PHP e o banco de dados e implementar cadastro e consulta.</td><td>Integrante 1 e 4</td></tr><tr><td>Exercício/desafio</td><td>Implementar edição e exclusão de registros.</td><td>Integrante 5 e 6</td></tr></tbody></table>'),
(7,'CRUD e autenticação','Integração do CRUD com cadastro de usuários, login, sessões e controle de acesso.',
'<h3>Objetivo da semana</h3><p>Revisar o CRUD, implementar autenticação e proteger páginas da aplicação usando sessões e controle de acesso.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>Revisão e integração do CRUD; introdução à autenticação, cadastro de usuários, login, sessões e controle de acesso.</td><td>Integrante 1</td></tr><tr><td>Questionário</td><td>CRUD, autenticação, sessões e controle de acesso.</td><td>Integrante 3 e 5</td></tr><tr><td>Atividade prática</td><td>Implementar cadastro e login de usuários e proteger páginas da aplicação.</td><td>Integrante 2 e 6</td></tr><tr><td>Exercício/desafio</td><td>Integrar o sistema de autenticação ao CRUD desenvolvido anteriormente.</td><td>Integrante 4 e 5</td></tr></tbody></table>'),
(8,'API REST e projeto integrador','Endpoints, métodos HTTP, JSON, integração entre front-end e back-end e finalização do projeto.',
'<h3>Objetivo da semana</h3><p>Compreender os conceitos de API REST, criar ou consumir endpoints, trabalhar com JSON e integrar as partes do projeto final.</p><table><thead><tr><th>Item</th><th>Tema / tarefa</th><th>Responsável</th></tr></thead><tbody><tr><td>Videoaula</td><td>API REST, endpoints, métodos HTTP, JSON e integração entre front-end e back-end.</td><td>Integrante 2</td></tr><tr><td>Questionário</td><td>Revisão dos principais conteúdos do curso e conceitos de API.</td><td>Integrante 1 e 4</td></tr><tr><td>Atividade prática</td><td>Criar ou consumir endpoints e integrar os dados ao front-end utilizando JavaScript.</td><td>Integrante 3 e 5</td></tr><tr><td>Projeto/desafio final</td><td>Integrar HTML, CSS, JavaScript, PHP, MySQL, CRUD, autenticação e API; realizar testes e corrigir problemas.</td><td>Todos os integrantes</td></tr></tbody></table>');

INSERT INTO quiz_questions(week_no,question,option_a,option_b,option_c,option_d,correct_option) VALUES
(1,'Qual tecnologia estrutura o conteúdo de uma página web?','CSS','HTML','MySQL','PHP','B'),
(1,'Qual tecnologia define cores, fontes, espaçamentos e aparência visual?','HTML','CSS','PHP','MySQL','B'),
(2,'Qual palavra-chave pode declarar uma variável em JavaScript moderno?','let','echo','SELECT','include','A'),
(2,'Qual estrutura permite executar um bloco apenas quando uma condição é verdadeira?','if','table','head','commit','A'),
(3,'Qual comando registra uma versão no Git?','commit','select','echo','include','A'),
(3,'Qual linguagem será usada no back-end do curso?','Python','Java','PHP','C#','C'),
(4,'Qual estrutura é adequada para percorrer arrays em PHP?','foreach','switch','include','echo','A'),
(4,'Para reutilizar trechos de lógica usamos principalmente:','funções','comentários','tabelas','cookies','A'),
(5,'Qual superglobal recebe dados enviados por POST?','$_POST','$_GET','$_SESSION','$_COOKIE','A'),
(5,'Qual recurso mantém informações entre requisições do mesmo usuário?','Sessão','CSS','DNS','HTML','A'),
(6,'A letra U do CRUD significa:','Upload','Update','User','URL','B'),
(6,'Qual operação do CRUD remove um registro?','Create','Read','Update','Delete','D'),
(7,'Qual recurso do PHP deve ser usado para armazenar senhas com segurança?','password_hash','md5 simples','texto puro','base64','A'),
(7,'O controle de acesso serve principalmente para:','proteger páginas conforme o usuário logado','mudar a cor do site','criar imagens','formatar texto','A'),
(8,'Em uma API REST, os dados são frequentemente trocados em:','JSON','BMP','DOCX','PSD','A'),
(8,'A integração final do curso reúne:','Somente HTML','Front-end, PHP, banco, CRUD, autenticação e API','Somente MySQL','Somente JavaScript','B');
