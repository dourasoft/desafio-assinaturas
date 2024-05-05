<!DOCTYPE html>
<html>
<head>
<title>Nota fiscal criada com sucesso!</title>
</head>
<body>

<h1>Olá, {{ $data['name'] }}!</h1>
<p>O seu cadastro de número  <b>{{ $data['codigo'] }}</b> tem uma nova fatura.</p>
<br>
<p>Dados:</p>
<br>
<p>Valor: R$ {{ $data['valor'] }}</p>
<p>Data de Vencimento: {{ $data['vencimento'] }}</p>
<br>
<p>Equipe <b>DouraSoft.</b></p>
</body>
</html>