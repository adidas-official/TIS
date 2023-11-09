
    function allPassed(a) {
        return a.every(item => item == 1);
    }

    function evaluate(formular) {

        const empty = "";
        const info = document.getElementById("infowindow");
        const predcisli = [60, 72, 73, 77];
        const emailPattern = /^[a-z][\w-+~_.]*@[a-z][\w-+~_.]*\.[a-z][\w-+~_]\w*/;
        const spzPattern = /^\w{7}/;
        const vinPattern = /(\w)(\w)(\w)(\w{5})(\w)(\w)(\w)(\w{6})/;

        let checks = [0, 0, 0, 0, 0];

        let jmeno = formular["jmeno"].value;
        let telefon = formular["telefon"].value;
        let sendto = formular["sendto"].value.toLowerCase();
        let spz = formular["spz"].value.toLowerCase();
        let vin = formular["vincode"].value.toLowerCase();
        const vinGroups = vinPattern.exec(vin);

        if (jmeno.length < 4 || jmeno == empty) {
            document.getElementById("failJmeno").textContent = "Jmeno musi mit alespon 4 znaky";
            checks[0] = 0;
        } else {
            checks[0] = 1;
        }

        if (!predcisli.some(cislo => telefon.includes(parseInt(cislo)))) {
            document.getElementById("failTel").textContent = "Telefonni cislo musi zacinat 60, 72, 73 nebo 77";
            checks[1] = 0;
        } else {
            checks[1] = 1;
        }

        if (!emailPattern.test(sendto)) {
            document.getElementById("failEmail").textContent = "Zadejte email v pozadovanem formatu";
            checks[2] = 0;
        } else {
            checks[2] = 1;
        }

        if (!spzPattern.test(spz)) {
            document.getElementById("failSPZ").textContent = "Zadejte spz ve spravnem tvaru XXXXXXX";
            checks[3] = 0;
        } else {
            checks[3] = 1;
    }

    if (!vinGroups) {
        document.getElementById("failVIN").textContent = "VIN je 17 znaku dlouhe a tvori ho pismena a cisla";
        checks[4] = 0;
    } else {
        checks[4] = 1;
    }

    if (allPassed(checks)) {
        let subject = "Cviceni 7";
        formular.action = `mailto:${sendto}?subject=${encodeURIComponent(subject)}&body=''`;

        // this opens the default email client. 
        return true;
    }


    return false;
    
}

function formBehavior() {

    const formular = document.forms["phishing_for_cars"];

    // reset warnings
    let warningWindows = formular.querySelectorAll("span");
    warningWindows.forEach(span => {
        span.textContent = "";
    });

    // check values, if all ok : true ? false
    return evaluate(formular);

}
