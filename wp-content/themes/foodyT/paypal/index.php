<?php
include_once("config.php");
?>


<h2 align="center">Test Products</h2>
<div class="product_wrapper">
<table class="procut_item" border="0" cellpadding="4">
  <tr>
   
    <td width="30%">
  <form method="post" action="process.php?paypal=checkout">
  	  <input type="hidden" name="itemname" value="Canon EOS Rebel XS" /> 
  	  <input type="hidden" name="itemnumber" value="10000" /> 
      <input type="hidden" name="itemdesc" value="Capture all your special moments with the Canon EOS Rebel XS/1000D DSLR camera and cherish the memories over and over again." /> 
      <input type="hidden" name="itemprice" value="225.00" />
  	  <input type="hidden" name="itemQty" value="1" />
      <input class="dw_button" type="submit" name="submitbutt" value="Paypal" />
    </form>
    </td>
  </tr>
</table>


</div>
</body>
</html>
