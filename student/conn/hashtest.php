<html>
    <body>
<p>
<?php

echo password_hash("docent123", PASSWORD_DEFAULT);
echo PHP_EOL . "<br>";
echo password_hash("adminstratie123", PASSWORD_DEFAULT);

?>
</p>
    </body>
</html>