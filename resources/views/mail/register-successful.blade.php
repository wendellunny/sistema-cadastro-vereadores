<style>
    #container-email{
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    #container-email h1{
        font-size: 2.2rem;

    }
    #container-email p{
        font-size: 1.1rem;

    }

</style>

<div id="container-email">
    <h1>Olá {{$user}}, você foi registrado com sucesso</h1>
    <p>
        {{$user}},você foi registrado no sistema de cadastro da camara municipal de vereadores.
    </p>
</div>
