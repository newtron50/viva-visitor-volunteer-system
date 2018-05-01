<?php
////   test data info

$ssn='SJA';
$school_name='St John the Apostle Catholic School';
$location='Office';
$loc_id = 'a';
/* edit barcode type.
    1 = fixed (reusable, original)
    2 = generated for label use
*/
$bctype = 2;
/* Program limitations
 1 = Volunteers Only
 2 = Visitors Only
 3 = Visitors and Volunteers
*/

$fc=3;

/* have volunteers add themselves?
-- This is not recommended as group volunteer tracking can
get easily messed up with group assignments

$avm = 1  ... added by administrative desk
$avm = 2  ... added by volunteers themselves (self registration)
*/

$avm = 2;

/* Group functions --
Highly recommended if using volunteers to register themselves to turn off this function.
Decides whether to help track voluteering by groups
$gpf=1  --  group functions on
$gpf=0  --  group functions off
*/

$gpf= 0;


?>
