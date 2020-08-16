<html>
    <body>
        <h2 style="font-weight: normal;">Confirmação: <b>{{ $objeto->processo->descricao }}</b></h2>
        
        <br/>
        <br/>
        <p style="color: gray;"><i>Este é um email automático enviado pelo sistema, não responda este email!</i> </p>
        <p></p>
        © Equipe {{config('app.name')}} <br/>
    Contato: <a href="mailto:{{$email}}">{{$email}}</a></p>
    @if(config('app.debug'))
    <button class="btn btn-secondary botao-barra" type="button" onclick="window.location.href = '/'">Home</button>
    @endif
    </body>
</html>