<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php


    echo "<h1>Tablero de Ajedrez<h1>";
    echo "<table border = 1 id='tabla-ajedrez'> ";
    echo "<tbody >";
    $position = 0;
    $id = 0;
    for ($a=1; $a <=7 ; $a++) {
        echo "<tr>";
        for ($i=1; $i <=7 ; $i++) {

            if (($position%2) !== 0)
            {
                echo "<td style='width:40px;height:40px; background-color:black; color:white' id='celda-$position-$id' onclick='find($position , $id)'  >
                        <p style='font-size: 12px;' name='p-$position-$id' id='p-$position-$id'>
                            $position
                        </p>
                    </td>";
            } else {
                echo "<td style='width:40px;height:40px' id='celda-$position-$id' onclick='find($position, $id)' >
                        <p style='font-size: 12px;' name='p-$position-$id' id='p-$position-$id'>
                            $position
                        </p>
                    </td>";
            }
            $position++;
            $id++;

            if( $position === 25) {
                $id = 1;
            }

        }

    }
    echo "</tbody>";
    echo "</table>";
    echo "<button id='save' onclick=save() type='button'>Guardar txt</button>";
    ?>
<script>

    var  emplyee=[];


    function find(position, id)
    {
        var url = "/find/" + id;
        var parrafo = $('#p-'+ position+'-'+ id);
        var celda = $('#celda-'+position+'-'+ id);

        $.ajax({
                type: "GET",
                url: url,

                success: function(response, id)
                {
                    if (typeof response.id === "undefined" ) {

                        celda.css("background-color", "red");
                        celda.text('');

                    } else {

                        parrafo.text(response.id + ', ' + response.employee_name + ', ' + response.employee_salary + ', '+response.employee_age + ', '+ response.profile_image);


                        if (! emplyee.includes(parrafo.text())) {

                            emplyee.push(parrafo.text());
                        }
                    }

                },
                error:function(error){

                    console.log(error.message);
                }
            });
    }

   function save()
   {
        console.log( emplyee);
        var url = "/save";
        $.ajax({
                type: "POST",
                data: {'data': emplyee},
                url: url,

                success: function(response)
                {
                    console.log(response);

                },
                error:function(error){

                    console.log(error.message);
                }
            });
   }
</script>
</body>
</html>
