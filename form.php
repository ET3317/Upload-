<?php
// Je vérifie que le formulaire est soumis


// Je vérifie si le formulaire est soumis comme d'habitude
if($_SERVER['REQUEST_METHOD'] === "POST"){
    // Securité en php
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés
    $uploadDir = 'public/upload/';
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
    $authorizedExtensions = ['jpg','jpeg','png', 'gif', 'webp'];
    // Le poids max géré par PHP par défaut est de 2M
    $maxFileSize = 1000000;
    $errors=[];
    // Je sécurise et effectue mes tests
    /****** Si l'extension est autorisée *************/
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou Gif ou Webp !';
    }

    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (empty($errors)){
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }else{
        foreach ($errors as $error){
            echo $error . '<br>';
        }
    }
     if(file_exists($uploadFile)){
         echo '<img src="' . $uploadFile . '" alt="upload-avatar">';
     }

}
?>
<form method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>