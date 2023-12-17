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


    function zakaznik_faktura($pdo, $id) {
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

    function zakaznik_podle_id($id, $pdo) {
        $query = "SELECT * FROM zakaznik WHERE id_zak=$id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        }
        return false;
    }

    function faktura($id, $pdo, $order=false, $desc=false) {
        $query = "SELECT 
            id_fak, cena_fak, cena, nazev, pocet, zbozi_id, zakaznik_id
            FROM faktura
            JOIN faktura_zbozi ON id_fak = faktura_id
            JOIN zbozi ON zbozi_id = id_zbozi
            WHERE id_fak = $id";

        if ($order) {
            $query .= " ORDER BY " .$order;
        }

        if ($desc) {
            $query .= " DESC";
        }

        $query .= ";";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function vypis_faktury($pdo, $order=false, $desc=false) {
        $query = "SELECT 
            id_fak, jmeno, email, cena_fak, zakaznik_id
            FROM faktura
            JOIN zakaznik ON id_zak = zakaznik_id";

        if ($order) {
            $query .= " ORDER BY " .$order;
        }

        if ($desc) {
            $query .= " DESC";
        }

        $query .= ";";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function vypis_zbozi($pdo, $order=false, $desc=false) {

        $query = "SELECT * FROM zbozi";
        if ($order) {
            $query .= " ORDER BY $order";
        }

        if ($desc) {
            $query .= " DESC";
        }

        $query .= ";";
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

    function vypis_objednavku($id_fak, $pdo) {
        $query = "SELECT zbozi_id, pocet FROM faktura_zbozi WHERE faktura_id = $id_fak;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        if ($results) {
            return $results;
        }

        return false;
    }

    function uzivatel_podle_jmena($username, $pdo) {
        $query = "SELECT * FROM users WHERE username = :name LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam("name", $username);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);

        $stmt = null;

        if ($results) {
            return $results;
        }

        return false;
    }

    function uzivatel_prihlasen($username, $password, $pdo) {
        $query = "SELECT * FROM users WHERE username = :name LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam("name", $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = null;

        if ($row && password_verify($password, $row["password"])) {
            return $row;
        }

        return false;
    }

    function permissions($role_id) {
        switch ($role_id) {
            case 0:
                return "all";
            case 1:
                return "read";
            default:
                return false;
        }
    }