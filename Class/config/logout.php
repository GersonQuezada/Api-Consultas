<?php
session_start();
unset($_SESSION["s_usuario"]);
session_destroy();
header("Location: http://".$_SERVER['HTTP_HOST'].'/consultas.credimujer.pe/index.html'); 
?>
<input id="Usuario" name="Usuario" type="hidden" value="<?php echo $_SESSION['login']; ?>">
<input id="Token" name="Token" type="hidden" value="<?php echo $_SESSION['Token']; ?>">
<script>
    $(function () {
        var Usuario =  document.getElementById('Usuario').value;
        var Token =  document.getElementById('Token').value;
        var url = 'app/CRUD/API_REST/auth';

        var data = {"login":Usuario,"Token":Token};
        fetch(url, {
        method: 'PUT', // or 'PUT'
        body: JSON.stringify(data), // data can be `string` or {object}!
        headers:{
            'Content-Type': 'application/json'
            }
        }).then(
            res => res.json()
        )
        .catch(error => console.error('Error:', error))
        .then(response => {       
            console.log(response); 
        } );

    });
</script>