<?php

/************************************************/
/***************** ATTENZIONE *******************/
/************************************************/
/*
In questo esempio uso una query scritta a mano.
E' buona abitudine preferire i prepared statements,
così da essere ragionevolmente sicuri in query che 
usano dati ricevuti dall'utente.
*/

//Creo queste variabili fuori dal try/catch così che siano visibili anche fuori (le stampo in pagina)
$msg_result = "Nessuna connessione";
$docenti = [];

try {
    // Mi connetto al database
    $db = new mysqli("localhost", "root", "", "university"); //le credenziali andrebbero in constanti in un file apposito

    //eseguo la query
    $query_sql = "SELECT id, name, surname, email FROM teachers";
    $query_result = $db->query($query_sql);

    //copio i risultati in un array
    //questo metodo prende TUTTE le righe e le converte in array associativo
    //l'argomento "1" è necessario per dirgli che vogliamo degli array associativi
    $docenti = $query_result->fetch_all(1);

    //Se siamo arrivati fin qui, tutto è andato bene
    $msg_result = "La query ha restituto $query_result->num_rows risultati";
    
    //Chiudo la connessione
    $db->close();

} catch (Exception $err) {
    $msg_result = "Ops... Si è verificato un errore: " . $err->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + mySQL</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Hello PHP/mySQL World</h1>

    <h2>Esito: <?= $msg_result ?></h2>

    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>NOME</td>
                <td>COGNOME</td>
                <td>EMAIL</td>
        </thead>
        <tbody>
            <?php foreach ($docenti as $docente) { ?>
                <tr>
                    <td><?= $docente["id"] ?></td>
                    <td><?= $docente["name"] ?></td>
                    <td><?= $docente["surname"] ?></td>
                    <td><?= $docente["email"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>