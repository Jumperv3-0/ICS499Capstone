<?php
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */
$timeTarget = 0.05; // 50 milliseconds

$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost . "<br>";

/**
 * We just want to hash our password using the current DEFAULT algorithm.
 * This is presently BCRYPT, and will produce a 60 character result.
 *
 * Beware that DEFAULT may change over time, so you would want to prepare
 * By allowing your storage to expand past 60 characters (255 would be good)
 */
$p1 = password_hash("gary", PASSWORD_DEFAULT);
$p2 = password_hash("yeshewa", PASSWORD_DEFAULT);


echo $p1 . "<br>";
echo $p2  . "<br>";

echo password_verify( 'gary', $p1) . "<br>";
echo password_verify( 'gary', $p2) . "<br>";

$a = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

var_dump(password_get_info($a));
//change every refresh
var_dump($a);

?>
