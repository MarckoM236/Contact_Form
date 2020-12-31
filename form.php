<?php
if (isset($_POST)&& !empty($_POST)) {
	//form fields
    $name=$_POST['name'];
    $lastname=$_POST['lastname'];
	$email=$_POST['email'];
	$message=$_POST['message'];

	//array input type file
	 $nameimg=$_FILES['imagen']['name'];
     $tmp_nameimg=$_FILES['imagen']['tmp_name'];
     $Typeimg=$_FILES['imagen']['type'];
     $sizeimg=$_FILES['imagen']['size'];
     $errorimg=$_FILES['imagen']['error'];

    //Email structure
	//recipient
    $to = 'marcko236@gmail.com';
    //sender
    $from ='corporativo@petshowe.dx.am';
    $fromName = 'petshowe';

    //email subject
    $subject = 'solicitud cliente';

    //attachment file path
    $extensiones = array(0=>'image/jpg',1=>'image/jpeg',2=>'image/png'); //formatos admitidos
    $max_tamanyo = 1024 * 1024 * 8;//tamaño maximo del archivo
    if ( in_array($_FILES['imagen']['type'], $extensiones) ) {
      //echo 'Es una imagen';
      $file=$tmp_nameimg;
    }

    //email body content
    $htmlContent = '<h1>Requerimientos</h1><br>
    <h2>Tema:</h2>
    <p>'.$message.'</p><br>
    <h2>Datos:</h2><br>
    <p>Nombre: '.$name.' '.$lastname.'</p>
    <p>Email: '.$email.'</p>';

    //header for sender info
    $headers = "From:"."$fromName"."<".$from.">";

    //boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    //headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    //multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    //preparing attachment
    if(!empty($file) > 0){
        if(is_file($file)){
                    $message .= "--{$mime_boundary}\n";
                    $fp =    @fopen($file,"rb");
                    $data =  @fread($fp,$sizeimg);
                    @fclose($fp);

                    $data = chunk_split(base64_encode($data));
                    $message .= "Content-Type: application/octet-stream; name=\"".basename($nameimg)."\"\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"".basename($nameimg)."\"; size=".$sizeimg.";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
         }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    //send email
    $mail = @mail($to, $subject, $message, $headers, $returnpath);

    //email sending status
    echo $mail?"<script> alert('Mensaje enviado con exito')</script>":"<script> alert('No se pudo enviar el mensaje')</script>";
}
?>
<html>
 <head>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

 </head>
 <body>
   <!--Contact Form-->
   <form method="POST" name="form" enctype="multipart/form-data">
   	<div class="form-group">
    <label >Nombres</label>
    <input type="text" class="form-control" id="inputNombres" aria-describedby="emailHelp" placeholder="Escribe tu nombre" name="name" style="border-color: #FF8000;" required="">
  </div>
  <div class="form-group">
    <label >Apellidos</label>
    <input type="text" class="form-control" id="inputApellidos" aria-describedby="emailHelp" placeholder="Escribe tu apelido" name="lastname" style="border-color: #FF8000;" required="">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Escribe tu email" name="email" style="border-color: #FF8000;" required="">
  </div>
  <div class="form-group">
    <label for="ExampleInputMensaje">Mensaje</label>
    <textarea class="form-control" id="inputMensaje" placeholder="Escribe tus inquietudes o ideas" name="message" style="border-color: #FF8000;" required=""></textarea>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Imagenes</label>
    <input type="file" name="imagen" style="border-color: #FF8000;">
  </div>
  <button type="submit" class="btn " style="background-color: #FF8000;">Enviar</button>
</form>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

 </body>
</html>