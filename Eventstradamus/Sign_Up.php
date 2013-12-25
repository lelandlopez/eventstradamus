<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="Check_Sign_Up.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>Sign Up </strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="username" type="text" id="username"></td>
</tr>
<tr>
<?php
if(isset($_GET['err'])){
	if($_GET['err']==1){
		echo "you need to repeat the passwords";
	} else if ($_GET['err']==2){
		echo "the username entered is already taken";
	}
}
?>
<td>Password</td>
<td>:</td>
<td><input name="password1" type="text" id="password1"></td>
</tr>

<tr>
<td>Repeat Password</td>
<td>:</td>
<td><input name="password2" type="text" id="password2"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Sign Up"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>