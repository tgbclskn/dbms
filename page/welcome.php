<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lancr.</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Permanent+Marker&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="welcome.css">
</head>

<body>
    <div id="left-side" class="side">
        <h2 class="title">
            Get things done for
            <span class="fancy">buyers</span>
        </h2>
    </div>
    <div id="right-side" class="side">
        <h2 class="title">
            Get things done by
            <span class="fancy">sellers</span>
        </h2>
    </div>



    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const left = document.getElementById("left-side");

            const handleMove = e => {
                left.style.width = `${e.clientX / window.innerWidth * 100}%`;
            }

            document.onmousemove = e => handleMove(e);
            document.ontouchmove = e => handleMove(e.touches[0]);
        });
    </script>
</body>

</html>