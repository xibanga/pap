<?php

$moedas = array(
    "Portugal EUR €",
    "Espanha EUR €",
    "França EUR €",
    "Alemanha EUR €",
    "Itália EUR €",
    "Reino Unido GBP £",
    "Estados Unidos USD $",
    "Canadá CAD $",
    "Brasil BRL R$",
    "Japão JPY ¥",
    "China CNY ¥",
    "Rússia RUB ₽",
    "Austrália AUD $",
    "Nova Zelândia NZD $",
    "Suíça CHF",
    "Suécia SEK",
    "Noruega NOK",
    "Dinamarca DKK",
    "Polónia PLN",
    "Hungria HUF",
    "República Checa CZK",
    "Eslováquia EUR €",
    "Eslovénia EUR €",
    "Croácia EUR €",
    "Bósnia e Herzegovina EUR €",
    "Sérvia EUR €",
    "Montenegro EUR €",
    "Albânia EUR €",
    "Macedónia EUR €",
    "Kosovo EUR €",
    "Bulgária BGN",
    "Roménia RON",
    "Grécia EUR €",
    "Turquia TRY",
);

function listar(){
    global $moedas;
    $result = "";

    foreach ($moedas as $moeda) {
        $result .= "<option value='$moeda'>$moeda</option>";
    }

    return $result;
}

?>