<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cviceni 7</title>
    <style>
        body {
            background-color: dimgray;
            color: ghostwhite;
        }
    </style>
</head>
<body>

    <h1>Cviceni 7</h1>

    <p>Vytvořte stránku, která bude obsahovat min 4 formulářové prvky. Tyto prvky budou po odeslání (událost onsubmit) kontrolovány pomocí javascriptu takto:</p>
    <ol>
        <li>Jeden formulářový prvek bude kontrolován na neprázdnost.</li>
        <li>Jeden formulářový prvek bude kontrolován na délku znaků.</li>
        <li>Jeden formulářový prvek bude kontrolován pomocí regulárního výrazu (například rodné číslo, spz. auta,DIČ, datum, atd.).</li>
        <li>Jeden formulářový prvek bude obsahovat číslo. Bude se kontrolovat reálnost tohoto čísla (např. den od 1 do 31).</li>
        <li>Formulář bude odesílaný na e-mailovou adresu (&lt;form action=mailto:....</li>
        <li>Formulář se odešle v případě, že bude správně vyplněný.</li>
    </ol>

    <form name="phishing_for_cars" action="mailto:habahaba0123@gmail.com?subject=test" method="post" enctype="text/plain" onsubmit="return formBehavior()">
        <p><input type="text" name="jmeno" id="" placeholder="jmeno ridice"><span id="failJmeno"><span></p> <!-- neprazdnost -->
        <p><input type="number" name="telefon" id="telefon" placeholder="telefon" minlength="9"><span id="failTel"></span></p> <!-- kontrola predcisli -->
        <p><input type="text" name="sendto" id="" placeholder="email"><span id="failEmail"></span></p> <!-- email -->
        <p><input type="text" name="spz" id="spz" placeholder="spz (bez pomlcky, bez mezery)"><span id="failSPZ"></span></p> <!-- regex -->
        <p><input type="text" name="vincode" id="vin" placeholder="VIN" maxlength="17" minlength="17"><span id="failVIN"></span></p> <!-- regex, length -->
        <button type="submit">Odeslat</button>
    </form>    

    <span id="megafail"></span>

</body>
<script src="sendmail.js" defer></script>
</html>