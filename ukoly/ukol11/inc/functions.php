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
            jmeno, email, id_fak, cena, datum
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
            *
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