<div class="container">
  <div class="panel">
    <h1>Sign In to Mahlzeit</h1>
    <p>Signing in lets you see updates based on your preferences, and also lets you write reviews.</p>
    <?php if(isset($resultmessg))echo $resultmessg; ?>
    <form method="post" onsubmit="return handlesignin(event)">
      <table style="margin:auto;">
        <tr>
          <td><label>email id</label></td>
          <td><input type="email" name="emailid" minlength="6" maxlength="64" pattern=".{6,64}" required placeholder="at least 6 characters" 
          <?php if(isset($_POST) && isset($_POST['emailid'])) echo 'value="' . $_POST['emailid'] . '"'; else echo 'autofocus';?>
          ></td>
        </tr>
        <tr>
          <td><label>Password</label></td>
          <td><input type="password" name="password" minlength="6" maxlength="64" pattern=".{6,64}" required autofocus placeholder="at least 6 characters"></td></tr>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit">Sign In</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
  var handlesignin = function(event){
    // this method not really needed, as validations are needed only at control level - these are handled by html5 validations.

    // event.preventDefault();
    var formelement = event.target;

    var emailid = formelement.querySelector('input[name=emailid]').value;
    var password = formelement.querySelector('input[name=password]').value;

    if(!(emailid.length>5) || !(password.length>5)){
      alert("one or more inputs don\'t seem right. Please check their length");
      return false;
    }
    return true;
  };
</script>
