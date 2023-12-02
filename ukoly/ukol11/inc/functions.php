<?php 
    function vypis_zakazniky($pdo) {
        $query = "SELECT * FROM zakaznik;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }


    function zakaznik($pdo, $id) {
        $query = "SELECT
            jmeno, email, id_fak, cena_fak, datum, id_zak
            FROM zakaznik
            LEFT JOIN faktura ON id_zak = zakaznik_id
            WHERE id_zak = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function faktura($pdo, $id) {
        $query = "SELECT 
            id_fak, cena_fak, cena, nazev, pocet, zbozi_id, zakaznik_id
            FROM faktura
            JOIN faktura_zbozi ON id_fak = faktura_id
            JOIN zbozi ON zbozi_id = id_zbozi
            WHERE id_fak = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function vypis_zbozi($pdo) {
    
        $query = "SELECT * FROM zbozi;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function najdi_zbozi_podle_id($id, $pdo) {

        $query = "SELECT * FROM zbozi WHERE id_zbozi = $id LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        }

        return false;

    }

    function najdi_fakturu_podle_id($id, $pdo) {

        $query = "SELECT * FROM faktura WHERE id_fak = $id LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        }

        return false;

    }