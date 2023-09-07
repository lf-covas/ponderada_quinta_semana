<h1>Ponderada: Elaboração de aplicação integrada a um banco de dados na AWS</h1>

<h2>Descrição:</h2>

<h4>Arquivo SamplePage.php</h4>
<p>Neste repositório, você encontrará uma pasta chamada "Backend_frontend". Dentro dessa pasta, você terá acesso a um arquivo chamado "SamplePage.php", onde está o código do frontend. Este código inclui dois formulários que podem ser preenchidos pelo usuário. O primeiro formulário solicita informações como nome e endereço, enquanto o segundo solicita detalhes como CPF, idade, data de nascimento e estado civil do usuário.

Além disso, dentro desse mesmo arquivo, você encontrará o código responsável pela criação das tabelas em nosso banco de dados MySQL. Também há integração entre o frontend e o backend para garantir que os dados sejam armazenados corretamente em nosso banco de dados, que está hospedado em um RDS da AWS.</p>

<h4>Arquivo dbinfo.inc</h4>
<p>O arquivo "dbinfo.inc" desempenha um papel fundamental ao estabelecer a conexão entre nosso arquivo "SamplePage.php" (responsável pelo frontend e backend) hospedado em uma EC2 na AWS e nosso banco de dados, que reside em um RDS também na AWS. Este arquivo contém as seguintes informações essenciais:

DB_SERVER: Endereço do endpoint onde nosso banco de dados está localizado.

DB_USERNAME: Nome de usuário utilizado para acessar o banco de dados.

DB_PASSWORD: Senha cadastrada para autenticar o acesso ao banco de dados.

DB_DATABASE: Nome do banco de dados que desejamos acessar.

Com esses dados, incorporados em nosso código PHP presente no arquivo, conseguimos estabelecer a conexão necessária para utilizar nosso banco de dados no RDS com sucesso.
</p>