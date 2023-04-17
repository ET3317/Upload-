<?php
// Je vérifie si le formulaire est soumis 
if($_SERVER['REQUEST_METHOD'] === "POST"){
   
    // chemin vers un dossier sur serveur pour fichiers uploadés
    $uploadDir = 'public/upload/';
    //  nom fichier généré à partir du poste user
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    // récupération extension du fichier (path + name)
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // extensions autorisées
    $authorizedExtensions = ['jpg','jpeg','png', 'gif', 'webp'];
    // Le poids max (défaut 2mo)
    $maxFileSize = 1000000;
    $errors=[];
 
    /****** if extension est ok *************/
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de Jpeg, Png, Gif ou Webp !';
    }

    /****** if image existe && si poids max ok *************/
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
